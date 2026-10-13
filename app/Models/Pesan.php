<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** Tabel t_pesan: riwayat pesan chat antara pengunjung dan seller. */
class Pesan extends Model
{
    protected $table = 't_pesan';
    protected $primaryKey = 'id_pesan';

    protected $fillable = [
        'id_pengunjung',
        'id_umkm',
        'pengirim',
        'isi_pesan',
        'waktu',
    ];

    protected $casts = [
        'waktu' => 'datetime',
    ];

    public function pengunjung(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'id_pengunjung', 'id_user');
    }

    public function umkm(): BelongsTo
    {
        return $this->belongsTo(Umkm::class, 'id_umkm', 'id_umkm');
    }
}
