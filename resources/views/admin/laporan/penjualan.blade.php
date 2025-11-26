@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2 style="border-bottom: 4px solid #ff8680; padding-bottom: 10px;">
            <b>Laporan Penjualan</b>
        </h2>
    </div>

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

    <div class="col-md-12">
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Invoice</th>
                    <th>Tanggal</th>
                    <th>Customer</th>
                    <th>Produk</th>
                    <th>Qty</th>
                    <th>Harga Satuan</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php 
                    $no=1; 
                    $total_pendapatan = 0; 
                @endphp
                @forelse($laporan as $row)
                    @php 
                        $subtotal = $row->qty * $row->harga;
                        $total_pendapatan += $subtotal;
                    @endphp
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $row->invoice }}</td>
                    <td>{{ $row->tanggal }}</td>
                    <td>{{ $row->customer->nama ?? 'Customer Hapus' }}</td>
                    <td>{{ $row->nama_produk }}</td>
                    <td>{{ $row->qty }}</td>
                    <td>Rp.{{ number_format($row->harga) }}</td>
                    <td>Rp.{{ number_format($subtotal) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data penjualan pada periode ini.</td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="7" align="right"><b>TOTAL PENDAPATAN</b></td>
                    <td><b>Rp.{{ number_format($total_pendapatan) }}</b></td>
                </tr>
            </tfoot>
        </table>
        
        <button onclick="window.print()" class="btn btn-default"><i class="glyphicon glyphicon-print"></i> Cetak Laporan</button>
    </div>
</div>
@endsection