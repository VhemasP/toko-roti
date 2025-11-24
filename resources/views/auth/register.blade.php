@extends('layouts.app')

@section('content')
<div class="container" style="padding-bottom: 250px;">
	<h2 style="width: 100%; border-bottom: 4px solid #ff8680"><b>Registrasi</b></h2>

	<div class="row">
		<div class="col-md-6">
			<form action="{{ route('register') }}" method="POST">
				@csrf
				<div class="form-group">
					<label for="nama">Nama Lengkap</label>
					<input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Lengkap" required>
				</div>

				<div class="form-group">
					<label for="email">Email</label>
					<input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
				</div>

				<div class="form-group">
					<label for="username">Username</label>
					<input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
				</div>

				<div class="form-group">
					<label for="password">Password</label>
					<input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
				</div>

				<div class="form-group">
					<label for="password_confirmation">Konfirmasi Password</label>
					<input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Ulangi Password" required>
				</div>

				<div class="form-group">
					<label for="telp">No. Telepon</label>
					<input type="text" class="form-control" id="telp" name="telp" placeholder="No Telepon" required>
				</div>

				<button type="submit" class="btn btn-success">Daftar</button>
				<a href="{{ route('login.form') }}" class="btn btn-danger">Batal</a>
			</form>
		</div>
	</div>
</div>
@endsection