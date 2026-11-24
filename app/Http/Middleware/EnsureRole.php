<?php

namespace App\Http\Middleware;

use App\Models\Pengguna;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    /**
     * Pastikan pengguna sudah login, aktif, terverifikasi (untuk seller), dan memiliki peran yang sesuai.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $sessionUser = session('user');
        $userId = is_array($sessionUser) ? ($sessionUser['id_user'] ?? null) : null;

        if (!$userId) {
            return $request->expectsJson()
                ? response()->json(['status' => 'unauthenticated', 'message' => 'Silakan masuk terlebih dahulu.'], 401)
                : redirect()->route('login')->with('error', 'Silakan masuk terlebih dahulu untuk mengakses halaman ini.');
        }

        $user = Pengguna::find($userId);
        if (!$user || !$user->is_active) {
            session()->forget('user');
            return $request->expectsJson()
                ? response()->json(['status' => 'forbidden', 'message' => 'Akun Anda tidak aktif.'], 403)
                : redirect()->route('login')->with('error', 'Akun Anda tidak aktif atau tidak ditemukan.');
        }

        if ($user->role === 'seller' && $user->status_verifikasi !== 'terverifikasi') {
            session()->forget('user');
            return $request->expectsJson()
                ? response()->json(['status' => 'forbidden', 'message' => 'Akun Seller belum terverifikasi.'], 403)
                : redirect()->route('login')->with('error', 'Akun Seller Anda belum terverifikasi Administrator.');
        }

        if ($user->role !== $role) {
            if ($request->expectsJson()) {
                return response()->json(['status' => 'forbidden', 'message' => 'Anda tidak memiliki izin akses untuk halaman ini.'], 403);
            }
            abort(403, 'Akses ditolak: halaman ini khusus untuk peran ' . ucfirst($role) . '.');
        }

        return $next($request);
    }
}
