@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2 style="border-bottom: 4px solid #ff8680; padding-bottom: 10px;">
            <b>Daftar Pesanan Masuk</b>
        </h2>
        
        @if(session('success'))
            <div class="alert alert-success">
                <i class="glyphicon glyphicon-ok"></i> {{ session('success') }}
            </div>
        @endif

        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Invoice</th>
                    <th>Nama Customer</th>
                    <th>Produk</th>
                    <th>Qty</th>
                    <th>Harga</th>
                    <th>Total</th>
                    <th>Tanggal</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $no=1; @endphp
                @forelse($orders as $row)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td><b>{{ $row->invoice }}</b></td>
                    <td>
                        {{ $row->customer->nama ?? $row->kode_customer }}
                    </td>
                    <td>{{ $row->nama_produk }}</td>
                    <td>{{ $row->qty }}</td>
                    <td>Rp.{{ number_format($row->harga) }}</td>
                    <td>Rp.{{ number_format($row->harga * $row->qty) }}</td>
                    <td>{{ $row->tanggal }}</td>
                    <td>
                        <small>
                        {{ $row->alamat }}, {{ $row->kota }}, {{ $row->provinsi }}
                        </small>
                    </td>
                    <td width="150">
                        <a href="{{ route('admin.produksi.terima', $row->invoice) }}" class="btn btn-success btn-sm" onclick="return confirm('Yakin ingin menerima pesanan ini? Stok bahan baku akan berkurang.')">
                            <i class="glyphicon glyphicon-ok"></i> Terima
                        </a>
                        
                        <a href="{{ route('admin.produksi.tolak', $row->invoice) }}" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menolak pesanan ini?')">
                            <i class="glyphicon glyphicon-remove"></i> Tolak
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center">Belum ada pesanan baru.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection