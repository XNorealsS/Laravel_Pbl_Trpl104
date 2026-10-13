<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** Tabel t_ulasan: ulasan pengunjung, ditulis setelah pesanan berstatus "selesai". */
class Ulasan extends Model
{
    protected $table = 't_ulasan';
    protected $primaryKey = 'id_ulasan';

    protected $fillable = [
        'id_pesanan', 'id_pengunjung', 'id_umkm', 'rating',
        'komentar', 'balasan_seller', 'disembunyikan',
    ];

    protected $casts = [
        'rating' => 'integer',
        'disembunyikan' => 'boolean',
    ];

    public function pengunjung(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'id_pengunjung', 'id_user');
    }

    public function umkm(): BelongsTo
    {
        return $this->belongsTo(Umkm::class, 'id_umkm', 'id_umkm');
    }

    public function pesanan(): BelongsTo
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan', 'id_pesanan');
    }
}
