<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - @yield('title')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #f8f9fa; /* Latar belakang abu-abu muda */
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 280px; /* Lebar sidebar */
            padding: 20px;
            background-color: #343a40; /* Warna sidebar (dark) */
            color: #fff;
            overflow-y: auto;
            z-index: 1000;
        }

        .sidebar-header {
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 1.5rem;
            color: #f53003; /* Warna aksen (merah) */
        }

        .sidebar-nav .nav-link {
            color: #adb5bd; /* Warna link */
            padding: 10px 15px;
            border-radius: 0.375rem; /* Sudut membulat */
            margin-bottom: 5px;
            display: flex;
            align-items: center;
        }

        .sidebar-nav .nav-link i {
            margin-right: 12px; /* Jarak ikon */
            font-size: 1.1rem;
        }

        .sidebar-nav .nav-link:hover {
            background-color: #495057; /* Warna saat hover */
            color: #fff;
        }

        .sidebar-nav .nav-link.active {
            background-color: #f53003; /* Warna link aktif (merah) */
            color: #fff;
        }

        .sidebar-footer {
            position: absolute;
            bottom: 20px;
            width: calc(100% - 40px); /* Sesuaikan padding */
        }

        .main-content {
            margin-left: 280px; /* Sesuaikan dengan lebar sidebar */
            padding: 30px;
        }

        .content-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        /* Styling untuk card */
        .card {
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border-radius: 0.75rem;
        }

        .card-header {
            background-color: #fff;
            border-bottom: 1px solid #eee;
            padding: 1.5rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        .img-thumbnail-custom {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 0.375rem;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2 class="sidebar-header">Toko Roti</h2>
        
       <ul class="nav flex-column sidebar-nav">
    <li class="nav-item">
        <a class="nav-link {{ Request::routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
            <i class="bi bi-box-seam"></i> Manajemen Produk
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ Request::routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
            <i class="bi bi-cart-check"></i> Manajemen Orderan
        </a>
    </li>

    <li class="nav-item">
         <a class="nav-link" href="#"> <i class="bi bi-graph-up"></i> Statistik Pembelian
         </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="#"> <i class="bi bi-people"></i> Customer Service
        </a>
    </li>

    </ul>

        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger w-100">
                    <i class="bi bi-box-arrow-left"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <main class="main-content">
        
        <div class="content-header">
            <h1 class="h3 mb-0">@yield('title')</h1>
            @yield('header-actions')
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h5 class="alert-heading">Terjadi Kesalahan!</h5>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="content-body">
            @yield('content')
        </div>
        
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>