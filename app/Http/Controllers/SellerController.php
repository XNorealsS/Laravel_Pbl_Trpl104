<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Pesan;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\Ulasan;
use App\Models\Umkm;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    private const TABS = ['overview', 'products', 'orders', 'profile', 'reviews'];

    public function index(Request $request)
    {
        $activeTab = $this->resolveTab($request->query('tab'), 'overview');
        $umkm = $this->getSellerUmkm();
        if (!$umkm) {
            return redirect()->route('login')->with('error', 'Silakan masuk sebagai Seller.');
        }

        $kategoriList = Kategori::orderBy('nama_kategori')->get();
        $produk = $umkm->produk()->with('kategori')->orderBy('nama_produk')->get();

        $pesananList = Pesanan::where('id_umkm', $umkm->id_umkm)
            ->with(['pengunjung', 'umkm'])
            ->latest()
            ->get();

        $chatPengunjung = Pesan::where('id_umkm', $umkm->id_umkm)
            ->with('pengunjung')
            ->orderBy('waktu', 'asc')
            ->get()
            ->groupBy('id_pengunjung');

        $ulasanList = Ulasan::where('id_umkm', $umkm->id_umkm)
            ->with('pengunjung')
            ->latest()
            ->get();

        $rataRating = $ulasanList->avg('rating');

        return view('seller.dashboard', compact(
            'activeTab',
            'umkm',
            'kategoriList',
            'produk',
            'pesananList',
            'chatPengunjung',
            'ulasanList',
            'rataRating'
        ));
    }

    public function updateProfile(Request $request)
    {
        $umkm = $this->getSellerUmkm();
        if (!$umkm) {
            return $this->redirectToTab($request, 'profile')->with('error', 'Lapak tidak ditemukan');
        }

        $data = $request->validate([
            'nama_usaha' => 'required|string|max:150',
            'area' => 'required|string|max:100',
            'lokasi' => 'required|string|max:255',
            'kontak' => 'required|string|max:30',
            'deskripsi' => 'nullable|string',
            'foto_url' => 'nullable|url|max:255',
        ]);

        $fotoUsaha = $umkm->foto_usaha;
        if ($request->filled('foto_url')) {
            $rawUrl = trim((string) $data['foto_url']);
            $basePrefix = rtrim(url('/'), '/') . '/';

            // Simpan path relatif jika URL mengarah ke storage lokal aplikasi
            if (str_starts_with($rawUrl, $basePrefix)) {
                $relPath = ltrim(substr($rawUrl, strlen($basePrefix)), '/');
                $fotoUsaha = str_starts_with($relPath, 'storage/') ? substr($relPath, strlen('storage/')) : $relPath;
            } else {
                $fotoUsaha = $rawUrl;
            }
        }

        $umkm->update([
            'nama_usaha' => $data['nama_usaha'],
            'area' => $data['area'],
            'lokasi' => $data['lokasi'],
            'kontak' => $data['kontak'],
            'deskripsi' => $data['deskripsi'] ?? null,
            'foto_usaha' => $fotoUsaha,
        ]);

        return $this->redirectToTab($request, 'profile')->with('success', 'Profil UMKM berhasil diperbarui!');
    }

    public function storeProduct(Request $request)
    {
        $umkm = $this->getSellerUmkm();
        if (!$umkm) {
            return $this->redirectToTab($request, 'products')->with('error', 'Lapak tidak ditemukan');
        }

        $data = $request->validate([
            'nama_produk' => 'required|string|max:150',
            'id_kategori' => 'required|integer',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
        ]);

        Produk::create([
            'id_umkm' => $umkm->id_umkm,
            'id_kategori' => $data['id_kategori'],
            'nama_produk' => $data['nama_produk'],
            'harga' => $data['harga'],
            'deskripsi' => $data['deskripsi'] ?? null,
            'foto_produk' => null,
            'tersedia' => true,
        ]);

        return $this->redirectToTab($request, 'products')->with('success', 'Menu produk baru berhasil ditambahkan!');
    }

    public function updateProduct(Request $request, int $id)
    {
        $umkm = $this->getSellerUmkm();
        $produk = Produk::where('id_produk', $id)->where('id_umkm', $umkm->id_umkm)->firstOrFail();

        $data = $request->validate([
            'nama_produk' => 'required|string|max:150',
            'id_kategori' => 'required|integer',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
        ]);

        $produk->update([
            'nama_produk' => $data['nama_produk'],
            'id_kategori' => $data['id_kategori'],
            'harga' => $data['harga'],
            'deskripsi' => $data['deskripsi'] ?? null,
            'tersedia' => $request->has('tersedia'),
        ]);

        return $this->redirectToTab($request, 'products')->with('success', 'Menu produk berhasil diperbarui!');
    }

    public function deleteProduct(Request $request, int $id)
    {
        $umkm = $this->getSellerUmkm();
        Produk::where('id_produk', $id)->where('id_umkm', $umkm->id_umkm)->delete();

        return $this->redirectToTab($request, 'products')->with('success', 'Produk berhasil dihapus!');
    }

    public function toggleProductAvailability(Request $request, int $id)
    {
        $umkm = $this->getSellerUmkm();
        $produk = Produk::where('id_produk', $id)->where('id_umkm', $umkm->id_umkm)->firstOrFail();

        $produk->update(['tersedia' => !$produk->tersedia]);

        $statusText = $produk->tersedia ? 'Tersedia' : 'Kosong / Habis';
        return $this->redirectToTab($request, 'products')
            ->with('success', "Status ketersediaan \"{$produk->nama_produk}\" berhasil diubah menjadi: {$statusText}");
    }

    public function updateOrderStatus(Request $request, int $id)
    {
        $data = $request->validate([
            'status' => 'required|in:diproses,selesai',
        ]);

        $umkm = $this->getSellerUmkm();
        if (!$umkm) {
            return $this->redirectToTab($request, 'orders')->with('error', 'Lapak tidak ditemukan.');
        }

        $pesanan = Pesanan::where('id_pesanan', $id)->where('id_umkm', $umkm->id_umkm)->firstOrFail();
        $status = $data['status'];

        // Pesanan hanya boleh diselesaikan setelah pembayaran berstatus lunas
        if ($status === 'selesai' && $pesanan->status_pembayaran !== 'lunas') {
            return $this->redirectToTab($request, 'orders')
                ->with('error', 'Pesanan #' . $id . ' belum dapat diselesaikan karena pembayaran belum diverifikasi LUNAS.');
        }

        $pesanan->update([
            'status' => $status,
            'waktu_selesai' => $status === 'selesai' ? now() : null,
        ]);

        return $this->redirectToTab($request, 'orders')
            ->with('success', 'Status pesanan berhasil diubah menjadi: ' . strtoupper($status) . '! Tombol ulasan kini aktif untuk pembeli.');
    }

    public function verifyPayment(Request $request, int $id)
    {
        $data = $request->validate([
            'status' => 'required|in:lunas,ditolak',
            'catatan' => 'nullable|string|max:255',
        ]);

        $umkm = $this->getSellerUmkm();
        if (!$umkm) {
            return $this->redirectToTab($request, 'orders')->with('error', 'Lapak tidak ditemukan.');
        }

        $pesanan = Pesanan::where('id_pesanan', $id)->where('id_umkm', $umkm->id_umkm)->firstOrFail();
        $status = $data['status'];
        $catatan = trim((string) ($data['catatan'] ?? ''));

        $pesanan->update([
            'status_pembayaran' => $status,
            'catatan_admin' => $status === 'lunas' ? null : ($catatan ?: null),
        ]);

        return $this->redirectToTab($request, 'orders')
            ->with('success', 'Status pembayaran pesanan #' . $id . ' berhasil diubah menjadi: ' . strtoupper($status));
    }

    public function replyMessage(Request $request)
    {
        $umkm = $this->getSellerUmkm();
        $data = $request->validate([
            'id_pengunjung' => 'required|integer',
            'isi_pesan' => 'required|string',
        ]);

        Pesan::create([
            'id_pengunjung' => $data['id_pengunjung'],
            'id_umkm' => $umkm->id_umkm,
            'pengirim' => 'seller',
            'isi_pesan' => $data['isi_pesan'],
            'waktu' => now(),
        ]);

        return $this->redirectToTab($request, 'orders')->with('success', 'Pesan berhasil dikirim ke pembeli!');
    }

    public function replyReview(Request $request, int $id)
    {
        $umkm = $this->getSellerUmkm();
        if (!$umkm) {
            return $this->redirectToTab($request, 'reviews')->with('error', 'Lapak tidak ditemukan.');
        }

        $ulasan = Ulasan::where('id_ulasan', $id)->where('id_umkm', $umkm->id_umkm)->firstOrFail();

        if ($ulasan->disembunyikan) {
            return $this->redirectToTab($request, 'reviews')
                ->with('error', 'Ulasan yang telah disembunyikan oleh Admin tidak dapat ditanggapi.');
        }

        $data = $request->validate([
            'balasan_seller' => 'required|string|max:500',
        ]);

        $ulasan->update(['balasan_seller' => $data['balasan_seller']]);

        return $this->redirectToTab($request, 'reviews')->with('success', 'Tanggapan ulasan berhasil disimpan!');
    }

    private function resolveTab(?string $tab, string $default = 'overview'): string
    {
        return in_array($tab, self::TABS, true) ? $tab : $default;
    }

    private function getSellerUmkm(): ?Umkm
    {
        $userId = session('user.id_user');
        return $userId ? Umkm::where('id_user', $userId)->first() : null;
    }

    private function redirectToTab(Request $request, string $defaultTab = 'overview')
    {
        $tab = $this->resolveTab($request->input('active_tab'), $defaultTab);

        return $tab === 'overview'
            ? redirect()->route('seller')
            : redirect()->route('seller', ['tab' => $tab]);
    }
}
