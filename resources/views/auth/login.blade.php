<!DOCTYPE html>
<html>
<head>
    <title>Login - Toko Roti</title>
    <style>
        body { font-family: sans-serif; display: grid; place-items: center; min-height: 90vh; background-color: #f9f9f9; }
        .container { background: #fff; border: 1px solid #ddd; border-radius: 8px; padding: 2rem; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        h2 { text-align: center; margin-top: 0; }
        div { margin-bottom: 1rem; }
        label { display: block; margin-bottom: 0.5rem; font-weight: 600; }
        input { width: 300px; padding: 0.75rem; border: 1px solid #ccc; border-radius: 4px; }
        button { width: 100%; padding: 0.75rem; background-color: #f53003; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 1rem; }
        button:hover { background-color: #d02802; }
        .error { color: red; font-size: 0.875rem; margin-top: 0.5rem; }
        .register-link { text-align: center; margin-top: 1rem; }
        .register-link a { color: #f53003; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login Akun</h2>
        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <div>
                <label for="username">Username</label>
                <input id="username" type="text" name="username" value="{{ old('username') }}" required autofocus>
                
                @error('username')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required>
            </div>

            <div>
                <button type="submit">Login</button>
            </div>
        </form>
        <div class="register-link">
            <p>Belum punya akun? <a href="{{ route('register.show') }}">Daftar di sini</a></p>
        </div>
    </div>
</body>
</html>