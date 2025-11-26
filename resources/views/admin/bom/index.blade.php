@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 style="border-bottom: 4px solid #ff8680; padding-bottom: 10px;">
                Resep: <b>{{ $produk->nama }}</b>
            </h2>
            <a href="{{ route('admin.produk') }}" class="btn btn-default"><i class="glyphicon glyphicon-arrow-left"></i> Kembali ke Daftar Produk</a>
            <br><br>
        </div>

        <div class="col-md-7">
            <div class="panel panel-info">
                <div class="panel-heading"><b>Daftar Bahan Baku per 1 Pcs</b></div>
                <div class="panel-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Bahan</th>
                                <th>Kebutuhan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no=1; @endphp
                            @forelse($boms as $row)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>
                                    @php
                                        $bahan = \App\Models\Inventory::where('kode_bk', $row->kode_bk)->first();
                                    @endphp
                                    {{ $bahan->nama ?? $row->kode_bk }}
                                </td>
                                <td>{{ $row->kebutuhan }} {{ $bahan->satuan ?? '' }}</td>
                                <td>
                                    <form action="{{ route('admin.bom.delete', $row->kode_bom) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Hapus bahan ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">Belum ada resep untuk produk ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="panel panel-primary">
                <div class="panel-heading"><b>Tambah Bahan Baku</b></div>
                <div class="panel-body">
                    <form action="{{ route('admin.bom.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="kode_produk" value="{{ $produk->kode_produk }}">

                        <div class="form-group">
                            <label>Pilih Bahan Baku</label>
                            <select name="kode_bk" class="form-control" required>
                                <option value="">-- Pilih Bahan --</option>
                                @foreach($bahanBaku as $bk)
                                    <option value="{{ $bk->kode_bk }}">
                                        {{ $bk->nama }} (Stok: {{ $bk->qty }} {{ $bk->satuan }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Jumlah Kebutuhan (untuk 1 pcs produk)</label>
                            <input type="number" step="0.01" class="form-control" name="kebutuhan" placeholder="Contoh: 0.5" required>
                            <small class="text-muted">Gunakan angka desimal jika perlu (misal 0.5 kg).</small>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Tambahkan ke Resep</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection