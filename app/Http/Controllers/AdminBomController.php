<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BomProduk;
use App\Models\Produk;
use App\Models\Inventory;

class AdminBomController extends Controller
{
    // 1. Tampilkan Halaman Resep untuk Produk Tertentu
    public function index($kode_produk)
    {
        $produk = Produk::where('kode_produk', $kode_produk)->firstOrFail();
        
        $boms = BomProduk::where('kode_produk', $kode_produk)->get();
        
        $bahanBaku = Inventory::all();

        return view('admin.bom.index', compact('produk', 'boms', 'bahanBaku'));
    }

    // 2. Tambah Bahan ke Resep
    public function store(Request $request)
    {
        $request->validate([
            'kode_produk' => 'required',
            'kode_bk' => 'required',
            'kebutuhan' => 'required',
        ]);

        
        $produk = Produk::where('kode_produk', $request->kode_produk)->first();
        $kode_bom = 'B' . sprintf("%04s", rand(1, 9999));

        BomProduk::create([
            'kode_bom' => $kode_bom,
            'kode_bk' => $request->kode_bk,
            'kode_produk' => $request->kode_produk,
            'nama_produk' => $produk->nama,
            'kebutuhan' => $request->kebutuhan
        ]);

        return redirect()->back()->with('success', 'Bahan baku berhasil ditambahkan ke resep!');
    }

    // 3. Hapus Bahan dari Resep
    public function destroy($kode_bom)
    {
        BomProduk::where('kode_bom', $kode_bom)->delete();

        return redirect()->back()->with('success', 'Bahan dihapus dari resep.');
    }
}