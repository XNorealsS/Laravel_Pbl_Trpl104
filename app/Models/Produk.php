<?php

namespace App\Models;

use App\Models\Concerns\HasFotoUrl;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** Tabel t_produk: menu/produk milik lapak (hanya katalog, tanpa stok/kuantitas). */
class Produk extends Model
{
    use HasFotoUrl;

    protected $table = 't_produk';
    protected $primaryKey = 'id_produk';

    protected $fillable = [
        'id_umkm', 'id_kategori', 'nama_produk', 'foto_produk',
        'deskripsi', 'harga', 'tersedia',
    ];

    protected $casts = [
        'harga' => 'float',
        'tersedia' => 'boolean',
    ];

    public function umkm(): BelongsTo
    {
        return $this->belongsTo(Umkm::class, 'id_umkm', 'id_umkm');
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    public function getFotoUrlAttribute(): ?string
    {
        return $this->fotoUrl($this->foto_produk);
    }
}
