<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keranjang;
use App\Models\Produk;
use Illuminate\Support\Facades\Session;

class KeranjangController extends Controller
{
    public function index()
    {
        $kode_cs = Session::get('kode_customer');
        
        $keranjangs = Keranjang::where('kode_customer', $kode_cs)->get();
        
        return view('keranjang.index', compact('keranjangs'));
    }

    public function store(Request $request)
    {
        if (!Session::has('kode_customer')) {
            return redirect()->route('login.form')->withErrors(['msg' => 'Silakan login terlebih dahulu']);
        }

        $kode_cs = Session::get('kode_customer');
        $kode_produk = $request->kode_produk;
        $qty = $request->qty ?? 1;

        $produk = Produk::where('kode_produk', $kode_produk)->first();

        $cekKeranjang = Keranjang::where('kode_customer', $kode_cs)
                            ->where('kode_produk', $kode_produk)
                            ->first();

        if($cekKeranjang) {
            $cekKeranjang->qty += $qty;
            $cekKeranjang->save();
        } else {
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

    public function destroy($id_keranjang)
    {
        Keranjang::destroy($id_keranjang);
        return redirect()->back();
    }

    // Update Jumlah (Qty) Keranjang
    public function update(Request $request, $id_keranjang)
    {
        $request->validate([
            'qty' => 'required|integer|min:1'
        ]);
        
        $keranjang = Keranjang::where('id_keranjang', $id_keranjang)->firstOrFail();
        
        $keranjang->qty = $request->qty;
        $keranjang->save();

        return redirect()->back()->with('success', 'Jumlah berhasil diperbarui');
    }
}