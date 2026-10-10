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
        Schema::create('t_user', function (Blueprint $table) {
            $table->increments('id_user');

            $table->string('nama', 100);
            $table->string('email', 100)->unique();
            $table->string('password', 255)->nullable();
            $table->string('firebase_uid', 128)->nullable();
            $table->string('foto_profil', 255)->nullable();

            $table->enum('role', [
                'pengunjung',
                'seller',
                'admin'
            ]);

            $table->enum('status_verifikasi', [
                'menunggu',
                'terverifikasi',
                'ditolak'
            ])->default('menunggu');

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_user');
    }
};
