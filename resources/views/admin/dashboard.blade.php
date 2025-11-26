@extends('layouts.admin')

@section('content')
    <div class="jumbotron">
        <h1>Selamat Datang, Admin!</h1>
        <p>Halo <b>{{ Session::get('admin_username') }}</b>, selamat datang di halaman Administrator Bakery Online.</p>
        <p>Anda memiliki <b>{{ $pesanan_baru }}</b> pesanan baru yang perlu diproses.</p>
        <p><a class="btn btn-primary btn-lg" href="{{ route('admin.produksi') }}" role="button">Lihat Pesanan </a>
        </p>
    </div>
@endsection