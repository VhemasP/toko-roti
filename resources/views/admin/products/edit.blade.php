@extends('admin.layout')

@section('title', 'Edit Produk')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Edit Produk</h3>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.products.update', $product->kode_produk) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') <div class="mb-3">
                <label for="kode_produk" class="form-label">Kode Produk</label>
                <input type="text" class="form-control" id="kode_produk" name="kode_produk" value="{{ $product->kode_produk }}" required readonly>
                <small class="form-text text-muted">Kode Produk tidak bisa diubah.</small>
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Produk</label>
                <input type="text" class="form-control" id="nama" name="nama" value="{{ $product->nama }}" required>
            </div>
            <div class="mb-3">
                <label for="harga" class="form-label">Harga (Rp)</label>
                <input type="number" class="form-control" id="harga" name="harga" value="{{ $product->harga }}" required>
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required>{{ $product->deskripsi }}</textarea>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Gambar Produk (Opsional)</label>
                <input class="form-control" type="file" id="image" name="image">
                @if($product->image)
                    <small class="form-text text-muted">Gambar saat ini:</small><br>
                    <img src="{{ asset('storage/images/'.$product->image) }}" alt="{{ $product->nama }}" width="150" class="mt-2">
                @endif
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection