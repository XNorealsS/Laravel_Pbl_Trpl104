<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Umkm;
use Illuminate\Http\Request;

class UmkmController extends Controller
{
    /**
     * Beranda publik.
     * - Tanpa pencarian: hanya lapak di area "sekitar" kampus (config/jajanria.php).
     * - Dengan kata kunci: semua lapak terverifikasi, termasuk yang di luar sekitar kampus.
     */
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $kategori = (int) $request->query('kategori', 0);
        $harga = $request->query('harga', '');
        $areaFilter = trim((string) $request->query('area', ''));
        $mencari = $q !== '' || $kategori > 0 || $harga !== '' || $areaFilter !== '';

        $sekitar = config('jajanria.area_sekitar', []);
        $ulasanTampil = fn ($u) => $u->where('disembunyikan', false);

        $lapak = Umkm::tampil()
            ->with(['produk.kategori'])
            ->withAvg(['ulasan as rata_rating' => $ulasanTampil], 'rating')
            ->withCount(['ulasan as jumlah_ulasan' => $ulasanTampil])
            ->when(!$mencari, fn ($query) => $query->whereIn('area', $sekitar))
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($w) use ($q) {
                    $w->where('nama_usaha', 'like', "%{$q}%")
                        ->orWhere('area', 'like', "%{$q}%")
                        ->orWhereHas('produk', fn ($p) => $p->where('nama_produk', 'like', "%{$q}%"));
                });
            })
            ->when($kategori > 0, fn ($query) => $query->whereHas('produk', fn ($p) => $p->where('id_kategori', $kategori)))
            ->when($areaFilter !== '', fn ($query) => $query->where('area', $areaFilter))
            ->when($harga === 'murah', fn ($query) => $query->whereHas('produk', fn ($p) => $p->where('harga', '<=', 15000)))
            ->when($harga === 'sedang', fn ($query) => $query->whereHas('produk', fn ($p) => $p->whereBetween('harga', [15000, 25000])))
            ->when($harga === 'atas', fn ($query) => $query->whereHas('produk', fn ($p) => $p->where('harga', '>', 25000)))
            ->orderBy('nama_usaha')
            ->get();

        // Kategori beserta foto dari salah satu menu nyata di kategori tersebut
        $fotoKategori = Produk::whereNotNull('foto_produk')
            ->whereHas('umkm', fn ($u) => $u->tampil())
            ->get()
            ->groupBy('id_kategori')
            ->map(fn ($g) => $g->first()->foto_url);
        $daftarKategori = Kategori::orderBy('nama_kategori')->get();

        // Carousel: lapak sekitar dengan rating tertinggi (hanya yang sudah punya ulasan)
        $populer = Umkm::tampil()
            ->whereIn('area', $sekitar)
            ->withAvg(['ulasan as rata_rating' => $ulasanTampil], 'rating')
            ->withCount(['ulasan as jumlah_ulasan' => $ulasanTampil])
            ->get()
            ->filter(fn ($u) => $u->jumlah_ulasan > 0)
            ->sortByDesc('rata_rating')
            ->take(8)
            ->values();

        return view('landing', compact(
            'lapak', 'populer', 'daftarKategori', 'fotoKategori', 'q', 'kategori', 'harga', 'areaFilter', 'mencari', 'sekitar'
        ));
    }

    /**
     * Detail lapak: profil, menu lengkap per kategori, dan ulasan.
     */
    public function show(int $id)
    {
        $umkm = Umkm::tampil()
            ->with('pemilik')
            ->findOrFail($id);

        $produk = $umkm->produk()
            ->with('kategori')
            ->orderByDesc('tersedia')
            ->orderBy('nama_produk')
            ->get();

        // Kelompokkan menu per kategori (sesuai t_kategori)
        $menuPerKategori = $produk
            ->groupBy(fn ($p) => $p->kategori->nama_kategori)
            ->sortKeys();

        $ulasan = $umkm->ulasan()
            ->with('pengunjung')
            ->where('disembunyikan', false)
            ->latest()
            ->get();

        $rataRating = $ulasan->avg('rating');

        $rentangHarga = $produk->isEmpty()
            ? null
            : [$produk->min('harga'), $produk->max('harga')];

        return view('store-detail', compact('umkm', 'menuPerKategori', 'ulasan', 'rataRating', 'rentangHarga'));
    }
}
