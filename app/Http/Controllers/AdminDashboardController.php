<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produksi;
use App\Models\Produk;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        
        $pesanan_baru = Produksi::where('terima', '0')
                                ->where('tolak', '0')
                                ->where('status', '!=', 'Batal')
                                ->where('status', '!=', 'Menunggu Pembayaran')
                                ->distinct('invoice')
                                ->count('invoice');

        $totalProduk = Produk::count();
        $totalCustomer = Customer::count();
        
        $pendapatan = Produksi::where('terima', '1')->sum(DB::raw('harga * qty'));

        return view('admin.dashboard', compact('pesanan_baru', 'totalProduk', 'totalCustomer', 'pendapatan'));
    }
}