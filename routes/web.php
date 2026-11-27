<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\UmkmController;
use Illuminate\Support\Facades\Route;

// Katalog publik dan detail lapak
Route::get('/', [UmkmController::class, 'index'])->name('landing');
Route::get('/landing', fn () => redirect()->route('landing'));
Route::get('/katalog', fn () => redirect()->route('landing'));
Route::get('/toko/{id}', [UmkmController::class, 'show'])->name('store.detail')->whereNumber('id');

Route::get('/dashboard', function () {
    $role = session('user.role');
    if ($role === 'seller') {
        return redirect()->route('seller');
    }
    if ($role === 'admin') {
        return redirect()->route('admin');
    }

    return redirect()->route('landing');
})->name('dashboard');

// Autentikasi pengguna
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/auth/firebase-google', [AuthController::class, 'firebaseGoogleLogin'])->name('auth.firebase.google');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

// API pesanan, bukti pembayaran, dukungan pelanggan, dan ulasan
Route::prefix('api')->group(function () {
    Route::post('/orders/checkout', [ChatController::class, 'checkoutOrder'])->name('api.orders.checkout');
    Route::post('/orders/upload-bukti', [ChatController::class, 'uploadBuktiPembayaran'])->name('api.orders.upload_bukti');
    Route::get('/orders/history', [ChatController::class, 'getOrderHistory'])->name('api.orders.history');

    Route::get('/support/messages', [ChatController::class, 'getSupportMessages'])->name('api.support.messages');
    Route::post('/support/send', [ChatController::class, 'sendSupportMessage'])->name('api.support.send');

    // Alias rute lama untuk kompatibilitas frontend
    Route::get('/chat/conversations', [ChatController::class, 'getConversations'])->name('api.chat.conversations');
    Route::get('/chat/history', [ChatController::class, 'getOrderHistory'])->name('api.chat.history');
    Route::get('/chat/{idUmkm}', [ChatController::class, 'getMessages'])->name('api.chat.messages');
    Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('api.chat.send');
    Route::post('/chat/checkout', [ChatController::class, 'checkoutOrder'])->name('api.chat.checkout');
    Route::post('/chat/upload-bukti', [ChatController::class, 'uploadBuktiPembayaran'])->name('api.chat.upload_bukti');
    Route::post('/ulasan/store', [ChatController::class, 'submitUlasan'])->name('api.ulasan.store');
});

// Dasbor Seller
Route::prefix('seller')->middleware('role:seller')->group(function () {
    Route::get('/', [SellerController::class, 'index'])->name('seller');
    Route::get('/dashboard', fn () => redirect()->route('seller'));

    Route::post('/profile', [SellerController::class, 'updateProfile'])->name('seller.profile.update');
    Route::post('/products', [SellerController::class, 'storeProduct'])->name('seller.products.store');
    Route::post('/products/{id}/update', [SellerController::class, 'updateProduct'])->name('seller.products.update');
    Route::post('/products/{id}/delete', [SellerController::class, 'deleteProduct'])->name('seller.products.delete');
    Route::post('/products/{id}/toggle-availability', [SellerController::class, 'toggleProductAvailability'])->name('seller.products.toggle_availability');

    Route::post('/orders/{id}/status', [SellerController::class, 'updateOrderStatus'])->name('seller.orders.status');
    Route::post('/orders/{id}/verify-payment', [SellerController::class, 'verifyPayment'])->name('seller.orders.verify_payment');
    Route::post('/messages/reply', [SellerController::class, 'replyMessage'])->name('seller.messages.reply');
    Route::post('/reviews/{id}/reply', [SellerController::class, 'replyReview'])->name('seller.reviews.reply');
});

// Panel Administrator
Route::prefix('admin')->middleware('role:admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin');
    Route::get('/dashboard', fn () => redirect()->route('admin'));

    Route::post('/sellers/{id}/verify', [AdminController::class, 'verifySeller'])->name('admin.sellers.verify');
    Route::post('/users/{id}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('admin.users.toggle');

    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('admin.categories.store');
    Route::post('/categories/{id}/delete', [AdminController::class, 'deleteCategory'])->name('admin.categories.delete');

    Route::post('/reviews/{id}/toggle-hide', [AdminController::class, 'toggleHideReview'])->name('admin.reviews.toggle_hide');
    Route::post('/payments/{id}/verify', [AdminController::class, 'verifyPayment'])->name('admin.payments.verify');
    Route::post('/support/{id}/reply', [AdminController::class, 'replySupportMessage'])->name('admin.support.reply');
});
