<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produksi;

class AdminLaporanController extends Controller
{
    // Laporan Penjualan
    public function penjualan(Request $request)
    {
        $query = Produksi::where('terima', '1')->orderBy('tanggal', 'desc');

        $tgl_mulai = $request->tgl_mulai;
        $tgl_selesai = $request->tgl_selesai;

        if ($tgl_mulai && $tgl_selesai) {
            $query->whereBetween('tanggal', [$tgl_mulai, $tgl_selesai]);
        }

        $laporan = $query->get();

        return view('admin.laporan.penjualan', compact('laporan', 'tgl_mulai', 'tgl_selesai'));
    }
}