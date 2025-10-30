<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\ProductController;
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

// --- ROUTE AUTENTIKASI ---
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login.show');
Route::post('/', [AuthController::class, 'login'])->name('login.post');
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register.show');
Route::post('register', [AuthController::class, 'register'])->name('register.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');


// --- Halaman Customer (Perlu Login Customer) ---
Route::middleware(['auth:customer'])->group(function () {
    Route::get('/dashboard-customer', function () {
        $nama = Auth::guard('customer')->user()->nama;
        return "<h1>Halo Customer, " . $nama . "</h1> <form action='/logout' method='post'>@csrf<button type='submit'>Logout</button></form>";
    })->name('customer.dashboard');
});

// --- Halaman Admin (Perlu Login Admin) ---
Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', function () {
        return redirect()->route('admin.products.index');
    })->name('dashboard'); 

    Route::resource('products', ProductController::class);
});