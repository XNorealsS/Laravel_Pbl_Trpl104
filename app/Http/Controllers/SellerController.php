<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Pengguna;
use App\Models\Pesan;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\Ulasan;
use App\Models\Umkm;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    private const TABS = ['overview', 'products', 'orders', 'profile', 'reviews'];

    private function resolveTab(?string $tab, string $default = 'overview'): string
    {
        return in_array($tab, self::TABS, true) ? $tab : $default;
    }

    /**
     * Dapatkan UMKM milik seller yang sedang aktif tanpa fallback lintas akun.
     */
    private function getSellerUmkm(): ?Umkm
    {
        $userId = session('user.id_user');
        return $userId ? Umkm::where('id_user', $userId)->first() : null;
    }

    /**
     * Tampilkan Dashboard Seller (UC-05, UC-06, UC-07, UC-08).
     */
    public function index(Request $request)
    {
        $activeTab = $this->resolveTab($request->query('tab'), 'overview');
        $umkm = $this->getSellerUmkm();
        if (!$umkm) {
            return redirect()->route('login')->with('error', 'Silakan masuk sebagai Seller.');
        }

        $kategoriList = Kategori::orderBy('nama_kategori')->get();

        // 1. Produk milik seller
        $produk = $umkm->produk()->with('kategori')->orderBy('nama_produk')->get();

        // 2. Pesan & Pesanan masuk
        $pesananList = Pesanan::where('id_umkm', $umkm->id_umkm)
            ->with(['pengunjung', 'umkm'])
            ->latest()
            ->get();

        // Riwayat chat per pengunjung
        $chatPengunjung = Pesan::where('id_umkm', $umkm->id_umkm)
            ->with('pengunjung')
            ->orderBy('waktu', 'asc')
            ->get()
            ->groupBy('id_pengunjung');

        // 3. Ulasan pembeli
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

    /**
     * Redirect kembali ke tab aktif agar seller tetap berada di halaman aksi.
     */
    private function redirectToTab(Request $request, string $defaultTab = 'overview')
    {
        $tab = $this->resolveTab($request->input('active_tab'), $defaultTab);

        return $tab === 'overview'
            ? redirect()->route('seller')
            : redirect()->route('seller', ['tab' => $tab]);
    }

    /**
     * Update profil UMKM (UC-05, F012).
     */
    public function updateProfile(Request $request)
    {
        $umkm = $this->getSellerUmkm();
        if (!$umkm) return $this->redirectToTab($request, 'profile')->with('error', 'Lapak tidak ditemukan');

        $request->validate([
            'nama_usaha' => 'required|string|max:150',
            'area' => 'required|string|max:100',
            'lokasi' => 'required|string|max:255',
            'kontak' => 'required|string|max:30',
            'deskripsi' => 'nullable|string',
            'foto_url' => 'nullable|url|max:255',
        ]);

        $fotoUsaha = $umkm->foto_usaha;
        if ($request->filled('foto_url')) {
            $rawUrl = trim((string) $request->input('foto_url'));
            $basePrefix = rtrim(url('/'), '/') . '/';
            if (str_starts_with($rawUrl, $basePrefix)) {
                $relPath = ltrim(substr($rawUrl, strlen($basePrefix)), '/');
                $fotoUsaha = str_starts_with($relPath, 'storage/') ? substr($relPath, strlen('storage/')) : $relPath;
            } else {
                $fotoUsaha = $rawUrl;
            }
        }

        $umkm->update([
            'nama_usaha' => $request->input('nama_usaha'),
            'area' => $request->input('area'),
            'lokasi' => $request->input('lokasi'),
            'kontak' => $request->input('kontak'),
            'deskripsi' => $request->input('deskripsi'),
            'foto_usaha' => $fotoUsaha,
        ]);

        return $this->redirectToTab($request, 'profile')->with('success', 'Profil UMKM berhasil diperbarui!');
    }

    /**
     * Tambah produk baru (UC-06, F013).
     */
    public function storeProduct(Request $request)
    {
        $umkm = $this->getSellerUmkm();
        if (!$umkm) return $this->redirectToTab($request, 'products')->with('error', 'Lapak tidak ditemukan');

        $request->validate([
            'nama_produk' => 'required|string|max:150',
            'id_kategori' => 'required|integer',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
        ]);

        Produk::create([
            'id_umkm' => $umkm->id_umkm,
            'id_kategori' => $request->input('id_kategori'),
            'nama_produk' => $request->input('nama_produk'),
            'harga' => $request->input('harga'),
            'deskripsi' => $request->input('deskripsi'),
            'foto_produk' => null,
            'tersedia' => true,
        ]);

        return $this->redirectToTab($request, 'products')->with('success', 'Menu produk baru berhasil ditambahkan!');
    }

    /**
     * Update produk (UC-06).
     */
    public function updateProduct(Request $request, int $id)
    {
        $umkm = $this->getSellerUmkm();
        $produk = Produk::where('id_produk', $id)->where('id_umkm', $umkm->id_umkm)->firstOrFail();

        $request->validate([
            'nama_produk' => 'required|string|max:150',
            'id_kategori' => 'required|integer',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
        ]);

        $produk->update([
            'nama_produk' => $request->input('nama_produk'),
            'id_kategori' => $request->input('id_kategori'),
            'harga' => $request->input('harga'),
            'deskripsi' => $request->input('deskripsi'),
            'tersedia' => $request->has('tersedia'),
        ]);

        return $this->redirectToTab($request, 'products')->with('success', 'Menu produk berhasil diperbarui!');
    }

    /**
     * Hapus produk (UC-06).
     */
    public function deleteProduct(Request $request, int $id)
    {
        $umkm = $this->getSellerUmkm();
        Produk::where('id_produk', $id)->where('id_umkm', $umkm->id_umkm)->delete();

        return $this->redirectToTab($request, 'products')->with('success', 'Produk berhasil dihapus!');
    }

    /**
     * Kosongkan ketersediaan atau aktifkan ketersediaan produk (UC-07 Skenario Alternatif).
     */
    public function toggleProductAvailability(Request $request, int $id)
    {
        $umkm = $this->getSellerUmkm();
        $produk = Produk::where('id_produk', $id)->where('id_umkm', $umkm->id_umkm)->firstOrFail();

        $produk->update([
            'tersedia' => !$produk->tersedia,
        ]);

        $statusText = $produk->tersedia ? 'Tersedia' : 'Kosong / Habis';
        return $this->redirectToTab($request, 'products')->with('success', "Status ketersediaan \"{$produk->nama_produk}\" berhasil diubah menjadi: {$statusText}");
    }

    /**
     * Update status pesanan: "diproses" -> "selesai" (UC-07, F007).
     * Selaras dengan AGENTS.md: hanya bisa diselesaikan setelah pembayaran diverifikasi LUNAS oleh Admin.
     */
    public function updateOrderStatus(Request $request, int $id)
    {
        $request->validate([
            'status' => 'required|in:diproses,selesai',
        ]);

        $umkm = $this->getSellerUmkm();
        if (!$umkm) return $this->redirectToTab($request, 'orders')->with('error', 'Lapak tidak ditemukan.');

        $pesanan = Pesanan::where('id_pesanan', $id)->where('id_umkm', $umkm->id_umkm)->firstOrFail();
        $status = $request->input('status', 'selesai');

        if ($status === 'selesai' && $pesanan->status_pembayaran !== 'lunas') {
            return $this->redirectToTab($request, 'orders')
                ->with('error', 'Pesanan #' . $id . ' belum dapat diselesaikan karena pembayaran belum diverifikasi LUNAS oleh Admin.');
        }

        $pesanan->update([
            'status' => $status,
            'waktu_selesai' => $status === 'selesai' ? Carbon::now() : null,
        ]);

        return $this->redirectToTab($request, 'orders')->with('success', 'Status pesanan berhasil diubah menjadi: ' . strtoupper($status) . '! Tombol ulasan kini aktif untuk pembeli.');
    }

    /**
     * Verifikasi pembayaran dipusatkan pada Administrator sesuai aturan AGENTS.md.
     */
    public function verifyPayment(Request $request, int $id)
    {
        return $this->redirectToTab($request, 'orders')
            ->with('error', 'Verifikasi bukti transfer dilakukan secara terpusat oleh Administrator.');
    }

    /**
     * Kirim balasan pesan ke Pengunjung (UC-07).
     */
    public function replyMessage(Request $request)
    {
        $umkm = $this->getSellerUmkm();
        $request->validate([
            'id_pengunjung' => 'required|integer',
            'isi_pesan' => 'required|string',
        ]);

        Pesan::create([
            'id_pengunjung' => $request->input('id_pengunjung'),
            'id_umkm' => $umkm->id_umkm,
            'pengirim' => 'seller',
            'isi_pesan' => $request->input('isi_pesan'),
            'waktu' => Carbon::now(),
        ]);

        return $this->redirectToTab($request, 'orders')->with('success', 'Pesan berhasil dikirim ke pembeli!');
    }

    /**
     * Tanggapi ulasan dari pembeli milik UMKM terkait (UC-08, F011).
     */
    public function replyReview(Request $request, int $id)
    {
        $umkm = $this->getSellerUmkm();
        if (!$umkm) return $this->redirectToTab($request, 'reviews')->with('error', 'Lapak tidak ditemukan.');

        $ulasan = Ulasan::where('id_ulasan', $id)
            ->where('id_umkm', $umkm->id_umkm)
            ->firstOrFail();

        if ($ulasan->disembunyikan) {
            return $this->redirectToTab($request, 'reviews')
                ->with('error', 'Ulasan yang telah disembunyikan oleh Admin tidak dapat ditanggapi.');
        }

        $request->validate([
            'balasan_seller' => 'required|string|max:500',
        ]);

        $ulasan->update([
            'balasan_seller' => $request->input('balasan_seller'),
        ]);

        return $this->redirectToTab($request, 'reviews')->with('success', 'Tanggapan ulasan berhasil disimpan!');
    }
}
