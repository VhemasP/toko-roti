<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produksi;

class AdminLaporanController extends Controller
{
    // Laporan Penjualan
    public function penjualan(Request $request)
    {
        // 1. Ambil data yang sudah diterima ('1')
        $query = Produksi::where('terima', '1')->orderBy('tanggal', 'desc');

        // 2. Filter Tanggal
        $tgl_mulai = $request->tgl_mulai;
        $tgl_selesai = $request->tgl_selesai;

        if ($tgl_mulai && $tgl_selesai) {
            $query->whereBetween('tanggal', [$tgl_mulai, $tgl_selesai]);
        }

        // 3. Ambil data DAN Kelompokkan berdasarkan Invoice
        $laporan = $query->get()->groupBy('invoice');

        return view('admin.laporan.penjualan', compact('laporan', 'tgl_mulai', 'tgl_selesai'));
    }
}