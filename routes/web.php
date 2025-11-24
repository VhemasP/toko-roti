<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

// Import Semua Controller
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==========================================================
// 1. BAGIAN PUBLIK & CUSTOMER
// ==========================================================

// Halaman Utama
Route::get('/', [HomeController::class, 'index'])->name('home');

// Detail Produk
Route::get('/detail/{kode_produk}', [ProdukController::class, 'show'])->name('produk.detail');

// --- Autentikasi Customer (Guest) ---
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [CustomerAuthController::class, 'showLoginForm'])->name('login.form');
    Route::post('/login', [CustomerAuthController::class, 'login'])->name('login');

    // Register
    Route::get('/register', [CustomerAuthController::class, 'showRegisterForm'])->name('register.form');
    Route::post('/register', [CustomerAuthController::class, 'register'])->name('register');
});

// Logout Customer
Route::post('/logout', [CustomerAuthController::class, 'logout'])->name('logout');


// --- Fitur Belanja (Butuh Login) ---
// Kita gunakan grup middleware 'web' standar
Route::group(['middleware' => 'web'], function () {
    
    // Keranjang Belanja
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang/add', [KeranjangController::class, 'store'])->name('keranjang.add');
    Route::delete('/keranjang/hapus/{id_keranjang}', [KeranjangController::class, 'destroy'])->name('keranjang.delete');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.process');
    
    // Halaman Sukses
    Route::get('/selesai/{invoice}', [CheckoutController::class, 'success'])->name('checkout.success');
});

// ==========================================================
// 2. BAGIAN ADMIN
// ==========================================================
Route::prefix('admin')->group(function () {
    
    // Login & Logout (Tanpa Middleware)
    Route::get('/', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
    Route::get('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    // Halaman Dashboard (Pakai Middleware 'admin.auth')
    Route::middleware('admin.auth')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    });
});
