<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Pengguna;
use App\Models\Produk;
use App\Models\Ulasan;
use App\Models\Umkm;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Tampilkan Panel Administrator (UC-09, UC-10, UC-11).
     */
    public function index()
    {
        // 1. Verifikasi seller baru yang menunggu persetujuan (UC-09)
        $pendingSellers = Pengguna::where('role', 'seller')
            ->where('status_verifikasi', 'menunggu')
            ->with('umkm')
            ->latest()
            ->get();

        // 2. Daftar semua UMKM & Seller (UC-10)
        $allUmkms = Umkm::with(['pemilik', 'produk'])->latest()->get();

        // 3. Kelola kategori menu (UC-10)
        $kategoriList = Kategori::withCount('produk')->orderBy('nama_kategori')->get();

        // 4. Moderasi ulasan (UC-11)
        $ulasanList = Ulasan::with(['pengunjung', 'umkm'])->latest()->get();

        // 5. Statistik ringkasan platform
        $stats = [
            'total_umkm' => Umkm::count(),
            'umkm_aktif' => Umkm::tampil()->count(),
            'total_produk' => Produk::count(),
            'total_ulasan' => Ulasan::count(),
            'pending_verifikasi' => $pendingSellers->count(),
        ];

        return view('admin.dashboard', compact(
            'pendingSellers',
            'allUmkms',
            'kategoriList',
            'ulasanList',
            'stats'
        ));
    }

    /**
     * Verifikasi pendaftaran Seller baru: Setujui / Tolak (UC-09, F015).
     */
    public function verifySeller(Request $request, int $idUser)
    {
        $status = $request->input('status', 'terverifikasi');
        $user = Pengguna::where('id_user', $idUser)->where('role', 'seller')->firstOrFail();

        $user->update([
            'status_verifikasi' => $status,
        ]);

        return back()->with('success', 'Status pendaftaran seller berhasil diubah menjadi: ' . strtoupper($status));
    }

    /**
     * Nonaktifkan atau aktifkan akun pengguna (UC-09).
     */
    public function toggleUserStatus(int $idUser)
    {
        $user = Pengguna::findOrFail($idUser);
        $user->update([
            'is_active' => !$user->is_active,
        ]);

        $statusText = $user->is_active ? 'diaktifkan kembali' : 'dinonaktifkan';
        return back()->with('success', 'Akun pengguna ' . $user->nama . ' berhasil ' . $statusText);
    }

    /**
     * Tambah Kategori Baru (UC-10, F016).
     */
    public function storeCategory(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:t_kategori,nama_kategori',
        ]);

        Kategori::create([
            'nama_kategori' => $request->input('nama_kategori'),
        ]);

        return back()->with('success', 'Kategori baru berhasil ditambahkan!');
    }

    /**
     * Hapus Kategori (UC-10).
     */
    public function deleteCategory(int $idKategori)
    {
        Kategori::findOrFail($idKategori)->delete();
        return back()->with('success', 'Kategori berhasil dihapus!');
    }

    /**
     * Moderasi Ulasan: Sembunyikan atau Tampilkan Ulasan (UC-11).
     */
    public function toggleHideReview(int $idUlasan)
    {
        $ulasan = Ulasan::findOrFail($idUlasan);
        $ulasan->update([
            'disembunyikan' => !$ulasan->disembunyikan,
        ]);

        $statusText = $ulasan->disembunyikan ? 'disembunyikan dari publik' : 'ditampilkan kembali';
        return back()->with('success', 'Ulasan pembeli berhasil ' . $statusText);
    }
}
