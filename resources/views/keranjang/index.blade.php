@extends('layouts.app')

@section('content')
<div class="container" style="padding-bottom: 300px;">
	<h2 style="width: 100%; border-bottom: 4px solid #ff8680"><b>Keranjang Belanja</b></h2>
	
    <table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>No</th>
				<th>Nama Produk</th>
				<th>Harga</th>
				<th>Jumlah</th>
				<th>Subtotal</th>
				<th>Aksi</th>
			</tr>
		</thead>
		<tbody>
            @php $no = 1; $total_bayar = 0; @endphp
			@forelse($keranjangs as $row)
                @php 
                    $subtotal = $row->harga * $row->qty; 
                    $total_bayar += $subtotal;
                @endphp
				<tr>
					<td>{{ $no++ }}</td>
					<td>{{ $row->nama_produk }}</td>
					<td>Rp.{{ number_format($row->harga) }}</td>
					<td>
    					<form action="{{ route('keranjang.update', $row->id_keranjang) }}" method="POST">
        				@csrf
        				@method('PUT')
        					<div class="input-group">
            					<input type="number" name="qty" class="form-control text-center" value="{{ $row->qty }}" min="1" style="width: 70px;">
            						<span class="input-group-btn">
                						<button type="submit" class="btn btn-primary btn-sm">Update</button>
            						</span>
        					</div>
    					</form>
					</td>
					<td>Rp.{{ number_format($subtotal) }}</td>
					<td>
                        <form action="{{ route('keranjang.delete', $row->id_keranjang) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Hapus</button>
                        </form>
					</td>
				</tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Keranjang masih kosong.</td>
                </tr>
			@endforelse
            
            @if(count($keranjangs) > 0)
			<tr>
				<td colspan="4" align="right"><b>Total Bayar</b></td>
				<td><b>Rp.{{ number_format($total_bayar) }}</b></td>
				<td>
                    <a href="{{ route('checkout') }}" class="btn btn-success">Checkout</a>
                </td>
			</tr>
            @endif
		</tbody>
	</table>
</div>
@endsection