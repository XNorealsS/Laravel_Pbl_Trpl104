<?php

namespace App\Models;

use App\Models\Concerns\HasFotoUrl;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/** Tabel t_umkm: profil lapak milik seller. */
class Umkm extends Model
{
    use HasFotoUrl;

    protected $table = 't_umkm';
    protected $primaryKey = 'id_umkm';

    protected $fillable = [
        'id_user', 'nama_usaha', 'deskripsi', 'lokasi', 'area', 'kontak', 'foto_usaha',
    ];

    public function pemilik(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'id_user', 'id_user');
    }

    public function produk(): HasMany
    {
        return $this->hasMany(Produk::class, 'id_umkm', 'id_umkm');
    }

    public function ulasan(): HasMany
    {
        return $this->hasMany(Ulasan::class, 'id_umkm', 'id_umkm');
    }

    /** Hanya lapak milik seller yang sudah diverifikasi admin & aktif yang tampil publik. */
    public function scopeTampil(Builder $query): Builder
    {
        return $query->whereHas('pemilik', function (Builder $q) {
            $q->where('status_verifikasi', 'terverifikasi')->where('is_active', true);
        });
    }

    public function getFotoUrlAttribute(): ?string
    {
        return $this->fotoUrl($this->foto_usaha);
    }
}
