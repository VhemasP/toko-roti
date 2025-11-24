@extends('layouts.app')

@section('content')
<div class="container" style="padding-bottom: 250px;">
	<h2 style="width: 100%; border-bottom: 4px solid #ff8680"><b>Login</b></h2>

	<div class="row">
        @if($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

		<div class="col-md-6">
			<form action="{{ route('login') }}" method="POST">
				@csrf
				<div class="form-group">
					<label for="username">Username</label>
					<input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
				</div>

				<div class="form-group">
					<label for="password">Password</label>
					<input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
				</div>

				<button type="submit" class="btn btn-success">Login</button>
				<a href="{{ route('register.form') }}" class="btn btn-primary">Daftar</a>
			</form>
		</div>
	</div>
</div>
@endsection