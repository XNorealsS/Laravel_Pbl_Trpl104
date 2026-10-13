<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** Tabel t_pesanan: status percakapan/pesanan (diproses -> selesai). */
class Pesanan extends Model
{
    protected $table = 't_pesanan';
    protected $primaryKey = 'id_pesanan';

    protected $fillable = ['id_pengunjung', 'id_umkm', 'status', 'waktu_selesai'];

    protected $casts = ['waktu_selesai' => 'datetime'];

    public function umkm(): BelongsTo
    {
        return $this->belongsTo(Umkm::class, 'id_umkm', 'id_umkm');
    }

    public function pengunjung(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'id_pengunjung', 'id_user');
    }
}
