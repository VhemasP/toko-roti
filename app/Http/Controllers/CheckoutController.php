<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keranjang;
use App\Models\Produksi;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $kode_cs = Session::get('kode_customer');
        $keranjangs = Keranjang::where('kode_customer', $kode_cs)->get();

        // Jika keranjang kosong, tendang balik
        if($keranjangs->isEmpty()){
            return redirect()->route('home');
        }

        // Hitung total bayar untuk ditampilkan
        $total = 0;
        foreach($keranjangs as $k){
            $total += $k->harga * $k->qty;
        }

        return view('checkout', compact('keranjangs', 'total'));
    }

    // Proses Simpan Order
    public function store(Request $request)
    {
        $request->validate([
            'provinsi' => 'required',
            'kota' => 'required',
            'alamat' => 'required',
            'kode_pos' => 'required',
        ]);

        $kode_cs = Session::get('kode_customer');
        $keranjangs = Keranjang::where('kode_customer', $kode_cs)->get();

        // 1. Generate Kode Invoice Baru (INV000X)
        // Kita cari invoice terakhir di tabel produksi
        $lastOrder = Produksi::orderBy('id_order', 'desc')->first();
        $lastInvoice = $lastOrder ? $lastOrder->invoice : '';
        
        // Ambil angkanya saja (INV0001 -> 1)
        $noUrut = (int)substr($lastInvoice, 3); 
        $invoiceBaru = 'INV' . sprintf("%04s", $noUrut + 1);

        // 2. Pindahkan setiap item keranjang ke tabel produksi
        foreach ($keranjangs as $cart) {
            Produksi::create([
                'invoice' => $invoiceBaru,
                'kode_customer' => $kode_cs,
                'kode_produk' => $cart->kode_produk,
                'nama_produk' => $cart->nama_produk,
                'qty' => $cart->qty,
                'harga' => $cart->harga,
                'status' => 'Pesanan Baru', // Status awal
                'tanggal' => date('Y-m-d'),
                'provinsi' => $request->provinsi,
                'kota' => $request->kota,
                'alamat' => $request->alamat,
                'kode_pos' => $request->kode_pos,
                'terima' => '0',
                'tolak' => '0',
                'cek' => 0
            ]);
        }

        // 3. Hapus data di Keranjang (karena sudah dibeli)
        Keranjang::where('kode_customer', $kode_cs)->delete();

        return redirect()->route('checkout.success', ['invoice' => $invoiceBaru]);
    }

    public function success($invoice)
    {
        return view('selesai', compact('invoice'));
    }
}