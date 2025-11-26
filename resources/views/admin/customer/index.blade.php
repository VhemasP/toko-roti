@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2 style="border-bottom: 4px solid #ff8680; padding-bottom: 10px;">
            <b>Data Customer</b>
        </h2>
        
        @if(session('success'))
            <div class="alert alert-success">
                <i class="glyphicon glyphicon-ok"></i> {{ session('success') }}
            </div>
        @endif

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Customer</th>
                    <th>Email</th>
                    <th>No. Telp</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $no=1; @endphp
                @forelse($customers as $row)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $row->nama }}</td>
                    <td>{{ $row->email }}</td>
                    <td>{{ $row->telp }}</td>
                    <td>
                        <form action="{{ route('admin.customer.delete', $row->kode_customer) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus customer ini?')">
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
                    <td colspan="5" class="text-center">Belum ada data customer.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection