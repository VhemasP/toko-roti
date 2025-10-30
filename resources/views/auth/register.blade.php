<!DOCTYPE html>
<html>
<head>
    <title>Register - Toko Roti</title>
    <style>
        body { font-family: sans-serif; display: grid; place-items: center; min-height: 90vh; background-color: #f9f9f9; }
        .container { background: #fff; border: 1px solid #ddd; border-radius: 8px; padding: 2rem; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        h2 { text-align: center; margin-top: 0; }
        div { margin-bottom: 1rem; }
        label { display: block; margin-bottom: 0.5rem; font-weight: 600; }
        input { width: 300px; padding: 0.75rem; border: 1px solid #ccc; border-radius: 4px; }
        button { width: 100%; padding: 0.75rem; background-color: #f53003; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 1rem; }
        button:hover { background-color: #d02802; }
        .error { color: red; font-size: 0.875rem; }
        .login-link { text-align: center; margin-top: 1rem; }
        .login-link a { color: #f53003; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Daftar Akun Customer</h2>
        <form method="POST" action="{{ route('register.post') }}">
            @csrf
            <div>
                <label for="nama">Nama Lengkap</label>
                <input id="nama" type="text" name="nama" value="{{ old('nama') }}" required>
                @error('nama') <p class="error">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                @error('email') <p class="error">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="username">Username</label>
                <input id="username" type="text" name="username" value="{{ old('username') }}" required>
                @error('username') <p class="error">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="telp">No. Telepon</label>
                <input id="telp" type="text" name="telp" value="{{ old('telp') }}" required>
                @error('telp') <p class="error">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required>
                @error('password') <p class="error">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="password_confirmation">Konfirmasi Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required>
            </div>
            <div>
                <button type="submit">Register</button>
            </div>
        </form>
         <div class="login-link">
            <p>Sudah punya akun? <a href="{{ route('login.show') }}">Login di sini</a></p>
        </div>
    </div>
</body>
</html>