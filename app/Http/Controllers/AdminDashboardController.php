<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produksi;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Logika dashboard (misal: hitung pesanan baru)
        $pesanan_baru = Produksi::where('terima', 0)->where('tolak', 0)->count();
        
        return view('admin.dashboard', compact('pesanan_baru'));
    }
}