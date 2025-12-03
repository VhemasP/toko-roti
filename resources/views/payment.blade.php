@extends('layouts.app')

@section('content')
<div class="container" style="padding-top: 50px; padding-bottom: 100px;">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">Konfirmasi Pembayaran</div>
                <div class="card-body text-center">
                    <h4>Invoice: {{ $invoiceBaru }}</h4>
                    <h2 class="my-4">Total: Rp. {{ number_format($totalBayar) }}</h2>
                    <p>Silakan selesaikan pembayaran Anda.</p>
                    <button id="pay-button" class="btn btn-success btn-lg btn-block">Bayar Sekarang</button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Logika URL Snap JS Dinamis (Sandbox vs Production) --}}
@php
    $snapUrl = config('services.midtrans.is_production') 
        ? 'https://app.midtrans.com/snap/snap.js' 
        : 'https://app.sandbox.midtrans.com/snap/snap.js';
@endphp

<script src="{{ $snapUrl }}" data-client-key="{{ config('services.midtrans.client_key') }}"></script>

<script type="text/javascript">
    var payButton = document.getElementById('pay-button');
    payButton.addEventListener('click', function () {
        snap.pay('{{ $snapToken }}', {
            onSuccess: function(result){
                window.location.href = "{{ route('checkout.success', ['invoice' => $invoiceBaru]) }}";
            },
            onPending: function(result){
                alert("Menunggu pembayaran!");
                window.location.href = "{{ route('home') }}";
            },
            onError: function(result){
                alert("Pembayaran gagal!");
                window.location.href = "{{ route('home') }}";
            },
            onClose: function(){
                alert('Anda menutup popup tanpa menyelesaikan pembayaran');
            }
        });
    });
</script>
@endsection