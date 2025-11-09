@extends('admin.layout')

@section('title', 'Manajemen Produk')

@section('header-actions')
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Produk
    </a>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Kode</th>
                        <th scope="col">Gambar</th>
                        <th scope="col">Nama Produk</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Deskripsi Singkat</th>
                        <th scope="col" class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td><strong>{{ $product->kode_produk }}</strong></td>
                        
                        <td>
                            @if($product->image)
                                <img src="{{ asset('storage/images/' . $product->image) }}" alt="{{ $product->nama }}" class="img-thumbnail-custom">
                            @else
                                <span class="badge bg-light text-dark">No Image</span>
                            @endif
                        </td>
                        
                        <td>{{ $product->nama }}</td>
                        
                        <td>Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                        
                        <td>{{ \Illuminate\Support\Str::limit(strip_tags($product->deskripsi), 50) }}</td>
                        
                        <td class="text-end">
                            <a href="{{ route('admin.products.edit', $product->kode_produk) }}" class="btn btn-warning btn-sm" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('admin.products.destroy', $product->kode_produk) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('Yakin ingin menghapus produk {{ $product->nama }}?')">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <h5 class="mb-1">Tidak Ada Produk</h5>
                            <p class="text-muted">Silakan tambahkan produk baru.</p>
                        </td>
                    </tr>
                    @endForelse
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection