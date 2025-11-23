<!DOCTYPE html>
   <html>
   <head>
       <title>Toko Roti - Tentang Kami</title>
       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
   </head>
   <body>
       <nav class="navbar navbar-expand-lg navbar-light bg-light">
           <div class="container">
               <a class="navbar-brand" href="#">Toko Roti</a>
               <div class="collapse navbar-collapse">
                   <ul class="navbar-nav ms-auto">
                       <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Beranda</a></li>
                       <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">Tentang Kami</a></li>
                       <li class="nav-item"><a class="nav-link btn btn-primary text-white ms-2" href="{{ route('login.show') }}">Login</a></li>
                   </ul>
               </div>
           </div>
       </nav>

       <div class="container mt-5">
           <h1>Tentang Kami</h1>
           <p>Kami adalah toko roti yang berdedikasi menyajikan roti berkualitas tinggi sejak tahun 2010.</p>
           <p>Alamat: Jl. Roti Enak No. 123</p>
           <a href="{{ route('home') }}" class="btn btn-secondary">Kembali ke Beranda</a>
       </div>
   </body>
   </html>