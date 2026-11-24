<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambah kolom catatan_pembeli agar catatan pesanan pembeli tidak bercampur dengan catatan_admin.
     */
    public function up(): void
    {
        Schema::table('t_pesanan', function (Blueprint $table) {
            $table->text('catatan_pembeli')->nullable()->after('items_detail');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('t_pesanan', function (Blueprint $table) {
            $table->dropColumn('catatan_pembeli');
        });
    }
};
