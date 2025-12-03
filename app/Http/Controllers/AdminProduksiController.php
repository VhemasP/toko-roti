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
        // Ambil data yang belum diterima & belum ditolak
        // Menggunakan groupBy('invoice') agar tampilan admin rapi per Nota
        $produksis = Produksi::where('terima', '0')
                          ->where('tolak', '0')
                          ->where('status', '!=', 'Batal') // Opsi: Jangan tampilkan yang sudah Batal
                          ->orderBy('invoice', 'desc')
                          ->get()
                          ->groupBy('invoice'); 

        // Pastikan view Anda menggunakan variabel $produksis
        return view('admin.produksi.index', compact('produksis'));
    }

    // 2. Proses Terima Pesanan
    public function terima($invoice)
    {
        // Gunakan DB Transaction agar jika ada error di tengah jalan, data tidak rusak
        DB::transaction(function () use ($invoice) {
            
            // Ambil semua item dalam satu invoice
            $pesanan = Produksi::where('invoice', $invoice)->get();

            foreach ($pesanan as $row) {
                // 1. Update Status Pesanan jadi Diterima
                $row->terima = '1';
                $row->status = 'Pesanan Diterima';
                $row->save();

                // 2. Kurangi Stok Bahan Baku (Inventory) berdasarkan Resep (BOM)
                $boms = BomProduk::where('kode_produk', $row->kode_produk)->get();

                foreach ($boms as $bom) {
                    // Rumus: Kebutuhan per produk * Qty pesanan
                    $total_butuh = $bom->kebutuhan * $row->qty;

                    // Cari bahan baku di inventory
                    $bahan = Inventory::where('kode_bk', $bom->kode_bk)->first();
                    
                    if ($bahan) {
                        // Kurangi stok
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
        // Update semua item dalam invoice tersebut menjadi Ditolak
        Produksi::where('invoice', $invoice)->update([
            'tolak' => '1',
            'status' => 'Pesanan Ditolak'
        ]);

        return redirect()->route('admin.produksi')->with('success', 'Pesanan ' . $invoice . ' Berhasil Ditolak');
    }
}