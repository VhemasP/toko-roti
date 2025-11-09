@extends('admin.layout')

@section('title', 'Manajemen Orderan')

@section('content')
<div class="card">
    <div class="card-body">
        
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Invoice</th>
                        <th scope="col">Nama Produk</th>
                        <th scope="col">Customer (ID)</th>
                        <th scope="col">Qty</th>
                        <th scope="col">Total Harga</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td><strong>{{ $order->invoice }}</strong></td>
                        <td>{{ $order->nama_produk }}</td>
                        <td>{{ $order->kode_customer }}</td>
                        <td>{{ $order->qty }}</td>
                        <td>Rp {{ number_format($order->harga * $order->qty, 0, ',', '.') }}</td>
                        <td>{{ \Carbon\Carbon::parse($order->tanggal)->format('d M Y') }}</td>
                        <td>
                            @if($order->status == 'Pesanan Baru')
                                <span class="badge bg-primary">{{ $order->status }}</span>
                            @elseif($order->status == '0')
                                <span class="badge bg-warning text-dark">Diproses</span>
                            @else
                                <span class="badge bg-secondary">{{ $order->status }}</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <h5 class="mb-1">Tidak Ada Orderan</h5>
                            <p class="text-muted">Belum ada pesanan yang masuk.</p>
                        </td>
                    </tr>
                    @endforelse </tbody>
            </table>
        </div>

    </div>
</div>
@endsection