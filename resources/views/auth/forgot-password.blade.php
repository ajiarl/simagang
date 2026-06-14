<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lupa Password — SiMagang</title>
    <meta name="description" content="Reset password akun SiMagang Anda">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f9f9ff;
            font-family: 'Inter', sans-serif;
            padding: 24px;
        }
        .login-container {
            width: 100%;
            max-width: 380px;
        }
        .login-card {
            background: #ffffff;
            border: 0.5px solid #e2e8f0;
            border-radius: 8px;
            box-shadow: 0px 4px 6px -1px rgba(0, 0, 0, 0.05);
            padding: 28px 24px;
        }
        .login-header {
            text-align: center;
            margin-bottom: 24px;
        }
        .login-icon {
            width: 56px;
            height: 56px;
            margin: 0 auto 12px;
            background: #ededf4;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-icon .material-symbols-outlined {
            font-size: 28px;
            color: #003e7e;
        }
        .login-title {
            font-size: 24px;
            line-height: 32px;
            letter-spacing: -0.01em;
            font-weight: 700;
            color: #003e7e;
            margin-bottom: 4px;
        }
        .login-subtitle {
            font-size: 15px;
            line-height: 22px;
            color: #424751;
        }
        .form-group {
            margin-bottom: 16px;
        }
        .form-group label {
            display: block;
            font-size: 13px;
            line-height: 18px;
            font-weight: 600;
            letter-spacing: 0.03em;
            color: #191c20;
            margin-bottom: 4px;
        }
        .form-group input {
            width: 100%;
            background: #ffffff;
            border: 1px solid #c2c6d3;
            border-radius: 4px;
            padding: 10px 16px;
            font-size: 15px;
            line-height: 22px;
            font-family: 'Inter', sans-serif;
            color: #191c20;
            transition: border-color 150ms ease, box-shadow 150ms ease;
            box-sizing: border-box;
        }
        .form-group input::placeholder {
            color: #737782;
        }
        .form-group input:focus {
            outline: none;
            border-color: #1a56a0;
            box-shadow: 0 0 0 1px #1a56a0;
        }
        .login-btn {
            width: 100%;
            background: #1a56a0;
            color: #ffffff;
            font-size: 13px;
            line-height: 18px;
            font-weight: 600;
            padding: 12px 18px;
            border-radius: 6px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            border: none;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            letter-spacing: 0.03em;
            transition: background 150ms ease;
            margin-top: 8px;
        }
        .login-btn:hover {
            background: #2170e4;
        }
        .login-btn:active {
            background: #003e7e;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 16px;
            font-size: 14px;
            color: #0058be;
            text-decoration: none;
        }
        .back-link:hover {
            text-decoration: underline;
        }
        .login-footer {
            text-align: center;
            margin-top: 24px;
            font-size: 14px;
            line-height: 20px;
            color: #737782;
        }
        .success-alert {
            background: #dcfce7;
            color: #166534;
            padding: 10px 14px;
            border-radius: 6px;
            font-size: 14px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .error-alert {
            background: #ffdad6;
            color: #93000a;
            padding: 10px 14px;
            border-radius: 6px;
            font-size: 14px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <div class="login-card">
            {{-- Header --}}
            <div class="login-header">
                <div class="login-icon">
                    <span class="material-symbols-outlined">lock_reset</span>
                </div>
                <h1 class="login-title">Lupa Password?</h1>
                <p class="login-subtitle">Masukkan email Anda untuk menerima link reset password</p>
            </div>

            {{-- Success Alert --}}
            @if(session('success'))
                <div class="success-alert">
                    <span class="material-symbols-outlined" style="font-size: 18px;">check_circle</span>
                    {{ session('success') }}
                </div>
            @endif

            {{-- Error Alert --}}
            @if($errors->has('email'))
                <div class="error-alert">
                    <span class="material-symbols-outlined" style="font-size: 18px;">error</span>
                    {{ $errors->first('email') }}
                </div>
            @endif

            {{-- Forgot Password Form --}}
            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="nama@email.com"
                        required
                        autofocus
                    >
                    <x-form-error name="email" />
                </div>

                <button type="submit" class="login-btn">Kirim Link Reset</button>
            </form>

            <a href="{{ route('login') }}" class="back-link">← Kembali ke Login</a>
        </div>

        <p class="login-footer">&copy; {{ date('Y') }} Sistem Informasi Magang — Universitas</p>
    </div>

</body>
</html>
