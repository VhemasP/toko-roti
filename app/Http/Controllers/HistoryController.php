<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produksi;
use Illuminate\Support\Facades\Session;

class HistoryController extends Controller
{
    // Halaman Riwayat Pesanan
    public function index()
    {
        $kode_cs = Session::get('kode_customer');

        $orders = Produksi::where('kode_customer', $kode_cs)
                          ->orderBy('invoice', 'desc')
                          ->get()
                          ->groupBy('invoice');

        return view('history.index', compact('orders'));
    }

    // Fitur Batalkan Pesanan (Aksi History)
    public function batal($invoice)
    {
        $kode_cs = Session::get('kode_customer');
        
        $pesanan = Produksi::where('invoice', $invoice)
                           ->where('kode_customer', $kode_cs)
                           ->get();

        if($pesanan->isEmpty()){
            return redirect()->back()->with('error', 'Pesanan tidak ditemukan');
        }

        if($pesanan->first()->status != 'Menunggu Pembayaran'){
            return redirect()->back()->with('error', 'Pesanan ini tidak bisa dibatalkan.');
        }

        Produksi::where('invoice', $invoice)
                ->where('kode_customer', $kode_cs)
                ->update([
                    'status' => 'Batal',
                ]);

        return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan');
    }
}