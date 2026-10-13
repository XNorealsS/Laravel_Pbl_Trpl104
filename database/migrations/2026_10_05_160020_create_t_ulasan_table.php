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
        Schema::create('t_ulasan', function (Blueprint $table) {
            $table->increments('id_ulasan');

            $table->unsignedInteger('id_pesanan')->unique();
            $table->unsignedInteger('id_pengunjung');
            $table->unsignedInteger('id_umkm');
            $table->unsignedInteger('id_produk')->nullable();

            $table->unsignedTinyInteger('rating'); // 1 - 5
            $table->text('komentar')->nullable();
            $table->text('balasan_seller')->nullable();
            $table->boolean('disembunyikan')->default(false);

            $table->timestamps();

            $table->foreign('id_pesanan')
                ->references('id_pesanan')
                ->on('t_pesanan')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('id_pengunjung')
                ->references('id_user')
                ->on('t_user')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('id_umkm')
                ->references('id_umkm')
                ->on('t_umkm')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('id_produk')
                ->references('id_produk')
                ->on('t_produk')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_ulasan');
    }
};
