<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicController extends Controller
{
    /**
     * Halaman Utama (Home)
     */
    public function index()
    {
        return view('public.home');
    }

    /**
     * Halaman Tentang Kami
     */
    public function about()
    {
        return view('public.about');
    }
}