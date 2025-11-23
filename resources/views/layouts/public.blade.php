<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Roti - @yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        /* Custom CSS untuk mempercantik */
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .navbar-brand { font-weight: bold; color: #f53003 !important; }
        .hero-section { background: #f8f9fa; padding: 60px 0; }
        .footer { background: #343a40; color: white; padding: 40px 0; margin-top: auto; }
        /* Agar footer selalu di bawah */
        body { display: flex; flex-direction: column; min-height: 100vh; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="bi bi-shop"></i> Toko Roti
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::routeIs('home') ? 'active fw-bold' : '' }}" href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::routeIs('about') ? 'active fw-bold' : '' }}" href="{{ route('about') }}">Tentang Kami</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Produk</a>
                    </li>
                </ul>
                <div class="d-flex ms-lg-3">
                    @auth
                        @if(Auth::guard('admin')->check())
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-danger">Dashboard Admin</a>
                        @else
                            <a href="{{ route('customer.dashboard') }}" class="btn btn-outline-primary">Dashboard Saya</a>
                        @endif
                    @else
                        <a href="{{ route('login.show') }}" class="btn btn-primary px-4">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="footer mt-auto">
        <div class="container text-center">
            <p class="mb-0">&copy; {{ date('Y') }} Toko Roti Enak. All rights reserved.</p>
            <small class="text-white-50">Dibuat dengan ❤️ untuk pecinta roti.</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>