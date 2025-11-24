<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\CustomerAuthController;

// Arahkan '/' ke HomeController index
Route::get('/', [HomeController::class, 'index'])->name('home');

// 2. Detail Produk (detail_produk.php)
// URL akan menjadi: /detail/P0001
Route::get('/detail/{kode_produk}', [ProdukController::class, 'show'])->name('produk.detail');

// 3. Authentication (Login & Register Customer)
Route::middleware('guest')->group(function () {
    // Login (user_login.php)
    Route::get('/login', [CustomerAuthController::class, 'showLoginForm'])->name('login.form');
    Route::post('/login', [CustomerAuthController::class, 'login'])->name('login');

    // Register (register.php)
    Route::get('/register', [CustomerAuthController::class, 'showRegisterForm'])->name('register.form');
    Route::post('/register', [CustomerAuthController::class, 'register'])->name('register');
});

// Logout (proses/logout.php)
Route::post('/logout', [CustomerAuthController::class, 'logout'])->name('logout');


// 4. Fitur yang Butuh Login (Keranjang & Checkout)
// Kita bungkus dengan middleware 'auth' (atau cek session manual jika Anda belum setup Guard)
Route::group(['middleware' => 'web'], function () { // Nanti ganti 'auth' jika sistem login sudah fix
    
    // Halaman Keranjang (keranjang.php)
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    
    // Tambah ke Keranjang (proses/add.php)
    Route::post('/keranjang/add', [KeranjangController::class, 'store'])->name('keranjang.add');
    
    // Hapus item Keranjang
    Route::delete('/keranjang/hapus/{id_keranjang}', [KeranjangController::class, 'destroy'])->name('keranjang.delete');

    // (Opsional) Checkout nanti bisa ditambahkan disini
    // Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
});