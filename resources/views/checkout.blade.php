@extends('layouts.app')

@section('content')
<div class="container" style="padding-bottom: 200px">
	<h2 style="width: 100%; border-bottom: 4px solid #ff8680"><b>Checkout</b></h2>
	<div class="row">
		<div class="col-md-6">
			<h4>Daftar Pesanan</h4>
			<table class="table table-striped">
				<tr>
					<th>No</th>
					<th>Nama</th>
					<th>Harga</th>
					<th>Qty</th>
					<th>Subtotal</th>
				</tr>
				@php $no=1; @endphp
				@foreach($keranjangs as $row)
				<tr>
					<td>{{ $no++ }}</td>
					<td>{{ $row->nama_produk }}</td>
					<td>Rp.{{ number_format($row->harga) }}</td>
					<td>{{ $row->qty }}</td>
					<td>Rp.{{ number_format($row->harga * $row->qty) }}</td>
				</tr>
				@endforeach
			</table>
            <h3>Total: Rp. {{ number_format($total) }}</h3>
		</div>

		<div class="col-md-6">
			<h4>Form Pengiriman</h4>
			<form action="{{ route('checkout.process') }}" method="POST">
				@csrf
				<div class="form-group">
					<label>Provinsi</label>
					<input type="text" class="form-control" name="provinsi" placeholder="Contoh: Jawa Timur" required>
				</div>
				<div class="form-group">
					<label>Kota/Kabupaten</label>
					<input type="text" class="form-control" name="kota" placeholder="Contoh: Surabaya" required>
				</div>
				<div class="form-group">
					<label>Alamat Lengkap</label>
					<input type="text" class="form-control" name="alamat" placeholder="Jalan, No Rumah, RT/RW" required>
				</div>
				<div class="form-group">
					<label>Kode Pos</label>
					<input type="text" class="form-control" name="kode_pos" placeholder="Kode Pos" required>
				</div>

				<button type="submit" class="btn btn-success">Proses Pesanan</button>
				<a href="{{ route('keranjang.index') }}" class="btn btn-danger">Batal</a>
			</form>
		</div>
	</div>
</div>
@endsection