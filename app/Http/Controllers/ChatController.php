<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Models\Pesan;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\Ulasan;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class ChatController extends Controller
{
    public function getConversations()
    {
        $idPengunjung = $this->getPengunjungId();
        if (!$idPengunjung) {
            return $this->unauthenticatedResponse(true);
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

    public function getOrderHistory()
    {
        $idPengunjung = $this->getPengunjungId();
        if (!$idPengunjung) {
            return $this->unauthenticatedResponse(true);
        }

        $orders = Pesanan::where('id_pengunjung', $idPengunjung)
            ->with('umkm')
            ->latest()
            ->get()
            ->map(function ($o) {
                $sudahUlasan = false;
                if ($o->status === 'selesai' && $o->status_pembayaran === 'lunas') {
                    $sudahUlasan = Ulasan::where('id_pesanan', $o->id_pesanan)->exists();
                }

                return [
                    'id_pesanan' => $o->id_pesanan,
                    'status' => $o->status,
                    'status_pembayaran' => $o->status_pembayaran ?? 'belum_bayar',
                    'total_harga' => $o->total_harga ?? 0,
                    'items_detail' => $o->items_detail ?? [],
                    'catatan_pembeli' => $o->catatan_pembeli,
                    'bukti_pembayaran' => $o->bukti_pembayaran ? asset($o->bukti_pembayaran) : null,
                    'catatan_admin' => $o->catatan_admin,
                    'waktu_selesai' => $o->waktu_selesai?->format('d M Y, H:i'),
                    'created_at' => $o->created_at?->format('d M Y, H:i'),
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

    public function getMessages(int $idUmkm)
    {
        $idPengunjung = $this->getPengunjungId();
        if (!$idPengunjung) {
            return $this->unauthenticatedResponse();
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

        $sudahUlasan = $pesanan && $pesanan->status === 'selesai'
            ? Ulasan::where('id_pesanan', $pesanan->id_pesanan)->exists()
            : false;

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
                'waktu_selesai' => $pesanan->waktu_selesai?->format('d M Y, H:i'),
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

    public function sendMessage(Request $request)
    {
        $idPengunjung = $this->getPengunjungId();
        if (!$idPengunjung) {
            return $this->unauthenticatedResponse(false, 'Silakan masuk dengan akun Google terlebih dahulu untuk mengirim pesan ke penjual.');
        }

        $data = $request->validate([
            'id_umkm' => 'required|integer',
            'isi_pesan' => 'required|string',
        ]);

        $idUmkm = (int) $data['id_umkm'];
        $pesanan = Pesanan::where('id_pengunjung', $idPengunjung)
            ->where('id_umkm', $idUmkm)
            ->where('status', 'diproses')
            ->first();

        if (!$pesanan) {
            Pesanan::create([
                'id_pengunjung' => $idPengunjung,
                'id_umkm' => $idUmkm,
                'status' => 'diproses',
                'waktu_selesai' => null,
            ]);
        }

        $pesan = Pesan::create([
            'id_pengunjung' => $idPengunjung,
            'id_umkm' => $idUmkm,
            'pengirim' => 'pengunjung',
            'isi_pesan' => $data['isi_pesan'],
            'waktu' => now(),
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

    public function checkoutOrder(Request $request)
    {
        $idPengunjung = $this->getPengunjungId();
        if (!$idPengunjung) {
            return $this->unauthenticatedResponse();
        }

        // FormData mengirim items sebagai JSON string, ubah dulu ke array sebelum validasi
        if (is_string($request->input('items'))) {
            $decoded = json_decode($request->input('items'), true);
            if (is_array($decoded)) {
                $request->merge(['items' => $decoded]);
            }
        }

        $data = $request->validate([
            'id_umkm' => 'required|integer',
            'items' => 'required|array|min:1',
            'items.*.id_produk' => 'required|integer',
            'items.*.qty' => 'required|integer|min:1',
            'catatan' => 'nullable|string|max:500',
            'bukti_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:3072',
        ]);

        $idUmkm = (int) $data['id_umkm'];
        if (!Umkm::tampil()->where('id_umkm', $idUmkm)->exists()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Lapak UMKM tidak ditemukan atau sedang tidak aktif.',
            ], 422);
        }

        $totalHarga = 0;
        $itemsDetail = [];

        foreach ($data['items'] as $item) {
            $produk = Produk::where('id_produk', (int) $item['id_produk'])
                ->where('id_umkm', $idUmkm)
                ->first();

            if (!$produk) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Menu yang dipilih tidak ditemukan pada lapak ini.',
                ], 422);
            }

            if (!$produk->tersedia) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Menu "' . $produk->nama_produk . '" sedang habis / tidak tersedia.',
                ], 422);
            }

            // Hitung dari harga database agar total tidak bisa diubah dari browser
            $qty = (int) $item['qty'];
            $harga = (int) round($produk->harga);
            $subtotal = $qty * $harga;
            $totalHarga += $subtotal;

            $itemsDetail[] = [
                'id_produk' => $produk->id_produk,
                'nama_produk' => $produk->nama_produk,
                'harga' => $harga,
                'qty' => $qty,
                'subtotal' => $subtotal,
            ];
        }

        $publicUrl = null;
        $statusPembayaran = 'belum_bayar';
        $waktuPembayaran = null;

        if ($request->hasFile('bukti_foto')) {
            $publicUrl = $this->storePaymentProof($request->file('bukti_foto'), (string) $idPengunjung);
            $statusPembayaran = 'menunggu_verifikasi';
            $waktuPembayaran = now();
        }

        $catatan = trim((string) ($data['catatan'] ?? ''));

        $pesanan = Pesanan::create([
            'id_pengunjung' => $idPengunjung,
            'id_umkm' => $idUmkm,
            'status' => 'diproses',
            'items_detail' => $itemsDetail,
            'catatan_pembeli' => $catatan !== '' ? $catatan : null,
            'total_harga' => $totalHarga,
            'bukti_pembayaran' => $publicUrl,
            'status_pembayaran' => $statusPembayaran,
            'waktu_pembayaran' => $waktuPembayaran,
            'catatan_admin' => null,
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
                'created_at' => $pesanan->created_at?->format('d M Y, H:i'),
            ],
        ]);
    }

    public function uploadBuktiPembayaran(Request $request)
    {
        $idPengunjung = $this->getPengunjungId();
        if (!$idPengunjung) {
            return $this->unauthenticatedResponse();
        }

        $data = $request->validate([
            'id_pesanan' => 'required|integer',
            'bukti_foto' => 'required|image|mimes:jpeg,png,jpg|max:3072',
            'catatan' => 'nullable|string|max:255',
        ]);

        $pesanan = Pesanan::where('id_pesanan', $data['id_pesanan'])
            ->where('id_pengunjung', $idPengunjung)
            ->first();

        if (!$pesanan) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data pesanan tidak ditemukan.',
            ], 404);
        }

        if ($pesanan->status_pembayaran === 'lunas') {
            return response()->json([
                'status' => 'error',
                'message' => 'Pembayaran pesanan ini sudah terverifikasi Lunas.',
            ], 400);
        }

        $publicUrl = $this->storePaymentProof($request->file('bukti_foto'), (string) $pesanan->id_pesanan);
        $catatan = trim((string) ($data['catatan'] ?? ''));

        $payload = [
            'bukti_pembayaran' => $publicUrl,
            'status_pembayaran' => 'menunggu_verifikasi',
            'waktu_pembayaran' => now(),
            'catatan_admin' => null,
        ];

        if ($catatan !== '' && empty($pesanan->catatan_pembeli)) {
            $payload['catatan_pembeli'] = $catatan;
        }

        $pesanan->update($payload);

        return response()->json([
            'status' => 'success',
            'message' => 'Bukti pembayaran berhasil diunggah dan sedang menunggu verifikasi admin.',
            'bukti_url' => asset($publicUrl),
            'status_pembayaran' => 'menunggu_verifikasi',
        ]);
    }

    public function getSupportMessages()
    {
        $idPengunjung = $this->getPengunjungId();
        if (!$idPengunjung) {
            return $this->unauthenticatedResponse();
        }

        $messages = Pesan::where('id_pengunjung', $idPengunjung)
            ->where(function ($q) {
                $q->whereNull('id_umkm')->orWhere('tipe_pesan', 'support');
            })
            ->orderBy('waktu', 'asc')
            ->get()
            ->map(function ($p) {
                return [
                    'id_pesan' => $p->id_pesan,
                    'pengirim' => $p->pengirim,
                    'isi_pesan' => $p->isi_pesan,
                    'tipe_pesan' => $p->tipe_pesan ?? 'support',
                    'lampiran_url' => $p->lampiran_url ? asset($p->lampiran_url) : null,
                    'waktu' => $p->waktu ? $p->waktu->format('H:i') : '',
                ];
            });

        return response()->json([
            'status' => 'success',
            'messages' => $messages,
        ]);
    }

    public function sendSupportMessage(Request $request)
    {
        $idPengunjung = $this->getPengunjungId();
        if (!$idPengunjung) {
            return $this->unauthenticatedResponse();
        }

        $data = $request->validate([
            'isi_pesan' => 'required|string|max:1000',
        ]);

        $pesan = Pesan::create([
            'id_pengunjung' => $idPengunjung,
            'id_umkm' => null,
            'pengirim' => 'pengunjung',
            'isi_pesan' => $data['isi_pesan'],
            'tipe_pesan' => 'support',
            'waktu' => now(),
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

    public function submitUlasan(Request $request)
    {
        $idPengunjung = $this->getPengunjungId();
        if (!$idPengunjung) {
            return $this->unauthenticatedResponse(false, 'Silakan masuk dengan akun Google terlebih dahulu untuk memberikan ulasan.');
        }

        $data = $request->validate([
            'id_pesanan' => 'required|integer',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:500',
        ]);

        $pesanan = Pesanan::where('id_pesanan', $data['id_pesanan'])
            ->where('id_pengunjung', $idPengunjung)
            ->first();

        if (!$pesanan) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data pesanan tidak ditemukan.',
            ], 404);
        }

        if ($pesanan->status !== 'selesai' || $pesanan->status_pembayaran !== 'lunas') {
            return response()->json([
                'status' => 'error',
                'message' => 'Penilaian hanya dapat diberikan setelah pembayaran terverifikasi Lunas dan penjual menandai pesanan selesai.',
            ], 400);
        }

        if (Ulasan::where('id_pesanan', $pesanan->id_pesanan)->exists()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda sudah memberikan penilaian untuk pesanan ini.',
            ], 400);
        }

        $ulasan = Ulasan::create([
            'id_pesanan' => $pesanan->id_pesanan,
            'id_pengunjung' => $idPengunjung,
            'id_umkm' => $pesanan->id_umkm,
            'rating' => (int) $data['rating'],
            'komentar' => $data['komentar'] ?? null,
            'balasan_seller' => null,
            'disembunyikan' => false,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Terima kasih! Ulasan dan rating Anda telah berhasil disimpan.',
            'data' => $ulasan,
        ]);
    }

    private function getPengunjungId(): ?int
    {
        $idUser = session('user.id_user');
        if (!$idUser) {
            return null;
        }

        $user = Pengguna::find((int) $idUser);
        if (!$user || !$user->is_active) {
            session()->forget('user');
            return null;
        }

        return (int) $user->id_user;
    }

    private function unauthenticatedResponse(bool $withEmptyData = false, string $message = 'Silakan masuk dengan akun Google terlebih dahulu.')
    {
        $body = [
            'status' => 'unauthenticated',
            'message' => $message,
        ];

        if ($withEmptyData) {
            $body['data'] = [];
        }

        return response()->json($body, 401);
    }

    private function storePaymentProof(UploadedFile $file, string $prefix): string
    {
        $filename = 'bukti_' . $prefix . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('bukti_pembayaran', $filename, 'public');

        return '/storage/' . $path;
    }
}
