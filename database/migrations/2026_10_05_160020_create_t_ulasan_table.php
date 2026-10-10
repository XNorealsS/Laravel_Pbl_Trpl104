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
            $table->increments('id_pesanan');

            $table->unsignedInteger('id_pengunjung');
            $table->unsignedInteger('id_umkm');

            $table->enum('status', [
                'diproses',
                'selesai'
            ])->default('diproses');

            $table->dateTime('waktu_selesai')->nullable();

            $table->timestamps();

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
