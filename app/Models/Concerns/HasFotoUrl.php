<?php

namespace App\Models\Concerns;

trait HasFotoUrl
{
    /**
     * Ubah nilai kolom foto menjadi URL yang bisa ditampilkan.
     * Mendukung URL penuh, file di /public, atau file hasil upload di storage.
     */
    protected function fotoUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        if (preg_match('#^https?://#i', $path)) {
            return $path;
        }

        if (file_exists(public_path($path))) {
            return asset($path);
        }

        return asset('storage/' . ltrim($path, '/'));
    }
}
