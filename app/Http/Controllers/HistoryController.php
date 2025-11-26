<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produksi;
use Illuminate\Support\Facades\Session;

class HistoryController extends Controller
{
    public function index()
    {
        // 1. Ambil ID Customer yang sedang login
        $kode_cs = Session::get('kode_customer');

        // 2. Ambil data pesanan milik customer tersebut
        $orders = Produksi::where('kode_customer', $kode_cs)
                          ->orderBy('invoice', 'desc')
                          ->get();

        return view('history.index', compact('orders'));
    }
}