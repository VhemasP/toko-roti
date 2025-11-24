@extends('layouts.app')

@section('content')
<div class="container-fluid" style="margin: 0;padding: 0;">
	<div class="image" style="margin-top: -21px">
        <img src="{{ asset('images/home/1.jpg') }}" style="width: 100%; height: 650px;">
	</div>
</div>

<br><br>

<div class="container">
    <h4 class="text-center" style="font-family: arial; padding-top: 10px; padding-bottom: 10px; font-style: italic; line-height: 29px; border-top: 2px solid #ff8d87; border-bottom: 2px solid #ff8d87;">
        BakeryNesa adalah salah satu pelopor pertama dalam bisnis roti modern di Indonesia. Didirikan pada tahun 2025, saat ini dikelola di bawah PT. Kelompok 2. Produk kami sehat, bergizi, dan terjangkau oleh semua orang.
    </h4>

	<h2 style="width: 100%; border-bottom: 4px solid #ff8680; margin-top: 80px;"><b>Produk Kami</b></h2>

	<div class="row">
        @foreach($products as $product)
			<div class="col-sm-6 col-md-4">
				<div class="thumbnail">
                    <img src="{{ $product->image }}" style="width: 100%; height: 250px; object-fit: cover;">
					<div class="caption">
						<h3>{{ $product->nama }}</h3>
						<h4>Rp.{{ number_format($product->harga) }}</h4>
						<div class="row">
							<div class="col-md-6">
                                <a href="{{ route('produk.detail', ['kode_produk' => $product->kode_produk]) }}" class="btn btn-warning btn-block">Detail</a> 
							</div>
							
                            <div class="col-md-6">
                                @if(Session::has('kode_customer'))
                                    <form action="{{ route('keranjang.add') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="kode_produk" value="{{ $product->kode_produk }}">
                                        <input type="hidden" name="qty" value="1">
                                        <button type="submit" class="btn btn-success btn-block" role="button">
                                            <i class="glyphicon glyphicon-shopping-cart"></i> Tambah
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login.form') }}" class="btn btn-success btn-block" role="button">
                                        <i class="glyphicon glyphicon-shopping-cart"></i> Tambah
                                    </a>
                                @endif
                            </div>
						</div>
					</div>
				</div>
			</div>
		@endforeach
	</div>
</div>
<br><br><br>
@endsection