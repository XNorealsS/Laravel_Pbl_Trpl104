<?php

namespace App\Http\Middleware;

use App\Models\Pengguna;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $sessionUser = session('user');
        $userId = is_array($sessionUser) ? ($sessionUser['id_user'] ?? null) : null;

        if (!$userId) {
            return $this->deny($request, 401, 'Silakan masuk terlebih dahulu.', 'Silakan masuk terlebih dahulu untuk mengakses halaman ini.');
        }

        $user = Pengguna::find($userId);
        if (!$user || !$user->is_active) {
            session()->forget('user');
            return $this->deny($request, 403, 'Akun Anda tidak aktif.', 'Akun Anda tidak aktif atau tidak ditemukan.');
        }

        if ($user->role === 'seller' && $user->status_verifikasi !== 'terverifikasi') {
            session()->forget('user');
            return $this->deny($request, 403, 'Akun Seller belum terverifikasi.', 'Akun Seller Anda belum terverifikasi Administrator.');
        }

        if ($user->role !== $role) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'forbidden',
                    'message' => 'Anda tidak memiliki izin akses untuk halaman ini.',
                ], 403);
            }

            abort(403, 'Akses ditolak: halaman ini khusus untuk peran ' . ucfirst($role) . '.');
        }

        return $next($request);
    }

    private function deny(Request $request, int $status, string $jsonMessage, string $webMessage): Response
    {
        if ($request->expectsJson()) {
            return response()->json([
                'status' => $status === 401 ? 'unauthenticated' : 'forbidden',
                'message' => $jsonMessage,
            ], $status);
        }

        return redirect()->route('login')->with('error', $webMessage);
    }
}
