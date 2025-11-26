<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;

class AdminInventoryController extends Controller
{
    // 1. Tampilkan Daftar Bahan Baku
    public function index()
    {
        $inventory = Inventory::orderBy('kode_bk', 'asc')->get();
        return view('admin.inventory.index', compact('inventory'));
    }

    // 2. Tampilkan Form Edit
    public function edit($kode_bk)
    {
        $data = Inventory::where('kode_bk', $kode_bk)->firstOrFail();
        return view('admin.inventory.edit', compact('data'));
    }

    // 3. Proses Update Stok
    public function update(Request $request, $kode_bk)
    {
        $request->validate([
            'nama' => 'required',
            'qty' => 'required|integer',
            'satuan' => 'required',
            'harga' => 'required|integer',
        ]);

        $inventory = Inventory::where('kode_bk', $kode_bk)->firstOrFail();

        $inventory->update([
            'nama' => $request->nama,
            'qty' => $request->qty,
            'satuan' => $request->satuan,
            'harga' => $request->harga,
            'tanggal' => date('Y-m-d'),
        ]);

        return redirect()->route('admin.inventory')->with('success', 'Data bahan baku berhasil diperbarui!');
    }
}