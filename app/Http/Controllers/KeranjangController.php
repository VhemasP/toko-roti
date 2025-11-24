<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keranjang;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth; // Untuk cek login user

class KeranjangController extends Controller
{
    // Menampilkan isi keranjang (keranjang.php)
    public function index()
    {
        // Ambil data keranjang milik user yang sedang login
        // Asumsi kita nanti pakai Auth Laravel, ambil ID user lewat Auth::id()
        // Karena kode_customer anda string (C0001), pastikan Auth sudah disetup benar nanti.
        
        // Contoh sementara (Hardcode user dulu jika belum login, atau pakai session)
        // $kode_cs = Auth::user()->kode_customer; 
        $kode_cs = 'C0003'; // Contoh testing sesuai data di SQL Anda
        
        $keranjangs = Keranjang::where('kode_customer', $kode_cs)->get();
        
        // Hitung total bayar
        $total = 0;
        foreach($keranjangs as $k){
            $total += $k->harga * $k->qty;
        }

        return view('keranjang.index', compact('keranjangs', 'total'));
    }

    // Menambah barang ke keranjang (proses/add.php)
    public function store(Request $request)
    {
        $kode_produk = $request->kode_produk;
        $qty = $request->qty ?? 1; // Default 1 jika tidak ada input qty
        $kode_cs = 'C0003'; // Nanti ganti Auth::user()->kode_customer;

        // Ambil info produk untuk dapat harganya
        $produk = Produk::where('kode_produk', $kode_produk)->first();

        // Cek apakah barang ini sudah ada di keranjang user tsb?
        $cekKeranjang = Keranjang::where('kode_customer', $kode_cs)
                            ->where('kode_produk', $kode_produk)
                            ->first();

        if($cekKeranjang) {
            // Jika sudah ada, update qty-nya
            $cekKeranjang->qty += $qty;
            $cekKeranjang->save();
        } else {
            // Jika belum ada, buat baru
            Keranjang::create([
                'kode_customer' => $kode_cs,
                'kode_produk'   => $kode_produk,
                'nama_produk'   => $produk->nama,
                'qty'           => $qty,
                'harga'         => $produk->harga
            ]);
        }

        return redirect()->route('keranjang.index')->with('success', 'Produk berhasil ditambahkan ke keranjang');
    }

    // Menghapus item keranjang
    public function destroy($id_keranjang)
    {
        Keranjang::destroy($id_keranjang);
        return redirect()->back();
    }
}