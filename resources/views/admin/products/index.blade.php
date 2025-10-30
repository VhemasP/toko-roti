@extends('admin.layout')

@section('title', 'Daftar Produk')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Manajemen Produk</h3>
        <div class="text-end">
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Tambah Produk</a>
        </div>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Gambar</th>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>{{ $product->kode_produk }}</td>
                    <td>
                        @if($product->image)
<img src="{{ asset('storage/images/' . $product->image) }}" alt="{{ $product->nama }}" width="100">
                        @else
                            <span>No Image</span>
                        @endif
                    </td>
                    <td>{{ $product->nama }}</td>
                    <td>Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('admin.products.edit', $product->kode_produk) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.products.destroy', $product->kode_produk) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus produk ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data produk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection