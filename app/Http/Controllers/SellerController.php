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
    /**
     * Dapatkan UMKM milik seller yang sedang aktif.
     */
    private function getSellerUmkm(): ?Umkm
    {
        $userId = session('user.id_user');
        if ($userId) {
            $umkm = Umkm::where('id_user', $userId)->first();
            if ($umkm) return $umkm;
        }
        // Fallback demo: ambil lapak pertama yang terverifikasi
        return Umkm::tampil()->first();
    }

    /**
     * Tampilkan Dashboard Seller (UC-05, UC-06, UC-07, UC-08).
     */
    public function index()
    {
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
     * Update profil UMKM (UC-05, F012).
     */
    public function updateProfile(Request $request)
    {
        $umkm = $this->getSellerUmkm();
        if (!$umkm) return back()->with('error', 'Lapak tidak ditemukan');

        $request->validate([
            'nama_usaha' => 'required|string|max:150',
            'area' => 'required|string',
            'lokasi' => 'required|string',
            'kontak' => 'required|string',
            'deskripsi' => 'nullable|string',
        ]);

        $umkm->update([
            'nama_usaha' => $request->input('nama_usaha'),
            'area' => $request->input('area'),
            'lokasi' => $request->input('lokasi'),
            'kontak' => $request->input('kontak'),
            'deskripsi' => $request->input('deskripsi'),
        ]);

        return back()->with('success', 'Profil UMKM berhasil diperbarui!');
    }

    /**
     * Tambah produk baru (UC-06, F013).
     */
    public function storeProduct(Request $request)
    {
        $umkm = $this->getSellerUmkm();
        if (!$umkm) return back()->with('error', 'Lapak tidak ditemukan');

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

        return back()->with('success', 'Menu produk baru berhasil ditambahkan!');
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

        return back()->with('success', 'Menu produk berhasil diperbarui!');
    }

    /**
     * Hapus produk (UC-06).
     */
    public function deleteProduct(int $id)
    {
        $umkm = $this->getSellerUmkm();
        Produk::where('id_produk', $id)->where('id_umkm', $umkm->id_umkm)->delete();

        return back()->with('success', 'Produk berhasil dihapus!');
    }

    /**
     * Kosongkan ketersediaan atau aktifkan ketersediaan produk (UC-07 Skenario Alternatif).
     */
    public function toggleProductAvailability(int $id)
    {
        $umkm = $this->getSellerUmkm();
        $produk = Produk::where('id_produk', $id)->where('id_umkm', $umkm->id_umkm)->firstOrFail();

        $produk->update([
            'tersedia' => !$produk->tersedia,
        ]);

        $statusText = $produk->tersedia ? 'Tersedia' : 'Kosong / Habis';
        return back()->with('success', "Status ketersediaan \"{$produk->nama_produk}\" berhasil diubah menjadi: {$statusText}");
    }

    /**
     * Update status pesanan: "diproses" -> "selesai" (UC-07, F007).
     * Memicu tombol "Beri Penilaian" pada chat pembeli.
     */
    public function updateOrderStatus(Request $request, int $id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $status = $request->input('status', 'selesai');

        $pesanan->update([
            'status' => $status,
            'waktu_selesai' => $status === 'selesai' ? Carbon::now() : null,
        ]);

        return back()->with('success', 'Status pesanan berhasil diubah menjadi: ' . strtoupper($status) . '! Tombol ulasan kini aktif untuk pembeli.');
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

        return back()->with('success', 'Pesan berhasil dikirim ke pembeli!');
    }

    /**
     * Tanggapi ulasan dari pembeli (UC-08, F011).
     */
    public function replyReview(Request $request, int $id)
    {
        $ulasan = Ulasan::findOrFail($id);
        $request->validate([
            'balasan_seller' => 'required|string|max:500',
        ]);

        $ulasan->update([
            'balasan_seller' => $request->input('balasan_seller'),
        ]);

        return back()->with('success', 'Tanggapan ulasan berhasil disimpan!');
    }
}
