<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\PublicController; // <-- Tambahkan ini
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// --- HALAMAN PUBLIK (Bisa diakses siapa saja) ---
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/about', [PublicController::class, 'about'])->name('about');


// --- ROUTE AUTENTIKASI ---
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.show'); // Ubah ke /login
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register.show');
Route::post('register', [AuthController::class, 'register'])->name('register.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');


// --- HALAMAN CUSTOMER (Perlu Login Customer) ---
Route::middleware(['auth:customer'])->group(function () {
    Route::get('/dashboard-customer', function () {
        $nama = Auth::guard('customer')->user()->nama;
        return "<h1>Halo Customer, " . $nama . "</h1> <form action='/logout' method='post'>@csrf<button type='submit'>Logout</button></form>";
    })->name('customer.dashboard');
});


// --- HALAMAN ADMIN (Perlu Login Admin) ---
Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Rute Dashboard (Redirect ke produk)
    Route::get('/dashboard', function () {
        return redirect()->route('admin.products.index');
    })->name('dashboard');

    // Rute CRUD Produk
    Route::resource('products', ProductController::class);

    // Rute Manajemen Orderan
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');

    // Placeholder untuk Statistik & Customer (Agar tidak error jika diklik)
    Route::get('statistics', function() { return "Halaman Statistik (Segera Hadir)"; })->name('statistics.index');
    Route::get('customers', function() { return "Halaman Customer Service (Segera Hadir)"; })->name('customers.index');
});