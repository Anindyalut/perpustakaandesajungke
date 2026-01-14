<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Perpustakaan Desa Jungke</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --primary: #10665e;
            --primary-dark: #0e5b55;
            --bg-light: #f4f5f7;
        }

        body {
            margin: 0;
            height: 100vh;
            font-family: 'Poppins', sans-serif;
            background: #fff;
        }

        .login-container {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* Kiri: Gambar */
        .login-left {
            flex: 1.2;
            background: url('{{ asset('images/perpus.jpg') }}') center center/cover no-repeat;
        }

        /* Kanan: Form */
        .login-right {
            flex: 1;
            background: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 80px 100px;
        }

        .login-right h2 {
            color: var(--primary);
            font-weight: 700;
            margin-bottom: 8px;
        }

        .login-right p {
            color: #555;
            margin-bottom: 35px;
        }

        .form-control {
            border-radius: 6px;
            padding: 10px 12px;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(16,102,94,0.2);
        }

        .btn-login {
            background-color: var(--primary);
            border: none;
            color: #fff;
            font-weight: 500;
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            margin-top: 10px;
            transition: background 0.3s;
        }

        .btn-login:hover {
            background-color: var(--primary-dark);
        }

        .text-link {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }

        .text-link:hover {
            text-decoration: underline;
        }

        @media (max-width: 992px) {
            .login-container {
                flex-direction: column;
            }
            .login-right {
                padding: 40px 30px;
                text-align: center;
            }
            .login-left {
                height: 250px;
            }
        }
    </style>
</head>
<body>

<div class="login-container">

    {{-- KIRI: GAMBAR --}}
    <div class="login-left"></div>

    {{-- KANAN: FORM LOGIN --}}
    <div class="login-right">
        <h2>Perpustakaan Desa Jungke</h2>
        <p>Selamat datang! Silakan login untuk melanjutkan ke sistem.</p>

        @if (session('status'))
            <div class="alert alert-success small">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            {{-- Email --}}
            <div class="mb-3">
                <label for="email" class="form-label fw-semibold">Email</label>
                <input type="email" name="email" id="email" class="form-control"
                       placeholder="Masukkan email..." value="{{ old('email') }}" required autofocus>
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mb-3">
                <label for="password" class="form-label fw-semibold">Kata Sandi</label>
                <input type="password" name="password" id="password" class="form-control"
                       placeholder="Masukkan kata sandi..." required>
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Remember Me --}}
            <div class="form-check mb-3">
                <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                <label for="remember_me" class="form-check-label">Ingat saya</label>
            </div>

            {{-- Tombol Login --}}
            <button type="submit" class="btn-login">Masuk</button>

            {{-- Lupa Password --}}
            @if (Route::has('password.request'))
                <div class="text-end mt-2">
                    <a href="{{ route('password.request') }}" class="small text-muted">Lupa kata sandi?</a>
                </div>
            @endif

            {{-- Registrasi --}}
            @if (Route::has('register'))
                <div class="text-center mt-4">
                    <span class="text-muted small">Belum punya akun?</span>
                    <a href="{{ route('register') }}" class="text-link small">Registrasi di sini</a>
                </div>
            @endif
        </form>
    </div>
</div>

</body>
</html>
