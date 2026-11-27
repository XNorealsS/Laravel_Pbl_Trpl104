<?php

namespace Tests\Feature;

use App\Models\Pengguna;
use App\Models\Pesanan;
use App\Models\Umkm;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class F008F009OrderVerificationTest extends TestCase
{
    use DatabaseTransactions;

    public function test_f008_admin_can_approve_and_reject_payment_and_keep_payments_tab(): void
    {
        $admin = Pengguna::where('role', 'admin')->where('is_active', true)->firstOrFail();
        $pengunjung = Pengguna::where('role', 'pengunjung')->where('is_active', true)->firstOrFail();
        $umkm = Umkm::tampil()->firstOrFail();

        $order = Pesanan::create([
            'id_pengunjung' => $pengunjung->id_user,
            'id_umkm' => $umkm->id_umkm,
            'status' => 'diproses',
            'items_detail' => [['id_produk' => 1, 'nama_produk' => 'Menu Uji', 'harga' => 12000, 'qty' => 1, 'subtotal' => 12000]],
            'total_harga' => 12000,
            'status_pembayaran' => 'menunggu_verifikasi',
        ]);

        $adminSession = [
            'user' => [
                'id_user' => $admin->id_user,
                'nama' => $admin->nama,
                'email' => $admin->email,
                'role' => 'admin',
            ],
        ];

        $rejectRes = $this->withSession($adminSession)->post(route('admin.payments.verify', $order->id_pesanan), [
            'status' => 'ditolak',
            'catatan' => 'Nominal tidak sesuai',
            'active_tab' => 'payments',
        ]);

        $rejectRes->assertRedirect(route('admin', ['tab' => 'payments']));
        $this->assertDatabaseHas('t_pesanan', [
            'id_pesanan' => $order->id_pesanan,
            'status_pembayaran' => 'ditolak',
            'catatan_admin' => 'Nominal tidak sesuai',
        ]);

        $approveRes = $this->withSession($adminSession)->post(route('admin.payments.verify', $order->id_pesanan), [
            'status' => 'lunas',
            'active_tab' => 'payments',
        ]);

        $approveRes->assertRedirect(route('admin', ['tab' => 'payments']));
        $this->assertDatabaseHas('t_pesanan', [
            'id_pesanan' => $order->id_pesanan,
            'status_pembayaran' => 'lunas',
        ]);
    }

    public function test_f009_seller_cannot_finish_unpaid_order_but_can_finish_after_lunas(): void
    {
        $umkm = Umkm::tampil()->firstOrFail();
        $seller = Pengguna::findOrFail($umkm->id_user);
        $pengunjung = Pengguna::where('role', 'pengunjung')->where('is_active', true)->firstOrFail();

        $order = Pesanan::create([
            'id_pengunjung' => $pengunjung->id_user,
            'id_umkm' => $umkm->id_umkm,
            'status' => 'diproses',
            'items_detail' => [['id_produk' => 1, 'nama_produk' => 'Menu Self Pickup', 'harga' => 18000, 'qty' => 1, 'subtotal' => 18000]],
            'catatan_pembeli' => 'Ambil jam 12',
            'total_harga' => 18000,
            'status_pembayaran' => 'menunggu_verifikasi',
        ]);

        $sellerSession = [
            'user' => [
                'id_user' => $seller->id_user,
                'nama' => $seller->nama,
                'email' => $seller->email,
                'role' => 'seller',
            ],
        ];

        // 1. Belum lunas -> ditolak selesai
        $blockedRes = $this->withSession($sellerSession)->post(route('seller.orders.status', $order->id_pesanan), [
            'status' => 'selesai',
            'active_tab' => 'orders',
        ]);
        $blockedRes->assertRedirect(route('seller', ['tab' => 'orders']))
            ->assertSessionHas('error');

        $this->assertDatabaseHas('t_pesanan', [
            'id_pesanan' => $order->id_pesanan,
            'status' => 'diproses',
        ]);

        // 2. Setelah lunas -> berhasil selesai & waktu_selesai tercatat
        $order->update(['status_pembayaran' => 'lunas']);

        $okRes = $this->withSession($sellerSession)->post(route('seller.orders.status', $order->id_pesanan), [
            'status' => 'selesai',
            'active_tab' => 'orders',
        ]);
        $okRes->assertRedirect(route('seller', ['tab' => 'orders']))
            ->assertSessionHas('success');

        $order->refresh();
        $this->assertSame('selesai', $order->status);
        $this->assertNotNull($order->waktu_selesai);
    }

    public function test_ensure_role_blocks_pengunjung_from_f008_and_f009_routes(): void
    {
        $pengunjung = Pengguna::where('role', 'pengunjung')->where('is_active', true)->firstOrFail();
        $session = [
            'user' => [
                'id_user' => $pengunjung->id_user,
                'nama' => $pengunjung->nama,
                'email' => $pengunjung->email,
                'role' => 'pengunjung',
            ],
        ];

        $this->withSession($session)
            ->post(route('admin.payments.verify', 1), ['status' => 'lunas'])
            ->assertStatus(403);

        $this->withSession($session)
            ->post(route('seller.orders.status', 1), ['status' => 'selesai'])
            ->assertStatus(403);
    }
}
