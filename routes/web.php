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
use App\Http\Controllers\AdminProdukController;
use App\Http\Controllers\AdminProduksiController;
use App\Http\Controllers\AdminInventoryController;
use App\Http\Controllers\AdminLaporanController;
use App\Http\Controllers\AdminCustomerController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\AdminBomController;
use App\Http\Controllers\ProfileController;

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

// Midtrans Payment Callback
Route::post('/payment/callback', [CheckoutController::class, 'callback'])->name('midtrans.callback');

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
    Route::put('/keranjang/update/{id_keranjang}', [KeranjangController::class, 'update'])->name('keranjang.update');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.process');
    
    // Halaman Sukses
    Route::get('/selesai/{invoice}', [CheckoutController::class, 'success'])->name('checkout.success');

    // Riwayat Pesanan
    Route::get('/riwayat', [HistoryController::class, 'index'])->name('history.index');

    // Profil Customer
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    // Pembayaran Ulang
    Route::get('/payment/repay/{invoice}', [CheckoutController::class, 'repay'])->name('payment.repay');

    // Batalkan Pesanan
    Route::get('/pesanan/batal/{invoice}', [HistoryController::class, 'batal'])->name('pesanan.batal');
});
// Halaman Utama
Route::get('/', [HomeController::class, 'index'])->name('home');

// Halaman About (BARU)
Route::get('/about', [HomeController::class, 'about'])->name('about');

// Halaman Utama
Route::get('/', [HomeController::class, 'index'])->name('home');

// Halaman Produk (BARU)
Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');

// Halaman About
Route::get('/about', [HomeController::class, 'about'])->name('about');

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
        Route::get('/produk', [AdminProdukController::class, 'index'])->name('admin.produk');
        Route::get('/produk/tambah', [AdminProdukController::class, 'create'])->name('admin.produk.create');
        Route::post('/produk/simpan', [AdminProdukController::class, 'store'])->name('admin.produk.store');
        Route::get('/produk/edit/{kode_produk}', [AdminProdukController::class, 'edit'])->name('admin.produk.edit');
        Route::put('/produk/update/{kode_produk}', [AdminProdukController::class, 'update'])->name('admin.produk.update');
        Route::delete('/produk/hapus/{kode_produk}', [AdminProdukController::class, 'destroy'])->name('admin.produk.delete');
        Route::get('/pesanan', [AdminProduksiController::class, 'index'])->name('admin.produksi');
        Route::get('/pesanan/terima/{invoice}', [AdminProduksiController::class, 'terima'])->name('admin.produksi.terima');
        Route::get('/pesanan/tolak/{invoice}', [AdminProduksiController::class, 'tolak'])->name('admin.produksi.tolak');
        Route::get('/inventory', [AdminInventoryController::class, 'index'])->name('admin.inventory');
        Route::get('/inventory/edit/{kode_bk}', [AdminInventoryController::class, 'edit'])->name('admin.inventory.edit');
        Route::put('/inventory/update/{kode_bk}', [AdminInventoryController::class, 'update'])->name('admin.inventory.update');
        Route::get('/laporan/penjualan', [AdminLaporanController::class, 'penjualan'])->name('admin.laporan.penjualan');
        Route::get('/customer', [AdminCustomerController::class, 'index'])->name('admin.customer');
        Route::delete('/customer/hapus/{kode_customer}', [AdminCustomerController::class, 'destroy'])->name('admin.customer.delete');
        Route::get('/produk/resep/{kode_produk}', [AdminBomController::class, 'index'])->name('admin.bom.index');
        Route::post('/produk/resep/add', [AdminBomController::class, 'store'])->name('admin.bom.store');
        Route::delete('/produk/resep/delete/{kode_bom}', [AdminBomController::class, 'destroy'])->name('admin.bom.delete');
    });
});
