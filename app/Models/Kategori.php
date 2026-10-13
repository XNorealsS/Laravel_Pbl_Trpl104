<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/** Tabel t_kategori: master kategori menu. */
class Kategori extends Model
{
    protected $table = 't_kategori';
    protected $primaryKey = 'id_kategori';

    protected $fillable = ['nama_kategori'];

    public function produk(): HasMany
    {
        return $this->hasMany(Produk::class, 'id_kategori', 'id_kategori');
    }
}
