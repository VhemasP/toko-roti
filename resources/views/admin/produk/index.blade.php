@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2 style="border-bottom: 4px solid #ff8680; padding-bottom: 10px;">
            <b>Daftar Produk</b>
        </h2>
    </div>
    
    <div class="col-md-12">
        @if(session('success'))
            <div class="alert alert-success">
                <i class="glyphicon glyphicon-ok"></i> {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('admin.produk.create') }}" class="btn btn-success" style="margin-bottom: 20px;">
            <i class="glyphicon glyphicon-plus"></i> Tambah Produk
        </a>

        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="10%">Kode</th>
                    <th width="25%">Nama Produk</th>
                    <th width="15%">Gambar</th>
                    <th width="15%">Harga</th>
                    <th width="20%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $no=1; @endphp
                @forelse($products as $row)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $row->kode_produk }}</td>
                    <td>{{ $row->nama }}</td>
                    <td>
                        <img src="{{ $row->image }}" width="100" style="border:1px solid #ddd; padding:4px;">
                    <td>Rp.{{ number_format($row->harga) }}</td>
                    <td>
                        <a href="{{ route('admin.produk.edit', $row->kode_produk) }}" class="btn btn-warning btn-sm">
                            <i class="glyphicon glyphicon-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.bom.index', $row->kode_produk) }}" class="btn btn-info btn-sm">
                            <i class="glyphicon glyphicon-list-alt"></i> Resep
                        </a>
                        <form action="{{ route('admin.produk.delete', $row->kode_produk) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                            @csrf
                            @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="glyphicon glyphicon-trash"></i> Hapus
                                </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Data produk masih kosong.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection