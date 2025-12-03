@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2 style="border-bottom: 4px solid #ff8680; padding-bottom: 10px;">
            <b>Laporan Penjualan</b>
        </h2>
    </div>

    {{-- Form Filter Tanggal --}}
    <div class="col-md-12" style="margin-bottom: 20px; padding: 15px; background: #f9f9f9; border: 1px solid #ddd;">
        <form action="{{ route('admin.laporan.penjualan') }}" method="GET" class="form-inline">
            <div class="form-group">
                <label>Dari Tanggal:</label>
                <input type="date" name="tgl_mulai" class="form-control" value="{{ $tgl_mulai }}">
            </div>
            <div class="form-group">
                <label>Sampai Tanggal:</label>
                <input type="date" name="tgl_selesai" class="form-control" value="{{ $tgl_selesai }}">
            </div>
            <button type="submit" class="btn btn-primary">Cari Laporan</button>
            <a href="{{ route('admin.laporan.penjualan') }}" class="btn btn-default">Reset</a>
        </form>
    </div>

    {{-- Tabel Laporan --}}
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">Invoice</th>
                        <th width="15%">Tanggal</th>
                        <th width="20%">Customer</th>
                        <th>Detail Pesanan (Produk x Qty)</th>
                        <th width="15%">Total Pendapatan</th>
                    </tr>
                </thead>
                <tbody>
                    @php 
                        $no = 1; 
                        $grand_total = 0; // Total Keseluruhan
                    @endphp

                    @forelse($laporan as $invoice => $groupItem)
                        @php
                            // Ambil data pertama untuk info umum (Tanggal, Customer)
                            $firstItem = $groupItem->first();
                            
                            // Hitung total per invoice
                            $total_invoice = $groupItem->sum(function ($item) {
                                return $item->harga * $item->qty;
                            });

                            // Tambahkan ke Grand Total
                            $grand_total += $total_invoice;
                        @endphp
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td><b>{{ $invoice }}</b></td>
                        <td>{{ $firstItem->tanggal }}</td>
                        <td>{{ $firstItem->customer->nama ?? 'Customer Terhapus' }}</td>
                        
                        {{-- Daftar Produk --}}
                        <td>
                            <ul style="padding-left: 20px; margin: 0;">
                                @foreach($groupItem as $item)
                                    <li>
                                        {{ $item->nama_produk }} 
                                        <small class="text-muted">
                                            (x{{ $item->qty }} @ Rp.{{ number_format($item->harga) }})
                                        </small>
                                    </li>
                                @endforeach
                            </ul>
                        </td>

                        {{-- Total Per Invoice --}}
                        <td align="right">Rp. {{ number_format($total_invoice) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data penjualan pada periode ini.</td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr style="background-color: #f5f5f5;">
                        <td colspan="5" align="right" style="font-size: 16px;"><b>TOTAL KESELURUHAN</b></td>
                        <td align="right" style="font-size: 16px;"><b>Rp. {{ number_format($grand_total) }}</b></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        
        <button onclick="window.print()" class="btn btn-success"><i class="glyphicon glyphicon-print"></i> Cetak Laporan</button>
    </div>
</div>
@endsection