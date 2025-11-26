<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produksi;
use App\Models\BomProduk;
use App\Models\Inventory;
use Illuminate\Support\Facades\DB;

class AdminProduksiController extends Controller
{
    // 1. Tampilkan Daftar Pesanan Masuk
    public function index()
    {
        $orders = Produksi::where('terima', '0')
                          ->where('tolak', '0')
                          ->orderBy('invoice', 'desc')
                          ->get();

        return view('admin.produksi.index', compact('orders'));
    }

    // 2. Proses Terima Pesanan
    public function terima($invoice)
    {
        DB::transaction(function () use ($invoice) {
            
            $pesanan = Produksi::where('invoice', $invoice)->get();

            foreach ($pesanan as $row) {
                $row->terima = '1';
                $row->status = 'Pesanan Diterima';
                $row->save();

                $boms = BomProduk::where('kode_produk', $row->kode_produk)->get();

                foreach ($boms as $bom) {
                    $total_butuh = $bom->kebutuhan * $row->qty;

                    $bahan = Inventory::where('kode_bk', $bom->kode_bk)->first();
                    
                    if ($bahan) {
                        $bahan->qty -= $total_butuh;
                        $bahan->save();
                    }
                }
            }
        });

        return redirect()->route('admin.produksi')->with('success', 'Pesanan ' . $invoice . ' Berhasil Diterima & Stok Bahan Berkurang');
    }

    // 3. Proses Tolak Pesanan
    public function tolak($invoice)
    {
        Produksi::where('invoice', $invoice)->update([
            'tolak' => '1',
            'status' => 'Pesanan Ditolak'
        ]);

        return redirect()->route('admin.produksi')->with('success', 'Pesanan ' . $invoice . ' Berhasil Ditolak');
    }
}