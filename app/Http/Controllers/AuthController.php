<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (session()->has('user')) {
            return $this->redirectByRole((string) session('user.role'));
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $provider = $request->input('provider');
        $quickRole = $request->input('quick_role');

        // Akses cepat untuk demo dan pengujian per peran
        if ($provider === 'google' || $quickRole === 'pengunjung') {
            $user = Pengguna::where('role', 'pengunjung')->where('is_active', true)->first();

            if (!$user) {
                $user = Pengguna::create([
                    'nama' => 'Pengunjung Google',
                    'email' => 'pengunjung@jajanria.test',
                    'password' => 'password',
                    'role' => 'pengunjung',
                    'status_verifikasi' => 'terverifikasi',
                    'is_active' => true,
                ]);
            }

            $this->setUserSession($user);
            return redirect()->route('landing')
                ->with('success', 'Berhasil masuk dengan akun Google! Fitur chat tersedia di pojok kanan bawah.');
        }

        if ($quickRole === 'seller') {
            $user = Pengguna::where('role', 'seller')
                ->where('status_verifikasi', 'terverifikasi')
                ->where('is_active', true)
                ->first();

            if (!$user) {
                return back()->with('error', 'Belum ada akun Seller aktif dan terverifikasi untuk akses cepat.');
            }

            $this->setUserSession($user);
            return redirect()->route('seller')->with('success', 'Selamat datang di Dashboard Seller!');
        }

        if ($quickRole === 'admin') {
            $user = Pengguna::where('role', 'admin')->where('is_active', true)->first();

            if ($user) {
                $this->setUserSession($user);
                return redirect()->route('admin')->with('success', 'Selamat datang di Panel Admin JajanRia!');
            }
        }

        $email = trim((string) $request->input('email', ''));
        $password = (string) $request->input('password', '');
        $user = Pengguna::where('email', $email)->first();

        if (!$user || empty($user->password) || !Hash::check($password, $user->password)) {
            return back()->with('error', 'Email atau kata sandi tidak cocok. Silakan coba lagi.');
        }

        if (!$user->is_active) {
            return back()->with('error', 'Akun Anda dinonaktifkan oleh Administrator. Hubungi pengelola platform untuk info lebih lanjut.');
        }

        if ($user->role === 'seller' && $user->status_verifikasi === 'menunggu') {
            return back()->with('error', 'Pendaftaran akun Seller Anda masih dalam proses peninjauan / menunggu verifikasi Admin.');
        }

        if ($user->role === 'seller' && $user->status_verifikasi === 'ditolak') {
            return back()->with('error', 'Mohon maaf, pengajuan pendaftaran Seller Anda ditolak oleh Admin.');
        }

        $this->setUserSession($user);

        if ($user->role === 'seller') {
            return redirect()->route('seller')->with('success', 'Berhasil masuk ke Dashboard Seller!');
        }

        if ($user->role === 'admin') {
            return redirect()->route('admin')->with('success', 'Berhasil masuk ke Panel Administrator!');
        }

        return redirect()->route('landing')->with('success', 'Berhasil masuk! Selamat berbelanja jajanan.');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'password' => 'required|string|min:4',
            'nama_usaha' => 'required|string|max:150',
            'area' => 'required|string|max:100',
            'lokasi' => 'nullable|string|max:255',
            'kontak' => 'required|string|max:30',
            'store_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        if (Pengguna::where('email', $data['email'])->exists()) {
            return back()->with('error', 'Email sudah terdaftar. Silakan gunakan email lain atau masuk.')->withInput();
        }

        $fotoPath = null;
        if ($request->hasFile('store_photo')) {
            $file = $request->file('store_photo');
            $filename = 'umkm_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $fotoPath = $file->storeAs('umkm', $filename, 'public');
        }

        // Akun Seller baru berstatus menunggu sampai disetujui Administrator
        $user = Pengguna::create([
            'nama' => $data['nama'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => 'seller',
            'status_verifikasi' => 'menunggu',
            'is_active' => true,
        ]);

        Umkm::create([
            'id_user' => $user->id_user,
            'nama_usaha' => $data['nama_usaha'],
            'deskripsi' => trim((string) $request->input('deskripsi')) ?: 'Lapak jajanan UMKM di area kampus Polibatam.',
            'lokasi' => trim((string) ($data['lokasi'] ?? '')) ?: $data['area'],
            'area' => $data['area'],
            'kontak' => $data['kontak'],
            'foto_usaha' => $fotoPath,
        ]);

        return redirect()->route('login')
            ->with('success', 'Pendaftaran Mitra UMKM berhasil! Akun Anda sedang menunggu verifikasi Administrator.');
    }

    public function firebaseGoogleLogin(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email|max:100',
            'nama' => 'nullable|string|max:100',
            'firebase_uid' => 'nullable|string|max:128',
            'foto_profil' => 'nullable|string|max:255',
        ]);

        $email = strtolower(trim($data['email']));
        $nama = trim((string) ($data['nama'] ?? '')) ?: 'Pengunjung JajanRia';
        $uid = $data['firebase_uid'] ?? null;
        $foto = $data['foto_profil'] ?? null;

        $user = Pengguna::where('email', $email)->first();
        if (!$user && $uid) {
            $user = Pengguna::where('firebase_uid', $uid)->first();
        }

        if ($user) {
            if (!$user->is_active) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Akun Anda dinonaktifkan oleh Administrator.',
                ], 403);
            }

            if (!$user->firebase_uid && $uid) {
                $user->firebase_uid = $uid;
            }
            if (!$user->foto_profil && $foto) {
                $user->foto_profil = $foto;
            }
            $user->save();
        } else {
            // Pengunjung Google otomatis terdaftar tanpa form registrasi manual
            $user = Pengguna::create([
                'nama' => $nama,
                'email' => $email,
                'password' => null,
                'firebase_uid' => $uid,
                'foto_profil' => $foto,
                'role' => 'pengunjung',
                'status_verifikasi' => 'terverifikasi',
                'is_active' => true,
            ]);
        }

        $this->setUserSession($user, true);

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil masuk dengan akun Google!',
            'redirect' => $this->routeUrlByRole($user->role),
            'user' => [
                'id_user' => $user->id_user,
                'nama' => $user->nama,
                'role' => $user->role,
            ],
        ]);
    }

    public function logout()
    {
        session()->forget('user');
        return redirect()->route('landing')->with('info', 'Anda telah keluar dari akun.');
    }

    private function setUserSession(Pengguna $user, bool $includePhoto = false): void
    {
        $payload = [
            'id_user' => $user->id_user,
            'nama' => $user->nama,
            'email' => $user->email,
            'role' => $user->role,
        ];

        if ($includePhoto) {
            $payload['foto_profil'] = $user->foto_profil;
        }

        session(['user' => $payload]);
    }

    private function redirectByRole(string $role)
    {
        return redirect($this->routeUrlByRole($role));
    }

    private function routeUrlByRole(string $role): string
    {
        if ($role === 'seller') {
            return route('seller');
        }
        if ($role === 'admin') {
            return route('admin');
        }

        return route('landing');
    }
}
