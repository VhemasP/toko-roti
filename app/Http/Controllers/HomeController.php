<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk; // <-- Penting: Agar bisa memanggil database

class HomeController extends Controller
{
    public function index()
    {
        $products = Produk::all(); 
        

        return view('home', compact('products'));
    }
    
    public function about()
    {
        return view('about');
    }
}