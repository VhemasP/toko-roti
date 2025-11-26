@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="col-md-8 col-md-offset-2">
        <h2 style="border-bottom: 4px solid #ff8680; padding-bottom: 10px;">
            <b>Edit Bahan Baku</b>
        </h2>

        <form action="{{ route('admin.inventory.update', $data->kode_bk) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label>Kode Bahan Baku</label>
                <input type="text" class="form-control" name="kode_bk" value="{{ $data->kode_bk }}" readonly style="background-color: #eee;">
            </div>

            <div class="form-group">
                <label>Nama Bahan Baku</label>
                <input type="text" class="form-control" name="nama" value="{{ $data->nama }}" required>
            </div>

            <div class="form-group">
                <label>Stok (Qty)</label>
                <input type="number" class="form-control" name="qty" value="{{ $data->qty }}" required>
                <small class="text-muted">Masukkan jumlah stok terbaru.</small>
            </div>

            <div class="form-group">
                <label>Satuan</label>
                <input type="text" class="form-control" name="satuan" value="{{ $data->satuan }}" placeholder="Kg, Liter, Pcs..." required>
            </div>

            <div class="form-group">
                <label>Harga Per Satuan (Rp)</label>
                <input type="number" class="form-control" name="harga" value="{{ $data->harga }}" required>
            </div>

            <button type="submit" class="btn btn-warning"><i class="glyphicon glyphicon-edit"></i> Update</button>
            <a href="{{ route('admin.inventory') }}" class="btn btn-danger">Batal</a>
        </form>
    </div>
</div>
@endsection