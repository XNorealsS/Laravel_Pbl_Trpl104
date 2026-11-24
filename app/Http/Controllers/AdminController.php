<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Pengguna;
use App\Models\Pesan;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\Ulasan;
use App\Models\Umkm;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    private const TABS = ['monitoring', 'verification', 'payments', 'umkm', 'categories', 'moderation', 'support', 'users'];

    private function resolveTab(?string $tab, string $default = 'monitoring'): string
    {
        return in_array($tab, self::TABS, true) ? $tab : $default;
    }

    /**
     * Tampilkan Panel Administrator (UC-09, UC-10, UC-11).
     */
    public function index(Request $request)
    {
        $activeTab = $this->resolveTab($request->query('tab'), 'monitoring');
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

        // 5. Daftar Pesanan dengan Bukti Pembayaran untuk Verifikasi Admin
        $paymentOrders = Pesanan::whereNotNull('bukti_pembayaran')
            ->orWhereIn('status_pembayaran', ['menunggu_verifikasi', 'lunas', 'ditolak'])
            ->with(['pengunjung', 'umkm'])
            ->latest()
            ->get();

        // 6. Daftar Pesan Customer Support (Pusat Bantuan Pengguna)
        $supportTickets = Pesan::where(function ($q) {
            $q->whereNull('id_umkm')->orWhere('tipe_pesan', 'support');
        })->with('pengunjung')->latest('waktu')->get();

        // 7. Pemantauan log pesan/obrolan untuk keperluan moderasi (UC-11, F018)
        $pesanList = Pesan::with(['pengunjung', 'umkm'])->latest('waktu')->take(12)->get();

        // 7. Daftar seluruh akun pengguna untuk Manajemen User (UC-09, F015)
        $allUsers = Pengguna::with('umkm')->latest('id_user')->get();

        // 8. Activity Log Summary - Pengawasan aktivitas gabungan real-time (UC-11, F018, F019)
        $userEvents = Pengguna::latest('created_at')->take(6)->get()->map(function ($u) {
            $isGoogle = !empty($u->firebase_uid);
            return [
                'type' => 'user',
                'icon' => 'bx-user-plus',
                'badge_class' => 'badge-info',
                'badge_label' => 'Akun',
                'title' => 'Akun ' . ucfirst($u->role) . ' Terdaftar',
                'desc' => $u->nama . ' (' . ($isGoogle ? 'Google Auth' : 'Email/Pass') . ')',
                'time' => $u->created_at,
                'status' => $u->is_active ? 'Aktif' : 'Nonaktif',
            ];
        });

        $orderEvents = Pesanan::with(['pengunjung', 'umkm'])->latest('created_at')->take(6)->get()->map(function ($o) {
            $isSelesai = $o->status === 'selesai';
            return [
                'type' => 'order',
                'icon' => $isSelesai ? 'bx-check-circle' : 'bx-time-five',
                'badge_class' => $isSelesai ? 'badge-success' : 'badge-warning',
                'badge_label' => 'Pesanan',
                'title' => $isSelesai ? 'Pesanan Selesai' : 'Pesanan Diproses',
                'desc' => ($o->pengunjung ? $o->pengunjung->nama : 'Customer') . ' ➔ ' . ($o->umkm ? $o->umkm->nama_usaha : 'Lapak UMKM'),
                'time' => $o->waktu_selesai ?? $o->created_at,
                'status' => ucfirst($o->status),
            ];
        });

        $reviewEvents = Ulasan::with(['pengunjung', 'umkm'])->latest('created_at')->take(6)->get()->map(function ($r) {
            return [
                'type' => 'review',
                'icon' => 'bx-star',
                'badge_class' => $r->disembunyikan ? 'badge-danger' : 'badge-warning',
                'badge_label' => 'Ulasan',
                'title' => $r->disembunyikan ? 'Ulasan Disembunyikan (Moderasi)' : 'Ulasan Masuk (' . $r->rating . '★)',
                'desc' => ($r->pengunjung ? $r->pengunjung->nama : 'Customer') . ': "' . \Illuminate\Support\Str::limit($r->komentar, 40) . '"',
                'time' => $r->created_at,
                'status' => $r->disembunyikan ? 'Dimoderasi' : 'Tampil',
            ];
        });

        $chatEvents = Pesan::with(['pengunjung', 'umkm'])->latest('waktu')->take(6)->get()->map(function ($p) {
            $isSupport = is_null($p->id_umkm) || $p->tipe_pesan === 'support';
            $senderLabel = $p->pengirim === 'pengunjung'
                ? ($p->pengunjung ? $p->pengunjung->nama : 'Customer')
                : ($isSupport ? 'Admin Support' : 'Seller');
            return [
                'type' => 'chat',
                'icon' => $isSupport ? 'bx-support' : 'bx-message-square-detail',
                'badge_class' => 'badge-primary',
                'badge_label' => $isSupport ? 'Support' : 'Chat',
                'title' => $isSupport ? 'Tiket Customer Support' : 'Obrolan Chat Internal',
                'desc' => $senderLabel . ' ➔ "' . \Illuminate\Support\Str::limit($p->isi_pesan, 38) . '"',
                'time' => $p->waktu,
                'status' => 'Terkirim',
            ];
        });

        $activityLogs = $userEvents->concat($orderEvents)->concat($reviewEvents)->concat($chatEvents)
            ->sortByDesc(fn ($item) => $item['time'] ? $item['time']->timestamp : 0)
            ->values()
            ->take(12);

        // 9. Statistik lengkap monitoring platform (UC-11, F019)
        $stats = [
            'total_umkm' => Umkm::count(),
            'umkm_aktif' => Umkm::tampil()->count(),
            'total_produk' => Produk::count(),
            'total_ulasan' => Ulasan::count(),
            'pending_verifikasi' => $pendingSellers->count(),
            'pending_pembayaran' => Pesanan::where('status_pembayaran', 'menunggu_verifikasi')->count(),
            'total_support' => $supportTickets->count(),
            'total_pengguna' => Pengguna::count(),
            'total_pesan' => Pesan::count(),
            'total_pesanan' => Pesanan::count(),
        ];

        return view('admin.dashboard', compact(
            'activeTab',
            'pendingSellers',
            'allUmkms',
            'kategoriList',
            'ulasanList',
            'paymentOrders',
            'supportTickets',
            'pesanList',
            'allUsers',
            'activityLogs',
            'stats'
        ));
    }

    /**
     * Redirect kembali ke tab aktif agar admin tetap berada di halaman aksi.
     */
    private function redirectToTab(Request $request, string $defaultTab = 'monitoring')
    {
        $tab = $this->resolveTab($request->input('active_tab'), $defaultTab);

        return $tab === 'monitoring'
            ? redirect()->route('admin')
            : redirect()->route('admin', ['tab' => $tab]);
    }

    /**
     * Verifikasi pendaftaran Seller baru: Setujui / Tolak (UC-09, F015).
     */
    public function verifySeller(Request $request, int $idUser)
    {
        $request->validate([
            'status' => 'required|in:terverifikasi,ditolak',
        ]);

        $status = $request->input('status');
        $user = Pengguna::where('id_user', $idUser)->where('role', 'seller')->firstOrFail();

        $user->update([
            'status_verifikasi' => $status,
        ]);

        return $this->redirectToTab($request, 'verification')
            ->with('success', 'Status pendaftaran seller berhasil diubah menjadi: ' . strtoupper($status));
    }

    /**
     * Nonaktifkan atau aktifkan akun pengguna (UC-09).
     */
    public function toggleUserStatus(Request $request, int $idUser)
    {
        $user = Pengguna::findOrFail($idUser);
        if ($user->id_user === (int) session('user.id_user')) {
            return $this->redirectToTab($request, 'users')
                ->with('error', 'Anda tidak dapat menonaktifkan akun Administrator yang sedang aktif.');
        }

        $user->update([
            'is_active' => !$user->is_active,
        ]);

        $statusText = $user->is_active ? 'diaktifkan kembali' : 'dinonaktifkan';
        return $this->redirectToTab($request, 'users')
            ->with('success', 'Akun pengguna ' . $user->nama . ' berhasil ' . $statusText);
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

        return $this->redirectToTab($request, 'categories')
            ->with('success', 'Kategori baru berhasil ditambahkan!');
    }

    /**
     * Hapus Kategori (UC-10 Skenario Alternatif: cegah hapus jika masih memiliki produk aktif).
     */
    public function deleteCategory(Request $request, int $idKategori)
    {
        $kategori = Kategori::findOrFail($idKategori);
        if ($kategori->produk()->exists()) {
            return $this->redirectToTab($request, 'categories')
                ->with('error', 'Kategori "' . $kategori->nama_kategori . '" tidak dapat dihapus karena masih digunakan oleh produk aktif.');
        }

        $kategori->delete();
        return $this->redirectToTab($request, 'categories')
            ->with('success', 'Kategori berhasil dihapus!');
    }

    /**
     * Moderasi Ulasan: Sembunyikan atau Tampilkan Ulasan (UC-11).
     */
    public function toggleHideReview(Request $request, int $idUlasan)
    {
        $ulasan = Ulasan::findOrFail($idUlasan);
        $ulasan->update([
            'disembunyikan' => !$ulasan->disembunyikan,
        ]);

        $statusText = $ulasan->disembunyikan ? 'disembunyikan dari publik' : 'ditampilkan kembali';
        return $this->redirectToTab($request, 'moderation')
            ->with('success', 'Ulasan pembeli berhasil ' . $statusText);
    }

    /**
     * Verifikasi Bukti Pembayaran: Setujui (Lunas) / Tolak.
     */
    public function verifyPayment(Request $request, int $idPesanan)
    {
        $request->validate([
            'status' => 'required|in:lunas,ditolak',
            'catatan' => 'nullable|string|max:255',
        ]);

        $status = $request->input('status');
        $catatan = trim((string) $request->input('catatan'));

        $pesanan = Pesanan::findOrFail($idPesanan);
        $pesanan->update([
            'status_pembayaran' => $status,
            'catatan_admin' => $catatan ?: null,
        ]);

        return $this->redirectToTab($request, 'payments')
            ->with('success', 'Status pembayaran pesanan #' . $idPesanan . ' berhasil diubah menjadi: ' . strtoupper($status));
    }

    /**
     * Balas pesan Customer Support kepada Pengguna.
     */
    public function replySupportMessage(Request $request, int $idUser)
    {
        $request->validate([
            'isi_pesan' => 'required|string|max:1000',
        ]);

        $isiPesan = trim((string) $request->input('isi_pesan'));
        if ($isiPesan === '') {
            return $this->redirectToTab($request, 'support')
                ->with('error', 'Pesan balasan tidak boleh kosong.');
        }

        Pesan::create([
            'id_pengunjung' => $idUser,
            'id_umkm' => null,
            'pengirim' => 'seller',
            'isi_pesan' => $isiPesan,
            'tipe_pesan' => 'support',
            'waktu' => now(),
        ]);

        return $this->redirectToTab($request, 'support')
            ->with('success', 'Balasan Customer Support berhasil dikirim ke pelanggan.');
    }
}
