<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keranjang;
use App\Models\Produksi;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log; // Untuk logging
// Tambahkan Import Midtrans
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

    // 1. PROSES CHECKOUT BARU
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

        // Generate Invoice
        $lastOrder = Produksi::orderBy('id_order', 'desc')->first();
        $lastInvoice = $lastOrder ? $lastOrder->invoice : '';
        $noUrut = (int)substr($lastInvoice, 3); 
        $invoiceBaru = 'INV' . sprintf("%04s", $noUrut + 1);

        $totalBayar = 0;

        // Simpan ke Database
        foreach ($keranjangs as $cart) {
            $totalBayar += $cart->harga * $cart->qty;

            Produksi::create([
                'invoice' => $invoiceBaru,
                'kode_customer' => $kode_cs,
                'kode_produk' => $cart->kode_produk,
                'nama_produk' => $cart->nama_produk,
                'qty' => $cart->qty,
                'harga' => $cart->harga,
                'status' => 'Menunggu Pembayaran', // [PENTING] Status Awal
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

        // Hapus Keranjang
        Keranjang::where('kode_customer', $kode_cs)->delete();

        // Konfigurasi Midtrans & Ambil Snap Token
        $this->configureMidtrans();
        
        $params = [
            'transaction_details' => [
                'order_id' => $invoiceBaru . '-' . time(), // Order ID Unik
                'gross_amount' => (int) $totalBayar,
            ],
            'customer_details' => [
                'first_name' => Session::get('nama_customer'),
            ]
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return view('payment', compact('snapToken', 'invoiceBaru', 'totalBayar'));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }
    }

    // 2. PROSES BAYAR ULANG (REPAY)
    public function repay($invoice)
    {
        $kode_cs = Session::get('kode_customer');
        $pesanan = Produksi::where('invoice', $invoice)
                            ->where('kode_customer', $kode_cs)
                            ->get();

        if($pesanan->isEmpty()) return back()->with('error', 'Pesanan tidak ditemukan');
        if($pesanan->first()->status != 'Menunggu Pembayaran') return back()->with('error', 'Pesanan ini tidak perlu dibayar.');

        $totalBayar = 0;
        foreach($pesanan as $p){
            $totalBayar += $p->harga * $p->qty;
        }

        $this->configureMidtrans();

        $params = [
            'transaction_details' => [
                'order_id' => $invoice . '-' . time(), // Order ID Unik Baru
                'gross_amount' => (int) $totalBayar,
            ],
            'customer_details' => [
                'first_name' => Session::get('nama_customer'),
            ]
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            $invoiceBaru = $invoice;
            return view('payment', compact('snapToken', 'invoiceBaru', 'totalBayar'));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }
    }

    // 3. HALAMAN SUKSES (Update Status via Redirect)
    public function success($invoice)
    {
        // Fitur ini mengupdate status jika user diarahkan kembali ke web setelah bayar
        $kode_cs = Session::get('kode_customer');

        Produksi::where('invoice', $invoice)
                ->where('kode_customer', $kode_cs)
                ->where('status', 'Menunggu Pembayaran')
                ->update([
                    'status' => 'Menunggu Konfirmasi'
                ]);

        return view('selesai', compact('invoice'));
    }

    // 4. WEBHOOK / CALLBACK MIDTRANS (Update Status Otomatis)
    public function callback(Request $request)
    {
        $this->configureMidtrans();

        try {
            $notif = new Notification();
            
            $transaction = $notif->transaction_status;
            $order_id = $notif->order_id;
            
            // Ambil Invoice Asli (INV001-12345 -> INV001)
            $invoiceParts = explode('-', $order_id);
            $invoiceAsli = $invoiceParts[0];

            $statusBaru = null;

            if ($transaction == 'capture' || $transaction == 'settlement') {
                $statusBaru = 'Menunggu Konfirmasi';
            } else if ($transaction == 'pending') {
                $statusBaru = 'Menunggu Pembayaran';
            } else if (in_array($transaction, ['deny', 'expire', 'cancel'])) {
                $statusBaru = 'Batal';
            }

            if ($statusBaru) {
                Produksi::where('invoice', $invoiceAsli)->update(['status' => $statusBaru]);
            }

            return response()->json(['message' => 'OK']);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Error'], 500);
        }
    }

    // Helper Konfigurasi
    private function configureMidtrans()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = config('services.midtrans.is_sanitized');
        Config::$is3ds = config('services.midtrans.is_3ds');
    }
}