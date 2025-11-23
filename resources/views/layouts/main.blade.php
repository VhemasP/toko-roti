<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mirza-Cake Bakery</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* Style Custom dari User */
        .top { color: #555; padding: 5px 0; font-size: 14px; }
        .navbar-brand b { color: #ff8680; }
        .navbar { padding: 10px; border-bottom: 1px solid #ddd; }
        footer { border-top: 4px solid #ff8680; padding-top: 20px; margin-top: 50px; }
        .copy { background-color: #ff8680; padding: 10px; color: #fff; text-align: center; }
        .nav-link { font-weight: bold; color: #555; }
        .nav-link:hover { color: #ff8680; }
    </style>
</head>
<body>

    <div class="container-fluid bg-light">
        <div class="row top text-center">
            <div class="col-md-4">
                <span><i class="fa fa-phone"></i> +6282139669041</span>
            </div>
            <div class="col-md-4">
                <span><i class="fa fa-envelope"></i> kelompok2@gmail.com</span>
            </div>
            <div class="col-md-4">
                <span>Pink Bakery Indonesia</span>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <b>PINK BAKERY</b>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                    {{-- Pastikan route 'products' ada atau ubah href jadi # --}}
                    <li class="nav-item"><a class="nav-link" href="#">Produk</a></li> 
                    <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">Tentang Kami</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Manual Aplikasi</a></li>

                    @if(Auth::guard('customer')->check())
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fa fa-shopping-cart"></i> 
                                {{-- Placeholder jumlah keranjang (nanti diganti logic db) --}}
                                <b>[ 0 ]</b> 
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fa fa-user"></i> {{ Auth::guard('customer')->user()->nama }}
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Log Out</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="fa fa-shopping-cart"></i> [0]</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fa fa-user"></i> Akun
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('login.show') }}">Login</a></li>
                                <li><a class="dropdown-item" href="{{ route('register.show') }}">Register</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <div class="main-content">
        @yield('content')
    </div>

    <footer>
        <div class="container pb-4">
            <div class="row">
                <div class="col-md-4">
                    <h3 style="color: #ff8680"><b>PINK BAKERY</b></h3>
                    <p>Jl. </p>
                    <p><i class="fa fa-phone"></i> +6282139669041</p>
                    <p><i class="fa fa-envelope"></i> Kelompok2@gmail.com</p>
                </div>
                <div class="col-md-4">
                    <h5><b>Menu</b></h5>
                    <p><a href="#" class="text-dark text-decoration-none">Produk</a></p>
                    <p><a href="{{ route('about') }}" class="text-dark text-decoration-none">Tentang kami</a></p>
                    <p><a href="https://www.instagram.com/vhemas_dwi/" class="text-dark text-decoration-none" target="_blank">Hubungi Kami</a></p>
                </div>
                <div class="col-md-4">
                    </div>
            </div>
        </div>
        <div class="copy">
            <span>Copyright &copy; kelompok 2</span>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>