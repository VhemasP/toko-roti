<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk; // <-- Penting: Agar bisa memanggil database

class HomeController extends Controller
{
    /**
     * Menampilkan Halaman Utama
     */
    public function index()
    {
        // Ambil semua data produk
        $products = Produk::all(); 
        

        return view('home', compact('products'));
    }
}