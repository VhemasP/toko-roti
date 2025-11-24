<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;

class ProdukController extends Controller
{
    // Menampilkan detail produk berdasarkan kode_produk
    public function show($kode_produk)
    {
        // Cari produk berdasarkan primary key (kode_produk)
        // Jika tidak ketemu, akan otomatis error 404
        $produk = Produk::where('kode_produk', $kode_produk)->firstOrFail();

        return view('produk.detail', compact('produk'));
    }
    
    // Jika Anda punya halaman 'Daftar Semua Produk' (produk.php)
    public function index()
    {
        $products = Produk::all();
        return view('produk.index', compact('products'));
    }
}