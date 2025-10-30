@extends('admin.layout')

@section('title', 'Tambah Produk')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Tambah Produk</h3>
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

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="kode_produk" class="form-label">Kode Produk</label>
                <input type="text" class="form-control" id="kode_produk" name="kode_produk" value="{{ old('kode_produk') }}" required>
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Produk</label>
                <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}" required>
            </div>
            <div class="mb-3">
                <label for="harga" class="form-label">Harga (Rp)</label>
                <input type="number" class="form-control" id="harga" name="harga" value="{{ old('harga') }}" required>
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required>{{ old('deskripsi') }}</textarea>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Gambar Produk</label>
                <input class="form-control" type="file" id="image" name="image">
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection