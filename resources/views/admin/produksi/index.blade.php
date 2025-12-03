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
            <th width="5%">No</th>
            <th>Invoice</th>
            <th>Customer</th>
            <th>Daftar Pesanan</th>
            <th>Total Bayar</th>
            <th>Status Saat Ini</th>
            <th width="15%">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @php $no = 1; @endphp
        @foreach($produksis as $invoice => $groupItem)
            @php
                // Ambil data pertama untuk info umum (Customer, Tanggal, Status)
                $firstItem = $groupItem->first();
                
                // Hitung total bayar untuk invoice ini
                $totalBayar = $groupItem->sum(function ($item) {
                    return $item->harga * $item->qty;
                });

                // Ambil nama customer (Relasi manual atau join jika perlu, 
                // tapi kalau di tabel produksi tidak ada nama, gunakan kode_customer saja dulu)
                $namaCustomer = $firstItem->kode_customer; 
            @endphp
        <tr>
            <td>{{ $no++ }}</td>
            <td>
                <b>{{ $invoice }}</b><br>
                <small class="text-muted">{{ $firstItem->tanggal }}</small>
            </td>
            <td>
                {{-- Jika Anda punya relasi ke tabel customer, bisa dipanggil disini --}}
                {{-- Contoh: $firstItem->customer->nama --}}
                 Kode: {{ $namaCustomer }}
            </td>
            <td>
                <ul style="padding-left: 20px; margin-bottom: 0;">
                @foreach($groupItem as $item)
                    <li>
                        {{ $item->nama_produk }}
                        <small> (x{{ $item->qty }})</small>
                    </li>
                @endforeach
                </ul>
            </td>
            <td>Rp. {{ number_format($totalBayar) }}</td>
            <td>
                @if($firstItem->terima == 1)
                    <span class="label label-success">Diterima</span>
                @elseif($firstItem->tolak == 1)
                    <span class="label label-danger">Ditolak</span>
                @else
                    <span class="label label-warning">Menunggu Konfirmasi</span>
                @endif
            </td>
            <td>
                {{-- Tombol Aksi (Hanya muncul jika belum diterima/ditolak) --}}
                @if($firstItem->terima == 0 && $firstItem->tolak == 0)
                    <a href="{{ route('admin.produksi.terima', $invoice) }}" 
                       class="btn btn-success btn-sm btn-block"
                       onclick="return confirm('Yakin ingin Menerima pesanan ini?')">
                        <i class="fa fa-check"></i> Terima
                    </a>
                    
                    <a href="{{ route('admin.produksi.tolak', $invoice) }}" 
                       class="btn btn-danger btn-sm btn-block" style="margin-top: 5px;"
                       onclick="return confirm('Yakin ingin Menolak pesanan ini?')">
                        <i class="fa fa-times"></i> Tolak
                    </a>
                @else
                    <button class="btn btn-default btn-sm btn-block" disabled>Selesai</button>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
    </div>
</div>
@endsection