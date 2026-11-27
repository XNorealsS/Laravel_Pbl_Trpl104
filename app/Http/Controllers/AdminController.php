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
use Illuminate\Support\Str;

class AdminController extends Controller
{
    private const TABS = ['monitoring', 'verification', 'payments', 'umkm', 'categories', 'moderation', 'support', 'users'];

    public function index(Request $request)
    {
        $activeTab = $this->resolveTab($request->query('tab'), 'monitoring');

        $pendingSellers = Pengguna::where('role', 'seller')
            ->where('status_verifikasi', 'menunggu')
            ->with('umkm')
            ->latest()
            ->get();

        $allUmkms = Umkm::with(['pemilik', 'produk'])->latest()->get();
        $kategoriList = Kategori::withCount('produk')->orderBy('nama_kategori')->get();
        $ulasanList = Ulasan::with(['pengunjung', 'umkm'])->latest()->get();

        $paymentOrders = Pesanan::whereNotNull('bukti_pembayaran')
            ->orWhereIn('status_pembayaran', ['menunggu_verifikasi', 'lunas', 'ditolak'])
            ->with(['pengunjung', 'umkm'])
            ->latest()
            ->get();

        $supportTickets = Pesan::where(function ($q) {
            $q->whereNull('id_umkm')->orWhere('tipe_pesan', 'support');
        })->with('pengunjung')->latest('waktu')->get();

        $pesanList = Pesan::with(['pengunjung', 'umkm'])->latest('waktu')->take(12)->get();
        $allUsers = Pengguna::with('umkm')->latest('id_user')->get();
        $activityLogs = $this->buildActivityLogs();

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

    public function verifySeller(Request $request, int $idUser)
    {
        $data = $request->validate([
            'status' => 'required|in:terverifikasi,ditolak',
        ]);

        $user = Pengguna::where('id_user', $idUser)->where('role', 'seller')->firstOrFail();
        $user->update(['status_verifikasi' => $data['status']]);

        return $this->redirectToTab($request, 'verification')
            ->with('success', 'Status pendaftaran seller berhasil diubah menjadi: ' . strtoupper($data['status']));
    }

    public function toggleUserStatus(Request $request, int $idUser)
    {
        $user = Pengguna::findOrFail($idUser);

        if ($user->id_user === (int) session('user.id_user')) {
            return $this->redirectToTab($request, 'users')
                ->with('error', 'Anda tidak dapat menonaktifkan akun Administrator yang sedang aktif.');
        }

        $user->update(['is_active' => !$user->is_active]);

        $statusText = $user->is_active ? 'diaktifkan kembali' : 'dinonaktifkan';
        return $this->redirectToTab($request, 'users')
            ->with('success', 'Akun pengguna ' . $user->nama . ' berhasil ' . $statusText);
    }

    public function storeCategory(Request $request)
    {
        $data = $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:t_kategori,nama_kategori',
        ]);

        Kategori::create(['nama_kategori' => $data['nama_kategori']]);

        return $this->redirectToTab($request, 'categories')
            ->with('success', 'Kategori baru berhasil ditambahkan!');
    }

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

    public function toggleHideReview(Request $request, int $idUlasan)
    {
        $ulasan = Ulasan::findOrFail($idUlasan);
        $ulasan->update(['disembunyikan' => !$ulasan->disembunyikan]);

        $statusText = $ulasan->disembunyikan ? 'disembunyikan dari publik' : 'ditampilkan kembali';
        return $this->redirectToTab($request, 'moderation')
            ->with('success', 'Ulasan pembeli berhasil ' . $statusText);
    }

    public function verifyPayment(Request $request, int $idPesanan)
    {
        $data = $request->validate([
            'status' => 'required|in:lunas,ditolak',
            'catatan' => 'nullable|string|max:255',
        ]);

        $status = $data['status'];
        $catatan = trim((string) ($data['catatan'] ?? ''));

        $pesanan = Pesanan::findOrFail($idPesanan);
        $pesanan->update([
            'status_pembayaran' => $status,
            'catatan_admin' => $status === 'lunas' ? null : ($catatan ?: null),
        ]);

        return $this->redirectToTab($request, 'payments')
            ->with('success', 'Status pembayaran pesanan #' . $idPesanan . ' berhasil diubah menjadi: ' . strtoupper($status));
    }

    public function replySupportMessage(Request $request, int $idUser)
    {
        $data = $request->validate([
            'isi_pesan' => 'required|string|max:1000',
        ]);

        Pesan::create([
            'id_pengunjung' => $idUser,
            'id_umkm' => null,
            'pengirim' => 'seller',
            'isi_pesan' => $data['isi_pesan'],
            'tipe_pesan' => 'support',
            'waktu' => now(),
        ]);

        return $this->redirectToTab($request, 'support')
            ->with('success', 'Balasan Customer Support berhasil dikirim ke pelanggan.');
    }

    private function buildActivityLogs()
    {
        $userEvents = Pengguna::latest('created_at')->take(6)->get()->map(function ($u) {
            return [
                'type' => 'user',
                'icon' => 'bx-user-plus',
                'badge_class' => 'badge-info',
                'badge_label' => 'Akun',
                'title' => 'Akun ' . ucfirst($u->role) . ' Terdaftar',
                'desc' => $u->nama . ' (' . ($u->firebase_uid ? 'Google Auth' : 'Email/Pass') . ')',
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
                'desc' => ($o->pengunjung->nama ?? 'Customer') . ' ➔ ' . ($o->umkm->nama_usaha ?? 'Lapak UMKM'),
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
                'desc' => ($r->pengunjung->nama ?? 'Customer') . ': "' . Str::limit($r->komentar, 40) . '"',
                'time' => $r->created_at,
                'status' => $r->disembunyikan ? 'Dimoderasi' : 'Tampil',
            ];
        });

        $chatEvents = Pesan::with(['pengunjung', 'umkm'])->latest('waktu')->take(6)->get()->map(function ($p) {
            $isSupport = is_null($p->id_umkm) || $p->tipe_pesan === 'support';
            $senderLabel = $p->pengirim === 'pengunjung'
                ? ($p->pengunjung->nama ?? 'Customer')
                : ($isSupport ? 'Admin Support' : 'Seller');

            return [
                'type' => 'chat',
                'icon' => $isSupport ? 'bx-support' : 'bx-message-square-detail',
                'badge_class' => 'badge-primary',
                'badge_label' => $isSupport ? 'Support' : 'Chat',
                'title' => $isSupport ? 'Tiket Customer Support' : 'Obrolan Chat Internal',
                'desc' => $senderLabel . ' ➔ "' . Str::limit($p->isi_pesan, 38) . '"',
                'time' => $p->waktu,
                'status' => 'Terkirim',
            ];
        });

        return $userEvents
            ->concat($orderEvents)
            ->concat($reviewEvents)
            ->concat($chatEvents)
            ->sortByDesc(function ($item) {
                return $item['time'] ? $item['time']->timestamp : 0;
            })
            ->values()
            ->take(12);
    }

    private function resolveTab(?string $tab, string $default = 'monitoring'): string
    {
        return in_array($tab, self::TABS, true) ? $tab : $default;
    }

    private function redirectToTab(Request $request, string $defaultTab = 'monitoring')
    {
        $tab = $this->resolveTab($request->input('active_tab'), $defaultTab);

        return $tab === 'monitoring'
            ? redirect()->route('admin')
            : redirect()->route('admin', ['tab' => $tab]);
    }
}
