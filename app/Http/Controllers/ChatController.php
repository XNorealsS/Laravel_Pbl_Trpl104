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
     * Dapatkan riwayat seluruh pesanan pengunjung (History Pesanan).
     */
    public function getOrderHistory()
    {
        $idPengunjung = $this->getPengunjungId();
        if (!$idPengunjung) {
            return response()->json([
                'status' => 'unauthenticated',
                'message' => 'Silakan masuk dengan akun Google terlebih dahulu.',
                'data' => [],
            ], 401);
        }

        $orders = Pesanan::where('id_pengunjung', $idPengunjung)
            ->with('umkm')
            ->latest()
            ->get()
            ->map(function ($o) {
                $sudahUlasan = false;
                if ($o->status === 'selesai') {
                    $sudahUlasan = Ulasan::where('id_pesanan', $o->id_pesanan)->exists();
                }

                return [
                    'id_pesanan' => $o->id_pesanan,
                    'status' => $o->status,
                    'status_pembayaran' => $o->status_pembayaran ?? 'belum_bayar',
                    'total_harga' => $o->total_harga ?? 0,
                    'items_detail' => $o->items_detail ?? [],
                    'bukti_pembayaran' => $o->bukti_pembayaran ? asset($o->bukti_pembayaran) : null,
                    'catatan_admin' => $o->catatan_admin,
                    'waktu_selesai' => $o->waktu_selesai ? $o->waktu_selesai->format('d M Y, H:i') : null,
                    'created_at' => $o->created_at ? $o->created_at->format('d M Y, H:i') : null,
                    'sudah_ulasan' => $sudahUlasan,
                    'umkm' => $o->umkm ? [
                        'id_umkm' => $o->umkm->id_umkm,
                        'nama_usaha' => $o->umkm->nama_usaha,
                        'area' => $o->umkm->area,
                        'foto_url' => $o->umkm->foto_url ? asset($o->umkm->foto_url) : null,
                    ] : null,
                ];
            });

        return response()->json([
            'status' => 'success',
            'data' => $orders,
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
                'status_pembayaran' => $pesanan->status_pembayaran ?? 'belum_bayar',
                'total_harga' => $pesanan->total_harga ?? 0,
                'items_detail' => $pesanan->items_detail ?? [],
                'bukti_pembayaran' => $pesanan->bukti_pembayaran ? asset($pesanan->bukti_pembayaran) : null,
                'catatan_admin' => $pesanan->catatan_admin,
                'waktu_selesai' => $pesanan->waktu_selesai ? $pesanan->waktu_selesai->format('d M Y, H:i') : null,
            ] : null,
            'sudah_ulasan' => $sudahUlasan,
            'messages' => $pesan->map(function ($p) {
                return [
                    'id_pesan' => $p->id_pesan,
                    'pengirim' => $p->pengirim,
                    'isi_pesan' => $p->isi_pesan,
                    'tipe_pesan' => $p->tipe_pesan ?? 'teks',
                    'lampiran_url' => $p->lampiran_url ? asset($p->lampiran_url) : null,
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
    /**
     * Checkout alur mandiri (Dedicated Workflow): Menyimpan pesanan dan bukti bayar langsung tanpa masuk ke ruang obrolan.
     */
    public function checkoutOrder(Request $request)
    {
        $idPengunjung = $this->getPengunjungId();
        if (!$idPengunjung) {
            return response()->json([
                'status' => 'unauthenticated',
                'message' => 'Silakan masuk dengan akun Google terlebih dahulu.'
            ], 401);
        }

        // Tangani jika items dikirim dalam bentuk JSON string (via FormData)
        $rawItems = $request->input('items');
        if (is_string($rawItems)) {
            $decoded = json_decode($rawItems, true);
            if (is_array($decoded)) {
                $request->merge(['items' => $decoded]);
            }
        }

        $request->validate([
            'id_umkm' => 'required|integer',
            'items' => 'required|array|min:1',
            'items.*.nama_produk' => 'required|string',
            'items.*.harga' => 'required|numeric',
            'items.*.qty' => 'required|integer|min:1',
            'catatan' => 'nullable|string|max:500',
            'bukti_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:3072',
        ]);

        $idUmkm = (int) $request->input('id_umkm');
        $items = $request->input('items');
        $catatan = trim((string) $request->input('catatan'));

        $totalHarga = 0;
        $itemsDetail = [];

        foreach ($items as $item) {
            $qty = (int) $item['qty'];
            $harga = (int) $item['harga'];
            $subtotal = $qty * $harga;
            $totalHarga += $subtotal;

            $itemsDetail[] = [
                'id_produk' => $item['id_produk'] ?? null,
                'nama_produk' => $item['nama_produk'],
                'harga' => $harga,
                'qty' => $qty,
                'subtotal' => $subtotal,
            ];
        }

        // Proses unggah bukti pembayaran jika dilampirkan langsung saat checkout
        $publicUrl = null;
        $statusPembayaran = 'belum_bayar';
        $waktuPembayaran = null;

        if ($request->hasFile('bukti_foto')) {
            $file = $request->file('bukti_foto');
            $filename = 'bukti_' . $idPengunjung . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('bukti_pembayaran', $filename, 'public');
            $publicUrl = '/storage/' . $path;
            $statusPembayaran = 'menunggu_verifikasi';
            $waktuPembayaran = Carbon::now();
        }

        // Simpan pesanan baru mandiri (tanpa membuat pesan obrolan)
        $pesanan = Pesanan::create([
            'id_pengunjung' => $idPengunjung,
            'id_umkm' => $idUmkm,
            'status' => 'diproses',
            'items_detail' => $itemsDetail,
            'total_harga' => $totalHarga,
            'bukti_pembayaran' => $publicUrl,
            'status_pembayaran' => $statusPembayaran,
            'waktu_pembayaran' => $waktuPembayaran,
            'catatan_admin' => $catatan !== '' ? $catatan : null,
            'waktu_selesai' => null,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Pesanan berhasil dikonfirmasi dan dicatat!',
            'pesanan' => [
                'id_pesanan' => $pesanan->id_pesanan,
                'status' => $pesanan->status,
                'status_pembayaran' => $pesanan->status_pembayaran,
                'total_harga' => $pesanan->total_harga,
                'items_detail' => $pesanan->items_detail,
                'bukti_pembayaran' => $pesanan->bukti_pembayaran ? asset($pesanan->bukti_pembayaran) : null,
                'created_at' => $pesanan->created_at ? $pesanan->created_at->format('d M Y, H:i') : null,
            ],
        ]);
    }

    /**
     * Upload bukti pembayaran oleh Pengunjung mandiri (tanpa masuk ke ruang obrolan).
     */
    public function uploadBuktiPembayaran(Request $request)
    {
        $request->validate([
            'id_pesanan' => 'required|integer',
            'bukti_foto' => 'required|image|mimes:jpeg,png,jpg|max:3072',
            'catatan' => 'nullable|string|max:255',
        ]);

        $idPengunjung = $this->getPengunjungId();
        if (!$idPengunjung) {
            return response()->json([
                'status' => 'unauthenticated',
                'message' => 'Silakan masuk dengan akun Google terlebih dahulu.'
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

        $file = $request->file('bukti_foto');
        $filename = 'bukti_' . $pesanan->id_pesanan . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('bukti_pembayaran', $filename, 'public');
        $publicUrl = '/storage/' . $path;

        $pesanan->update([
            'bukti_pembayaran' => $publicUrl,
            'status_pembayaran' => 'menunggu_verifikasi',
            'waktu_pembayaran' => Carbon::now(),
            'catatan_admin' => null,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Bukti pembayaran berhasil diunggah dan sedang menunggu verifikasi admin.',
            'bukti_url' => asset($publicUrl),
            'status_pembayaran' => 'menunggu_verifikasi',
        ]);
    }

    /**
     * Customer Support: Ambil riwayat percakapan bantuan pelanggan.
     */
    public function getSupportMessages()
    {
        $idPengunjung = $this->getPengunjungId();
        if (!$idPengunjung) {
            return response()->json([
                'status' => 'unauthenticated',
                'message' => 'Silakan masuk dengan akun Google terlebih dahulu.'
            ], 401);
        }

        $messages = Pesan::where('id_pengunjung', $idPengunjung)
            ->where(function ($q) {
                $q->whereNull('id_umkm')
                  ->orWhere('tipe_pesan', 'support');
            })
            ->orderBy('waktu', 'asc')
            ->get();

        return response()->json([
            'status' => 'success',
            'messages' => $messages->map(function ($p) {
                return [
                    'id_pesan' => $p->id_pesan,
                    'pengirim' => $p->pengirim, // 'pengunjung' | 'seller' / 'admin'
                    'isi_pesan' => $p->isi_pesan,
                    'tipe_pesan' => $p->tipe_pesan ?? 'support',
                    'lampiran_url' => $p->lampiran_url ? asset($p->lampiran_url) : null,
                    'waktu' => $p->waktu ? $p->waktu->format('H:i') : '',
                ];
            }),
        ]);
    }

    /**
     * Customer Support: Kirim pesan kendala/pertanyaan dari Pengunjung ke Admin Support.
     */
    public function sendSupportMessage(Request $request)
    {
        $request->validate([
            'isi_pesan' => 'required|string|max:1000',
        ]);

        $idPengunjung = $this->getPengunjungId();
        if (!$idPengunjung) {
            return response()->json([
                'status' => 'unauthenticated',
                'message' => 'Silakan masuk dengan akun Google terlebih dahulu.'
            ], 401);
        }

        $isiPesan = trim((string) $request->input('isi_pesan'));
        if ($isiPesan === '') {
            return response()->json(['status' => 'error', 'message' => 'Pesan tidak boleh kosong'], 422);
        }

        $pesan = Pesan::create([
            'id_pengunjung' => $idPengunjung,
            'id_umkm' => null,
            'pengirim' => 'pengunjung',
            'isi_pesan' => $isiPesan,
            'tipe_pesan' => 'support',
            'waktu' => Carbon::now(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Pesan bantuan berhasil dikirim',
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
