<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi | Perpustakaan Desa Jungke</title>
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

        .register-container {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* Kiri: Gambar */
        .register-left {
            flex: 1.2;
            background: url('{{ asset('images/perpus.jpg') }}') center center/cover no-repeat;
        }

        /* Kanan: Form */
        .register-right {
            flex: 1;
            background: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 80px 100px;
        }

        .register-right h2 {
            color: var(--primary);
            font-weight: 700;
            margin-bottom: 8px;
        }

        .register-right p {
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

        .btn-register {
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

        .btn-register:hover {
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
            .register-container {
                flex-direction: column;
            }
            .register-right {
                padding: 40px 30px;
                text-align: center;
            }
            .register-left {
                height: 250px;
            }
        }
    </style>
</head>
<body>

<div class="register-container">

    {{-- KIRI: GAMBAR --}}
    <div class="register-left"></div>

    {{-- KANAN: FORM REGISTRASI --}}
    <div class="register-right">
        <h2>Perpustakaan Desa Jungke</h2>
        <p>Buat akun untuk bergabung dalam sistem perpustakaan desa.</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- Nama --}}
            <div class="mb-3">
                <label for="name" class="form-label fw-semibold">Nama Lengkap</label>
                <input type="text" name="name" id="name" class="form-control"
                       placeholder="Masukkan nama lengkap..." value="{{ old('name') }}" required autofocus>
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Email --}}
            <div class="mb-3">
                <label for="email" class="form-label fw-semibold">Email</label>
                <input type="email" name="email" id="email" class="form-control"
                       placeholder="Masukkan email..." value="{{ old('email') }}" required>
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

            {{-- Konfirmasi Password --}}
            <div class="mb-4">
                <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Kata Sandi</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                       class="form-control" placeholder="Ulangi kata sandi..." required>
                @error('password_confirmation')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Tombol Daftar --}}
            <button type="submit" class="btn-register">Daftar Sekarang</button>

            {{-- Link ke Login --}}
            <div class="text-center mt-4">
                <span class="text-muted small">Sudah punya akun?</span>
                <a href="{{ route('login') }}" class="text-link small">Login di sini</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>
