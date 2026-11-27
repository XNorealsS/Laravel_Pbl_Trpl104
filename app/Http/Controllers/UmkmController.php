<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Umkm;
use Illuminate\Http\Request;

class UmkmController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $kategori = (int) $request->query('kategori', 0);
        $harga = (string) $request->query('harga', '');
        $areaFilter = trim((string) $request->query('area', ''));
        $mencari = $q !== '' || $kategori > 0 || $harga !== '' || $areaFilter !== '';

        $sekitar = config('jajanria.area_sekitar', []);
        $ulasanTampil = function ($query) {
            $query->where('disembunyikan', false);
        };

        $query = Umkm::tampil()
            ->with(['produk.kategori'])
            ->withAvg(['ulasan as rata_rating' => $ulasanTampil], 'rating')
            ->withCount(['ulasan as jumlah_ulasan' => $ulasanTampil]);

        // Tanpa filter, beranda hanya menampilkan lapak di area sekitar kampus
        if (!$mencari) {
            $query->whereIn('area', $sekitar);
        }

        if ($q !== '') {
            $query->where(function ($w) use ($q) {
                $w->where('nama_usaha', 'like', "%{$q}%")
                    ->orWhere('area', 'like', "%{$q}%")
                    ->orWhereHas('produk', function ($p) use ($q) {
                        $p->where('nama_produk', 'like', "%{$q}%");
                    });
            });
        }

        if ($kategori > 0) {
            $query->whereHas('produk', function ($p) use ($kategori) {
                $p->where('id_kategori', $kategori);
            });
        }

        if ($areaFilter !== '') {
            $query->where('area', $areaFilter);
        }

        if ($harga === 'murah') {
            $query->whereHas('produk', function ($p) {
                $p->where('harga', '<=', 15000);
            });
        } elseif ($harga === 'sedang') {
            $query->whereHas('produk', function ($p) {
                $p->whereBetween('harga', [15000, 25000]);
            });
        } elseif ($harga === 'atas') {
            $query->whereHas('produk', function ($p) {
                $p->where('harga', '>', 25000);
            });
        }

        $lapak = $query->orderBy('nama_usaha')->get();

        // Ambil satu foto menu nyata per kategori untuk kartu kategori
        $fotoKategori = Produk::whereNotNull('foto_produk')
            ->whereHas('umkm', function ($u) {
                $u->tampil();
            })
            ->get()
            ->groupBy('id_kategori')
            ->map(function ($group) {
                return $group->first()->foto_url;
            });

        $daftarKategori = Kategori::orderBy('nama_kategori')->get();

        $populer = Umkm::tampil()
            ->whereIn('area', $sekitar)
            ->withAvg(['ulasan as rata_rating' => $ulasanTampil], 'rating')
            ->withCount(['ulasan as jumlah_ulasan' => $ulasanTampil])
            ->get()
            ->filter(function ($u) {
                return $u->jumlah_ulasan > 0;
            })
            ->sortByDesc('rata_rating')
            ->take(8)
            ->values();

        return view('landing', compact(
            'lapak',
            'populer',
            'daftarKategori',
            'fotoKategori',
            'q',
            'kategori',
            'harga',
            'areaFilter',
            'mencari',
            'sekitar'
        ));
    }

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

        $menuPerKategori = $produk
            ->groupBy(function ($p) {
                return $p->kategori->nama_kategori;
            })
            ->sortKeys();

        $ulasan = $umkm->ulasan()
            ->with('pengunjung')
            ->where('disembunyikan', false)
            ->latest()
            ->get();

        $rataRating = $ulasan->avg('rating');
        $rentangHarga = $produk->isEmpty() ? null : [$produk->min('harga'), $produk->max('harga')];

        return view('store-detail', compact('umkm', 'menuPerKategori', 'ulasan', 'rataRating', 'rentangHarga'));
    }
}
