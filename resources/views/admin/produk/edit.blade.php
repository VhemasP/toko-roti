@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <h2 style="border-bottom: 4px solid #ff8680; padding-bottom: 10px;">
            <b>Edit Produk</b>
        </h2>

        <form action="{{ route('admin.produk.update', $produk->kode_produk) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') <div class="form-group">
                <label>Kode Produk</label>
                <input type="text" class="form-control" name="kode_produk" value="{{ $produk->kode_produk }}" readonly style="background-color: #eee;">
            </div>

            <div class="form-group">
                <label>Nama Produk</label>
                <input type="text" class="form-control" name="nama" value="{{ $produk->nama }}" required>
            </div>

            <div class="form-group">
                <label>Gambar Produk</label>
                <br>
                @if(str_contains($produk->image, 'base64'))
                    <img src="{{ $produk->image }}" width="150" style="margin-bottom: 10px; border:1px solid #ddd;">
                @else
                    <img src="{{ asset('image/produk/' . $produk->image) }}" width="150" style="margin-bottom: 10px; border:1px solid #ddd;">
                @endif
                
                <input type="file" class="form-control" name="image">
                <small class="text-danger">Biarkan kosong jika tidak ingin mengganti gambar.</small>
            </div>

            <div class="form-group">
                <label>Harga (Rp)</label>
                <input type="number" class="form-control" name="harga" value="{{ $produk->harga }}" required>
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <textarea class="form-control" name="deskripsi" rows="5">{{ $produk->deskripsi }}</textarea>
            </div>

            <br>
            <button type="submit" class="btn btn-warning"><i class="glyphicon glyphicon-edit"></i> Update</button>
            <a href="{{ route('admin.produk') }}" class="btn btn-danger">Batal</a>
        </form>
    </div>
</div>
@endsection