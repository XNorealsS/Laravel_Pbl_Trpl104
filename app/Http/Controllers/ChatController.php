<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Models\Pesan;
use App\Models\Pesanan;
use App\Models\Ulasan;
use App\Models\Umkm;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Dapatkan id pengunjung dari session login.
     */
    private function getPengunjungId(): ?int
    {
        if (session()->has('user.id_user')) {
            return (int) session('user.id_user');
        }
        return null;
    }

    /**
     * Dapatkan daftar UMKM yang bisa di-chat (beserta info pesan terakhir).
     */
    public function getConversations()
    {
        $idPengunjung = $this->getPengunjungId();
        if (!$idPengunjung) {
            return response()->json([
                'status' => 'unauthenticated',
                'message' => 'Silakan masuk dengan akun Google terlebih dahulu.',
                'data' => [],
            ], 401);
        }

        $umkms = Umkm::tampil()->get()->map(function ($u) use ($idPengunjung) {
            $lastPesanan = Pesanan::where('id_pengunjung', $idPengunjung)
                ->where('id_umkm', $u->id_umkm)
                ->latest()
                ->first();

            $unreadCount = Pesan::where('id_pengunjung', $idPengunjung)
                ->where('id_umkm', $u->id_umkm)
                ->where('pengirim', 'seller')
                ->count();

            return [
                'id_umkm' => $u->id_umkm,
                'nama_usaha' => $u->nama_usaha,
                'area' => $u->area,
                'status_pesanan' => $lastPesanan ? $lastPesanan->status : 'tidak_ada',
                'unread' => $unreadCount,
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => $umkms,
        ]);
    }

    /**
     * Ambil isi chat antara pengunjung dan suatu UMKM.
     */
    public function getMessages(int $idUmkm)
    {
        $idPengunjung = $this->getPengunjungId();
        if (!$idPengunjung) {
            return response()->json([
                'status' => 'unauthenticated',
                'message' => 'Silakan masuk dengan akun Google terlebih dahulu.'
            ], 401);
        }

        $umkm = Umkm::findOrFail($idUmkm);

        $pesan = Pesan::where('id_pengunjung', $idPengunjung)
            ->where('id_umkm', $idUmkm)
            ->orderBy('waktu', 'asc')
            ->get();

        $pesanan = Pesanan::where('id_pengunjung', $idPengunjung)
            ->where('id_umkm', $idUmkm)
            ->latest()
            ->first();

        $sudahUlasan = false;
        if ($pesanan && $pesanan->status === 'selesai') {
            $sudahUlasan = Ulasan::where('id_pesanan', $pesanan->id_pesanan)->exists();
        }

        return response()->json([
            'status' => 'success',
            'umkm' => [
                'id_umkm' => $umkm->id_umkm,
                'nama_usaha' => $umkm->nama_usaha,
                'area' => $umkm->area,
                'kontak' => $umkm->kontak,
            ],
            'pesanan' => $pesanan ? [
                'id_pesanan' => $pesanan->id_pesanan,
                'status' => $pesanan->status,
                'waktu_selesai' => $pesanan->waktu_selesai ? $pesanan->waktu_selesai->format('d M Y, H:i') : null,
            ] : null,
            'sudah_ulasan' => $sudahUlasan,
            'messages' => $pesan->map(function ($p) {
                return [
                    'id_pesan' => $p->id_pesan,
                    'pengirim' => $p->pengirim,
                    'isi_pesan' => $p->isi_pesan,
                    'waktu' => $p->waktu ? $p->waktu->format('H:i') : '',
                ];
            }),
        ]);
    }

    /**
     * Kirim pesan chat dari Pengunjung ke Seller (UC-03).
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'id_umkm' => 'required|integer',
            'isi_pesan' => 'required|string',
        ]);

        $idPengunjung = $this->getPengunjungId();
        if (!$idPengunjung) {
            return response()->json([
                'status' => 'unauthenticated',
                'message' => 'Silakan masuk dengan akun Google terlebih dahulu untuk mengirim pesan ke penjual.'
            ], 401);
        }

        $idUmkm = (int) $request->input('id_umkm');
        $isiPesan = trim((string) $request->input('isi_pesan'));

        if ($isiPesan === '') {
            return response()->json(['status' => 'error', 'message' => 'Pesan tidak boleh kosong'], 422);
        }

        // Buat atau cari pesanan aktif (status: diproses)
        $pesanan = Pesanan::where('id_pengunjung', $idPengunjung)
            ->where('id_umkm', $idUmkm)
            ->where('status', 'diproses')
            ->first();

        if (!$pesanan) {
            $pesanan = Pesanan::create([
                'id_pengunjung' => $idPengunjung,
                'id_umkm' => $idUmkm,
                'status' => 'diproses',
                'waktu_selesai' => null,
            ]);
        }

        // Simpan pesan
        $pesan = Pesan::create([
            'id_pengunjung' => $idPengunjung,
            'id_umkm' => $idUmkm,
            'pengirim' => 'pengunjung',
            'isi_pesan' => $isiPesan,
            'waktu' => Carbon::now(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Pesan berhasil dikirim',
            'data' => [
                'id_pesan' => $pesan->id_pesan,
                'isi_pesan' => $pesan->isi_pesan,
                'pengirim' => $pesan->pengirim,
                'waktu' => $pesan->waktu->format('H:i'),
            ],
        ]);
    }

    /**
     * Kirim rating & ulasan dari Pengunjung setelah pesanan selesai (UC-04, F008, F009).
     */
    public function submitUlasan(Request $request)
    {
        $request->validate([
            'id_pesanan' => 'required|integer',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:500',
        ]);

        $idPengunjung = $this->getPengunjungId();
        if (!$idPengunjung) {
            return response()->json([
                'status' => 'unauthenticated',
                'message' => 'Silakan masuk dengan akun Google terlebih dahulu untuk memberikan ulasan.'
            ], 401);
        }

        $pesanan = Pesanan::where('id_pesanan', $request->input('id_pesanan'))
            ->where('id_pengunjung', $idPengunjung)
            ->first();

        if (!$pesanan) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data pesanan tidak ditemukan.',
            ], 404);
        }

        if ($pesanan->status !== 'selesai') {
            return response()->json([
                'status' => 'error',
                'message' => 'Penilaian hanya dapat diberikan setelah penjual menandai pesanan selesai.',
            ], 400);
        }

        // Cek jika sudah pernah memberi ulasan
        $existing = Ulasan::where('id_pesanan', $pesanan->id_pesanan)->first();
        if ($existing) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda sudah memberikan penilaian untuk pesanan ini.',
            ], 400);
        }

        $ulasan = Ulasan::create([
            'id_pesanan' => $pesanan->id_pesanan,
            'id_pengunjung' => $idPengunjung,
            'id_umkm' => $pesanan->id_umkm,
            'rating' => (int) $request->input('rating'),
            'komentar' => $request->input('komentar'),
            'balasan_seller' => null,
            'disembunyikan' => false,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Terima kasih! Ulasan dan rating Anda telah berhasil disimpan.',
            'data' => $ulasan,
        ]);
    }
}
