<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/** Tabel t_user: pengunjung (Google), seller & admin (email + password). */
class Pengguna extends Model
{
    protected $table = 't_user';
    protected $primaryKey = 'id_user';

    protected $fillable = [
        'nama', 'email', 'password', 'firebase_uid', 'foto_profil',
        'role', 'status_verifikasi', 'is_active',
    ];

    protected $hidden = ['password'];

    protected $casts = [
        'is_active' => 'boolean',
        'password' => 'hashed',
    ];

    public function umkm(): HasMany
    {
        return $this->hasMany(Umkm::class, 'id_user', 'id_user');
    }

    public function lapak(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Umkm::class, 'id_user', 'id_user');
    }
}
