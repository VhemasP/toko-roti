@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 50px; padding-bottom: 100px;">
	<h2 style="width: 100%; border-bottom: 4px solid #ff8680; margin-bottom: 30px;"><b>Daftar Produk Kami</b></h2>

	<div class="row">
		@foreach($products as $product)
			<div class="col-sm-6 col-md-4">
				<div class="thumbnail">
                    @if(str_contains($product->image, 'base64'))
                        <img src="{{ $product->image }}" style="width: 100%; height: 250px; object-fit: cover;">
                    @else
                        <img src="{{ asset('image/produk/' . $product->image) }}" style="width: 100%; height: 250px; object-fit: cover;">
                    @endif

					<div class="caption">
						<h3>{{ $product->nama }}</h3>
						<h4>Rp.{{ number_format($product->harga) }}</h4>
						<div class="row">
							<div class="col-md-6">
								<a href="{{ route('produk.detail', $product->kode_produk) }}" class="btn btn-warning btn-block">Detail</a> 
							</div>
							<div class="col-md-6">
                                @if(Session::has('kode_customer'))
                                    <form action="{{ route('keranjang.add') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="kode_produk" value="{{ $product->kode_produk }}">
                                        <input type="hidden" name="qty" value="1">
                                        <button type="submit" class="btn btn-success btn-block"><i class="glyphicon glyphicon-shopping-cart"></i> Tambah</button>
                                    </form>
                                @else
                                    <a href="{{ route('login.form') }}" class="btn btn-success btn-block"><i class="glyphicon glyphicon-shopping-cart"></i> Tambah</a>
                                @endif
							</div>
						</div>
					</div>
				</div>
			</div>
		@endforeach
	</div>
</div>
@endsection