<!DOCTYPE html>
<html>
<head>
	<title>Bakery Online - Laravel</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-theme.css') }}">
	<script src="{{ asset('js/jquery.js') }}"></script>
	<script src="{{ asset('js/bootstrap.min.js') }}"></script>
</head>
<body>
    <div class="container-fluid">
		<div class="row top">
			<center>
				<div class="col-md-4" style="padding: 3px;">
					<span> <i class="glyphicon glyphicon-earphone"></i> +6287804616097</span>
				</div>
				<div class="col-md-4" style="padding: 3px;">
					<span><i class="glyphicon glyphicon-envelope"></i> bakerynesa@gmail.com</span>
				</div>
				<div class="col-md-4" style="padding: 3px;">
					<span>Bakery Online Indonesia</span>
				</div>
			</center>
		</div>
	</div>

	<nav class="navbar navbar-default" style="padding: 5px;">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#" style="color: #ff8680"><b>BAKERYNESA</b></a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav navbar-right">
					<li><a href="{{ route('home') }}">Home</a></li>
					<li><a href="{{ route('produk.index') }}">Produk</a></li>
					<li><a href="{{ route('about') }}">About</a></li>
                    
                    @if(Session::has('kode_customer'))
                        <li>
    					<a href="{{ route('keranjang.index') }}">
        					<i class="glyphicon glyphicon-shopping-cart"></i> 
        					<b>[ {{ $totalKeranjang ?? 0 }} ]</b>
    					</a>
						</li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="glyphicon glyphicon-user"></i> {{ Session::get('nama') }} <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ route('profile.index') }}">Profile</a></li>
                                <li><a href="{{ route('history.index') }}">Riwayat Pesanan</a></li>
                                <li role="separator" class="divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" style="padding: 0 20px;">
                                        @csrf
                                        <button type="submit" class="btn btn-link" style="padding:0; text-decoration:none;">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li><a href="{{ route('login.form') }}">Masuk</a></li>
                        <li><a href="{{ route('register.form') }}">Daftar</a></li>
                    @endif
				</ul>
			</div>
		</div>
	</nav>

    @yield('content')

    <footer style="border-top: 4px solid #ff8680;  ">
		<div class="container" style="padding-bottom: 100px;">
			<div class="row">
				<div class="col-md-4">
					<h3 style="color: #ff8680"><b>BAKERYNESA</b></h3>
					<p>Jl. Tanah Merah Indah 1 No.10C</p>
					<p><i class="glyphicon glyphicon-earphone"></i> +6287804616097</p>
					<p><i class="glyphicon glyphicon-envelope"></i> bakerynesa@gmail.com</p>
				</div>
				<div class="col-md-4">
					<h5><b>Menu</b></h5>
					<p><a href="{{ route('home') }}"  style="color: #000">Produk</a></p>
					<p><a href="{{ route('about') }}"  style="color: #000">Tentang kami</a></p>
					<p><a href="#"  style="color: #000">Hubungi Kami</a></p>
				</div>
				<div class="col-md-4">
					<h5><b>Media Sosial</b></h5>
                    <p><a href="#" style="color: #000">Facebook</a></p>
                    <p><a href="#" style="color: #000">Instagram</a></p>
				</div>
			</div>
		</div>
		<div class="copy" style="background-color: #ff8680; padding: 5px; color: #fff; text-align: center;">
			<span>&copy; 2025 BakeryNesa - All Rights Reserved.</span>
		</div>
	</footer>
</body>
</html>