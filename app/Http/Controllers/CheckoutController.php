<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keranjang;
use App\Models\Produksi;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class CheckoutController extends Controller
{
    public function index()
    {
        $kode_cs = Session::get('kode_customer');
        $keranjangs = Keranjang::where('kode_customer', $kode_cs)->get();

        if($keranjangs->isEmpty()){
            return redirect()->route('home');
        }

        $total = 0;
        foreach($keranjangs as $k){
            $total += $k->harga * $k->qty;
        }

        return view('checkout', compact('keranjangs', 'total'));
    }

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

        // 1. Generate Invoice
        $lastOrder = Produksi::orderBy('id_order', 'desc')->first();
        $lastInvoice = $lastOrder ? $lastOrder->invoice : '';
        $noUrut = (int)substr($lastInvoice, 3); 
        $invoiceBaru = 'INV' . sprintf("%04s", $noUrut + 1);

        // Hitung Total Bayar untuk Midtrans
        $totalBayar = 0;

        // 2. Simpan ke Database
        foreach ($keranjangs as $cart) {
            $subtotal = $cart->harga * $cart->qty;
            $totalBayar += $subtotal;

            Produksi::create([
                'invoice' => $invoiceBaru,
                'kode_customer' => $kode_cs,
                'kode_produk' => $cart->kode_produk,
                'nama_produk' => $cart->nama_produk,
                'qty' => $cart->qty,
                'harga' => $cart->harga,
                'status' => 'Menunggu Pembayaran', // Status awal diubah
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

        // 3. Hapus Keranjang
        Keranjang::where('kode_customer', $kode_cs)->delete();

        // 4. Konfigurasi Midtrans
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = config('services.midtrans.is_sanitized');
        Config::$is3ds = config('services.midtrans.is_3ds');

        // Buat Parameter Transaksi Midtrans
        // Menggunakan time() agar Order ID unik jika user mencoba bayar ulang nanti
        $midtransParams = [
            'transaction_details' => [
                'order_id' => $invoiceBaru . '-' . time(), 
                'gross_amount' => (int) $totalBayar,
            ],
            'customer_details' => [
                'first_name' => Session::get('nama_customer') ?? 'Customer',
                'email' => Session::get('email_customer') ?? 'email@example.com',
                'shipping_address' => [
                    'first_name' => Session::get('nama_customer'),
                    'address' => $request->alamat,
                    'city' => $request->kota,
                    'postal_code' => $request->kode_pos,
                ]
            ]
        ];

        try {
            // Ambil Snap Token
            $snapToken = Snap::getSnapToken($midtransParams);
            
            // Tampilkan halaman pembayaran (bukan langsung selesai)
            return view('payment', compact('snapToken', 'invoiceBaru', 'totalBayar'));

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat memproses pembayaran: ' . $e->getMessage());
        }
    }

    public function success($invoice)
    {
        return view('selesai', compact('invoice'));
    }
    public function repay($invoice)
    {
        $kode_cs = Session::get('kode_customer');
        $pesanan = Produksi::where('invoice', $invoice)
                            ->where('kode_customer', $kode_cs)
                            ->get();

        if($pesanan->isEmpty()){
            return redirect()->back()->with('error', 'Pesanan tidak ditemukan');
        }

        if($pesanan->first()->status != 'Menunggu Pembayaran'){
            return redirect()->back()->with('error', 'Pesanan ini tidak perlu dibayar lagi.');
        }

        $totalBayar = 0;
        foreach($pesanan as $p){
            $totalBayar += $p->harga * $p->qty;
        }

        // 4. Konfigurasi Midtrans
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = config('services.midtrans.is_sanitized');
        Config::$is3ds = config('services.midtrans.is_3ds');

        // 5. Buat Parameter Transaksi Baru
        // Kita tambahkan time() agar Order ID unik dan dianggap transaksi baru oleh Midtrans
        $midtransParams = [
            'transaction_details' => [
                'order_id' => $invoice . '-' . time(), 
                'gross_amount' => (int) $totalBayar,
            ],
            'customer_details' => [
                'first_name' => Session::get('nama_customer') ?? 'Customer',
                // Data lain opsional
            ]
        ];

        try {
            $snapToken = Snap::getSnapToken($midtransParams);
            $invoiceBaru = $invoice;

            // Return ke view payment yang sudah kita buat sebelumnya
            return view('payment', compact('snapToken', 'invoiceBaru', 'totalBayar'));

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }
    }
    
}