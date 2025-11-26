@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2 style="border-bottom: 4px solid #ff8680; padding-bottom: 10px;">
            <b>Daftar Bahan Baku (Inventory)</b>
        </h2>
        
        @if(session('success'))
            <div class="alert alert-success">
                <i class="glyphicon glyphicon-ok"></i> {{ session('success') }}
            </div>
        @endif
        
        <table class="table table-striped table-bordered text-center">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Kode Bahan</th>
                    <th class="text-center">Nama Bahan</th>
                    <th class="text-center">Stok (Qty)</th>
                    <th class="text-center">Satuan</th>
                    <th class="text-center">Harga / Satuan</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $no=1; @endphp
                @forelse($inventory as $row)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $row->kode_bk }}</td>
                    <td>{{ $row->nama }}</td>
                    <td>
                        @if($row->qty <= 0)
                            <span style="color:red; font-weight:bold;">{{ $row->qty }}</span>
                        @else
                            {{ $row->qty }}
                        @endif
                    </td>
                    <td>{{ $row->satuan }}</td>
                    <td>Rp.{{ number_format($row->harga) }}</td>
                    <td>
                        <a href="{{ route('admin.inventory.edit', $row->kode_bk) }}" class="btn btn-warning btn-sm">
                            <i class="glyphicon glyphicon-edit"></i> Update Stok
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">Tidak ada data bahan baku.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <div class="alert alert-info">
            <small>* Stok akan berkurang otomatis saat Anda menerima pesanan.</small>
        </div>
    </div>
</div>
@endsection