<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;

class ProdukController extends Controller
{
    public function show($kode_produk)
    {
        $produk = Produk::where('kode_produk', $kode_produk)->firstOrFail();

        return view('produk.detail', compact('produk'));
    }
    
    public function index()
    {
        $products = Produk::all();
        return view('produk.index', compact('products'));
    }
}