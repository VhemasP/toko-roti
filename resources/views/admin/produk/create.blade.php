@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <h2 style="border-bottom: 4px solid #ff8680; padding-bottom: 10px;">
            <b>Tambah Produk Baru</b>
        </h2>

        <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group">
                <label>Kode Produk</label>
                <input type="text" class="form-control" name="kode_produk" value="{{ $kode_otomatis }}" readonly style="background-color: #eee;">
            </div>

            <div class="form-group">
                <label>Nama Produk</label>
                <input type="text" class="form-control" name="nama" placeholder="Contoh: Roti Keju" required>
            </div>

            <div class="form-group">
                <label>Gambar Produk</label>
                <input type="file" class="form-control" name="image" required>
                <small class="text-danger">Format: JPG, JPEG, PNG. Maks: 2MB</small>
            </div>

            <div class="form-group">
                <label>Harga (Rp)</label>
                <input type="number" class="form-control" name="harga" placeholder="Contoh: 15000" min="100" required>
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <textarea class="form-control" name="deskripsi" rows="5" placeholder="Deskripsi lengkap produk..."></textarea>
            </div>

            <br>
            <button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-floppy-disk"></i> Simpan</button>
            <a href="{{ route('admin.produk') }}" class="btn btn-danger">Batal</a>
        </form>
    </div>
</div>
@endsection