@extends('layouts.app')

@section('content')
<div class="container">
	<h2 style="width: 100%; border-bottom: 4px solid #ff8680"><b>Detail Produk</b></h2>

	<div class="row">
		<div class="col-md-4">
			<div class="thumbnail">
                <img src="{{ $produk->image }}" width="400">
			</div>
		</div>

		<div class="col-md-8">
			<form action="{{ route('keranjang.add') }}" method="POST">
                @csrf
				<input type="hidden" name="kode_produk" value="{{ $produk->kode_produk }}">
				
                <table class="table table-striped">
					<tbody>
						<tr>
							<td><b>Nama</b></td>
							<td>{{ $produk->nama }}</td>
						</tr>
						<tr>
							<td><b>Harga</b></td>
							<td>Rp.{{ number_format($produk->harga) }}</td>
						</tr>
						<tr>
							<td><b>Deskripsi</b></td>
							<td>{{ $produk->deskripsi }}</td>
						</tr>
						<tr>
							<td><b>Jumlah</b></td>
							<td><input class="form-control" type="number" min="1" name="qty" value="1" style="width: 155px;"></td>
						</tr>
					</tbody>
				</table>

                @if(Session::has('kode_customer'))
				    <button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-shopping-cart"></i> Tambah ke Keranjang</button>
                @else
                    <a href="{{ route('login.form') }}" class="btn btn-success"><i class="glyphicon glyphicon-shopping-cart"></i> Tambah ke Keranjang</a>
                @endif
				<a href="{{ route('home') }}" class="btn btn-warning"> Kembali Belanja</a>
			</form>
		</div>
	</div>
</div>
<br><br>
@endsection