@extends('layouts.app')

@section('content')
<div class="container" style="padding-bottom: 300px;">
	<h2 class="bg-success text-center" style="padding: 10px;">Checkout Berhasil</h2>
	<h4 class="text-center">Terima kasih sudah berbelanja di Bakery Online.</h4>
    <h4 class="text-center">Nomor Invoice Anda: <b>{{ $invoice }}</b></h4>
    <br>
    <center>
        <a href="{{ route('home') }}" class="btn btn-warning">Kembali ke Home</a>
    </center>
</div>
@endsection