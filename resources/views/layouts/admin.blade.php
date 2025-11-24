<!DOCTYPE html>
<html>
<head>
	<title>Admin - Bakery Online</title>
	<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-theme.css') }}">
	<script src="{{ asset('js/jquery.js') }}"></script>
	<script src="{{ asset('js/bootstrap.min.js') }}"></script>
</head>
<body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">Admin Bakery</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav navbar-right">
					<li><a href="{{ route('admin.dashboard') }}">Home</a></li>
					<li><a href="#">Produk</a></li>
					<li><a href="#">Customer</a></li>
					<li><a href="#">Inventory</a></li>
					<li><a href="#">Laporan</a></li>
					<li><a href="{{ route('admin.logout') }}">Logout</a></li>
				</ul>
			</div>
		</div>
	</nav>

    <div class="container" style="margin-top: 70px; margin-bottom: 70px;">
        @yield('content')
    </div>

    <footer style="background-color: #333; padding: 10px; color: #fff; text-align: center; position: fixed; bottom: 0; width: 100%;">
		<span>&copy; 2025 BakeryNesa Admin System</span>
	</footer>
</body>
</html>