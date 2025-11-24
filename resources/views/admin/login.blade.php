<!DOCTYPE html>
<html>
<head>
	<title>Login Admin</title>
	<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-theme.css') }}">
    <style>
        body { background-image: url('{{ asset("image/home/1.jpg") }}'); background-size: cover; }
        .login-box { background: #fff; padding: 20px; margin-top: 100px; border-radius: 5px; }
    </style>
</head>
<body>
	<div class="container">
        <div class="col-md-4 col-md-offset-4 login-box">
            <h2 class="text-center">LOGIN ADMIN</h2>
            <hr>
            
            @if($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            <form action="{{ route('admin.login.post') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Login</button>
            </form>
        </div>
	</div>
</body>
</html>