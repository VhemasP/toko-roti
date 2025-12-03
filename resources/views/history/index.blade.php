@extends('layouts.app')

@section('content')
<div class="container" style="padding-bottom: 300px;">
	<h2 style="width: 100%; border-bottom: 4px solid #ff8680"><b>Riwayat Pesanan</b></h2>
	
<table class="table table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Invoice</th>
            <th>Tanggal</th>
            <th>Daftar Produk</th>
            <th>Total Belanja</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @php $no = 1; @endphp
        
        @foreach($orders as $invoice => $groupItem)
            @php
                $firstItem = $groupItem->first();
                $totalBelanja = $groupItem->sum(function ($item) {
                    return $item->harga * $item->qty;
                });
            @endphp
        <tr>
            <td>{{ $no++ }}</td>
            <td><b>{{ $invoice }}</b></td>
            <td>{{ $firstItem->tanggal }}</td>
            
            <td>
                <ul style="padding-left: 20px; margin: 0;">
                @foreach($groupItem as $item)
                    <li>
                        {{ $item->nama_produk }} 
                        <small class="text-muted">x {{ $item->qty }}</small>
                    </li>
                @endforeach
                </ul>
            </td>

            <td>Rp. {{ number_format($totalBelanja) }}</td>
            
            <td>
                @if($firstItem->status == 'Menunggu Pembayaran')
                    <span class="label label-warning" style="background-color: #ffc107; color: black;">Belum Bayar</span>
                
                {{-- TAMBAHAN: Label jika status Batal --}}
                @elseif($firstItem->status == 'Batal')
                    <span class="label label-danger">Dibatalkan</span>
                
                @else
                    @if($firstItem->terima == 1)
                        <span class="label label-success">Pesanan Diterima</span>
                        <br><small class="text-muted">Sedang diproses</small>
                    @elseif($firstItem->tolak == 1)
                        <span class="label label-danger">Pesanan Ditolak</span>
                    @else
                        <span class="label label-warning">Menunggu Konfirmasi</span>
                    @endif
                @endif
            </td>

            <td>
                @if($firstItem->status == 'Menunggu Pembayaran')
                    {{-- Tombol Bayar --}}
                    <a href="{{ route('payment.repay', $invoice) }}" class="btn btn-success btn-sm btn-block">
                        <i class="fa fa-money"></i> Bayar
                    </a>
                    
                    {{-- TAMBAHAN: Tombol Batalkan --}}
                    <a href="{{ route('pesanan.batal', $invoice) }}" 
                       class="btn btn-danger btn-sm btn-block" 
                       onclick="return confirm('Yakin ingin membatalkan pesanan ini?')">
                        <i class="fa fa-times"></i> Batalkan
                    </a>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>
@endsection