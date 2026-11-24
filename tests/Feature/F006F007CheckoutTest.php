<?php

namespace Tests\Feature;

use App\Models\Pengguna;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\Umkm;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class F006F007CheckoutTest extends TestCase
{
    use DatabaseTransactions;

    private function createPengunjungSession(): array
    {
        $pengunjung = Pengguna::where('role', 'pengunjung')->where('is_active', true)->firstOrFail();

        return [
            'user' => [
                'id_user' => $pengunjung->id_user,
                'nama' => $pengunjung->nama,
                'email' => $pengunjung->email,
                'role' => 'pengunjung',
            ],
        ];
    }

    public function test_guest_cannot_checkout(): void
    {
        $response = $this->postJson(route('api.orders.checkout'), [
            'id_umkm' => 1,
            'items' => [['id_produk' => 1, 'qty' => 1]],
        ]);

        $response->assertStatus(401)
            ->assertJson(['status' => 'unauthenticated']);
    }

    public function test_f006_checkout_computes_server_total_saves_note_and_blocks_unavailable_menu(): void
    {
        $umkm = Umkm::tampil()->firstOrFail();
        $produkTersedia = Produk::where('id_umkm', $umkm->id_umkm)->where('tersedia', true)->firstOrFail();

        $session = $this->createPengunjungSession();
        $qty = 2;
        $expectedTotal = $qty * (int) round($produkTersedia->harga);

        // Kirim harga manipulatif dari client; server wajib menghitung dari t_produk
        $response = $this->withSession($session)->postJson(route('api.orders.checkout'), [
            'id_umkm' => $umkm->id_umkm,
            'items' => [
                ['id_produk' => $produkTersedia->id_produk, 'qty' => $qty, 'harga' => 1],
            ],
            'catatan' => 'Tidak pakai sambal',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'pesanan' => [
                    'status' => 'diproses',
                    'status_pembayaran' => 'belum_bayar',
                    'total_harga' => $expectedTotal,
                ],
            ]);

        $orderId = $response->json('pesanan.id_pesanan');
        $this->assertDatabaseHas('t_pesanan', [
            'id_pesanan' => $orderId,
            'total_harga' => $expectedTotal,
            'catatan_pembeli' => 'Tidak pakai sambal',
            'status_pembayaran' => 'belum_bayar',
        ]);

        // Set produk menjadi habis (tersedia = false) -> checkout harus ditolak 422
        $produkTersedia->update(['tersedia' => false]);

        $failResponse = $this->withSession($session)->postJson(route('api.orders.checkout'), [
            'id_umkm' => $umkm->id_umkm,
            'items' => [
                ['id_produk' => $produkTersedia->id_produk, 'qty' => 1],
            ],
        ]);

        $failResponse->assertStatus(422)
            ->assertJson(['status' => 'error']);
    }

    public function test_f007_upload_payment_proof_at_checkout_and_history_and_block_when_lunas(): void
    {
        Storage::fake('public');

        $umkm = Umkm::tampil()->firstOrFail();
        $produk = Produk::where('id_umkm', $umkm->id_umkm)->where('tersedia', true)->firstOrFail();
        $session = $this->createPengunjungSession();

        // 1. Upload bukti langsung saat checkout
        $checkoutRes = $this->withSession($session)->post(route('api.orders.checkout'), [
            'id_umkm' => $umkm->id_umkm,
            'items' => json_encode([['id_produk' => $produk->id_produk, 'qty' => 1]]),
            'bukti_foto' => UploadedFile::fake()->image('struk_checkout.jpg'),
        ], ['Accept' => 'application/json']);

        $checkoutRes->assertStatus(200)
            ->assertJsonPath('pesanan.status_pembayaran', 'menunggu_verifikasi');

        // 2. Checkout tanpa foto lalu unggah lewat endpoint History Pesanan
        $orderNoProof = Pesanan::create([
            'id_pengunjung' => $session['user']['id_user'],
            'id_umkm' => $umkm->id_umkm,
            'status' => 'diproses',
            'items_detail' => [['id_produk' => $produk->id_produk, 'nama_produk' => $produk->nama_produk, 'harga' => (int) round($produk->harga), 'qty' => 1, 'subtotal' => (int) round($produk->harga)]],
            'total_harga' => (int) round($produk->harga),
            'status_pembayaran' => 'belum_bayar',
        ]);

        $uploadRes = $this->withSession($session)->post(route('api.orders.upload_bukti'), [
            'id_pesanan' => $orderNoProof->id_pesanan,
            'bukti_foto' => UploadedFile::fake()->image('struk_history.png'),
        ], ['Accept' => 'application/json']);

        $uploadRes->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'status_pembayaran' => 'menunggu_verifikasi',
            ]);

        // 3. Jika status sudah lunas, unggah ulang wajib ditolak (HTTP 400)
        $orderNoProof->update(['status_pembayaran' => 'lunas']);

        $blockedRes = $this->withSession($session)->post(route('api.orders.upload_bukti'), [
            'id_pesanan' => $orderNoProof->id_pesanan,
            'bukti_foto' => UploadedFile::fake()->image('struk_ulang.jpg'),
        ], ['Accept' => 'application/json']);

        $blockedRes->assertStatus(400)
            ->assertJson(['status' => 'error']);
    }
}
