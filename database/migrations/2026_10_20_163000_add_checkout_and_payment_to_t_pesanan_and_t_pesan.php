<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('t_pesanan', function (Blueprint $table) {
            $table->json('items_detail')->nullable()->after('id_umkm');
            $table->unsignedInteger('total_harga')->default(0)->after('items_detail');
            $table->string('bukti_pembayaran')->nullable()->after('total_harga');
            $table->enum('status_pembayaran', [
                'belum_bayar',
                'menunggu_verifikasi',
                'lunas',
                'ditolak'
            ])->default('belum_bayar')->after('bukti_pembayaran');
            $table->string('catatan_admin')->nullable()->after('status_pembayaran');
            $table->dateTime('waktu_pembayaran')->nullable()->after('catatan_admin');
        });

        Schema::table('t_pesan', function (Blueprint $table) {
            $table->string('tipe_pesan', 30)->default('teks')->after('isi_pesan');
            $table->string('lampiran_url')->nullable()->after('tipe_pesan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('t_pesanan', function (Blueprint $table) {
            $table->dropColumn([
                'items_detail',
                'total_harga',
                'bukti_pembayaran',
                'status_pembayaran',
                'catatan_admin',
                'waktu_pembayaran'
            ]);
        });

        Schema::table('t_pesan', function (Blueprint $table) {
            $table->dropColumn([
                'tipe_pesan',
                'lampiran_url'
            ]);
        });
    }
};
