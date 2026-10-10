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
        Schema::create('t_produk', function (Blueprint $table) {
            $table->increments('id_produk');

            $table->unsignedInteger('id_umkm');
            $table->unsignedInteger('id_kategori');

            $table->string('nama_produk', 150);
            $table->string('foto_produk', 255)->nullable();
            $table->text('deskripsi')->nullable();
            $table->decimal('harga', 10,2);
            $table->boolean('tersedia')->default(true);

            $table->timestamps();
            
            $table->foreign('id_umkm')
                ->references('id_umkm')
                ->on('t_umkm')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('id_kategori')
                ->references('id_kategori')
                ->on('t_kategori')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_produk');
    }
};
