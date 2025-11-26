@extends('layouts.app')

@section('content')
<div class="container" style="padding-bottom: 300px;">
	<h2 style="width: 100%; border-bottom: 4px solid #ff8680"><b>Riwayat Pesanan</b></h2>
	
    <table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>No</th>
				<th>Invoice</th>
				<th>Nama Produk</th>
				<th>Harga</th>
				<th>Qty</th>
				<th>Subtotal</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody>
            @php $no = 1; @endphp
			@forelse($orders as $row)
				<tr>
					<td>{{ $no++ }}</td>
					<td><b>{{ $row->invoice }}</b></td>
					<td>{{ $row->nama_produk }}</td>
					<td>Rp.{{ number_format($row->harga) }}</td>
					<td>{{ $row->qty }}</td>
					<td>Rp.{{ number_format($row->harga * $row->qty) }}</td>
					<td>
                        @if($row->terima == 1)
                            <span class="label label-success">Pesanan Diterima</span>
                            <br><small class="text-muted">Sedang diproses</small>
                        @elseif($row->tolak == 1)
                            <span class="label label-danger">Pesanan Ditolak</span>
                        @else
                            <span class="label label-warning">Menunggu Konfirmasi</span>
                        @endif
                    </td>
				</tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Anda belum pernah berbelanja.</td>
                </tr>
			@endforelse
		</tbody>
	</table>
</div>
@endsection