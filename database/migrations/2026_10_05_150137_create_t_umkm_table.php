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
        Schema::create('t_umkm', function (Blueprint $table) {
            $table->increments('id_umkm');

            $table->unsignedInteger('id_user');

            $table->string('nama_usaha', 150);
            $table->text('deskripsi')->nullable();
            $table->string('lokasi', 255);
            $table->string('area', 100);
            $table->string('kontak', 30);
            $table->string('foto_usaha', 255)->nullable();

            $table->timestamps();

            $table->foreign('id_user')
                ->references('id_user')
                ->on('t_user')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_umkm');
    }
};
