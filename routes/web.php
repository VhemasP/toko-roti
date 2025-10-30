<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController; // <-- Pastikan ini ada
use Illuminate\Support\Facades\Auth;     // <-- Pastikan ini ada

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- ROUTE AUTENTIKASI ---

// Jadikan halaman login sebagai halaman utama
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login.show'); // <-- PASTIKAN INI TIDAK DIKOMENTARI
Route::post('/', [AuthController::class, 'login'])->name('login.post');

// Route untuk Register Customer
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register.show');
Route::post('register', [AuthController::class, 'register'])->name('register.post');

// Route untuk Logout (gunakan method POST untuk keamanan)
Route::post('logout', [AuthController::class, 'logout'])->name('logout');


// --- Halaman Dashboard (Perlu Login) ---

// Group untuk Customer
Route::middleware(['auth:customer'])->group(function () {
    Route::get('/dashboard-customer', function () {
        $nama = Auth::guard('customer')->user()->nama;
        return "<h1>Halo Customer, " . $nama . "</h1> <form action='/logout' method='post'>@csrf<button type='submit'>Logout</button></form>";
    })->name('customer.dashboard');
});

// Group untuk Admin
Route::middleware(['auth:admin'])->group(function () {
    Route::get('/dashboard-admin', function () {
        $username = Auth::guard('admin')->user()->username;
        return "<h1>Halo Admin, " . $username . "</h1> <form action='/logout' method='post'>@csrf<button type='submit'>Logout</button></form>";
    })->name('admin.dashboard');
});