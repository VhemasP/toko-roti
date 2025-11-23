@extends('layouts.main')

@section('content')
<div class="container mt-5 text-center">
    {{-- Contoh Banner / Jumbotron --}}
    <div class="p-5 mb-4 bg-light rounded-3">
        <div class="container-fluid py-5">
            <h1 class="display-5 fw-bold">Selamat Datang di Toko Roti Kami!</h1>
            <p class="col-md-8 fs-4 mx-auto">Roti segar setiap hari untuk keluarga Anda dengan rasa yang tak terlupakan.</p>
            <a href="{{ route('about') }}" class="btn btn-danger btn-lg" style="background-color: #ff8680; border:none;">Pelajari Tentang Kami</a>
        </div>
    </div>
</div>
@endsection