<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - JajanRia (PBL TRPL 104)
|--------------------------------------------------------------------------
*/

// 1. Landing Page Utama
Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::get('/landing', function () {
    return redirect()->route('landing');
});

// 2. Halaman Login (Frontend Only, No Backend Required)
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function () {
    return redirect()->route('dashboard')->with('success', 'Berhasil masuk!');
});

// 3. Halaman Register
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', function () {
    return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Silakan masuk.');
});

// 4. Halaman Dashboard Pengguna / Katalog
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/katalog', function () {
    return redirect()->route('dashboard');
});

// 5. Dashboard Seller (Pelaku UMKM - UC-05, UC-06, UC-07, F011)
Route::get('/seller', function () {
    return view('seller.dashboard');
})->name('seller');

Route::get('/seller/dashboard', function () {
    return redirect()->route('seller');
});

// 6. Panel Administrator (Pengelola Platform - UC-08, UC-09, UC-10, UC-11)
Route::get('/admin', function () {
    return view('admin.dashboard');
})->name('admin');

Route::get('/admin/dashboard', function () {
    return redirect()->route('admin');
});

