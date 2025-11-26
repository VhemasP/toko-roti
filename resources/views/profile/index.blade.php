@extends('layouts.app')

@section('content')
<div class="container" style="padding-bottom: 100px;">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h2 style="width: 100%; border-bottom: 4px solid #ff8680; margin-bottom: 20px;"><b>Profil Saya</b></h2>

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="glyphicon glyphicon-ok"></i> {{ session('success') }}
                </div>
            @endif

            <div class="panel panel-default">
                <div class="panel-body">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>Kode Customer</label>
                            <input type="text" class="form-control" value="{{ $customer->kode_customer }}" readonly style="background-color: #eee;">
                        </div>

                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" class="form-control" value="{{ $customer->username }}" readonly style="background-color: #eee;">
                        </div>

                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama" value="{{ $customer->nama }}" required>
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" value="{{ $customer->email }}" required>
                        </div>

                        <div class="form-group">
                            <label>No. Telepon</label>
                            <input type="text" class="form-control" name="telp" value="{{ $customer->telp }}" required>
                        </div>

                        <hr>
                        <div class="alert alert-warning">
                            <small><i class="glyphicon glyphicon-info-sign"></i> Kosongkan password jika tidak ingin mengubahnya.</small>
                        </div>

                        <div class="form-group">
                            <label>Password Baru (Opsional)</label>
                            <input type="password" class="form-control" name="password" placeholder="Masukkan password baru">
                        </div>

                        <div class="form-group">
                            <label>Konfirmasi Password Baru</label>
                            <input type="password" class="form-control" name="password_confirmation" placeholder="Ulangi password baru">
                        </div>

                        <button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-floppy-disk"></i> Simpan Perubahan</button>
                        <a href="{{ route('home') }}" class="btn btn-danger">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection