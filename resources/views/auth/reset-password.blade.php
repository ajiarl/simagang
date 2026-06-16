<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Reset Password — SiMagang</title>
    <meta name="description" content="Buat password baru untuk akun SiMagang Anda">

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
        .form-group input[readonly] {
            background: #f3f3fa;
            color: #737782;
            cursor: not-allowed;
        }
        .password-wrapper {
            position: relative;
        }
        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #737782;
            padding: 4px;
            display: flex;
            align-items: center;
        }
        .password-toggle:hover {
            color: #424751;
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
                    <span class="material-symbols-outlined">key</span>
                </div>
                <h1 class="login-title">Reset Password</h1>
                <p class="login-subtitle">Buat password baru untuk akun Anda</p>
            </div>

            {{-- Error Alert --}}
            @if($errors->has('email'))
                <div class="error-alert">
                    <span class="material-symbols-outlined" style="font-size: 18px;">error</span>
                    {{ $errors->first('email') }}
                </div>
            @endif

            {{-- Reset Password Form --}}
            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                {{-- Hidden token --}}
                <input type="hidden" name="token" value="{{ $token }}">

                {{-- Email (pre-filled, readonly) --}}
                <div class="form-group">
                    <label for="email">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email', $email) }}"
                        readonly
                    >
                    <x-form-error name="email" />
                </div>

                {{-- New Password --}}
                <div class="form-group">
                    <label for="password">Password Baru</label>
                    <div class="password-wrapper">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Minimal 8 karakter"
                            required
                            autofocus
                        >
                        <button type="button" class="password-toggle" onclick="togglePassword('password', 'eyeIcon1')">
                            <span class="material-symbols-outlined" style="font-size: 20px;" id="eyeIcon1">visibility_off</span>
                        </button>
                    </div>
                    <x-form-error name="password" />
                </div>

                {{-- Confirm Password --}}
                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <div class="password-wrapper">
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            placeholder="Ulangi password baru"
                            required
                        >
                        <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation', 'eyeIcon2')">
                            <span class="material-symbols-outlined" style="font-size: 20px;" id="eyeIcon2">visibility_off</span>
                        </button>
                    </div>
                    <x-form-error name="password_confirmation" />
                </div>

                <button type="submit" class="login-btn">Reset Password</button>
            </form>

            <a href="{{ route('login') }}" class="back-link">← Kembali ke Login</a>
        </div>

        <p class="login-footer">&copy; {{ date('Y') }} Sistem Informasi Magang — Universitas</p>
    </div>

    <style>
        /* CSS Spinner */
        @keyframes spin { 100% { transform: rotate(360deg); } }
        .spin { animation: spin 1s linear infinite; }
        .btn-loading { opacity: 0.8; cursor: not-allowed; pointer-events: none; }
    </style>
    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.textContent = 'visibility';
            } else {
                input.type = 'password';
                icon.textContent = 'visibility_off';
            }
        }

        // Global double submission protection
        document.addEventListener('submit', function(e) {
            if (e.target.tagName === 'FORM') {
                const btn = e.target.querySelector('button[type="submit"]');
                if (btn) {
                    setTimeout(() => {
                        btn.disabled = true;
                        btn.classList.add('btn-loading');
                        const originalContent = btn.innerHTML;
                        btn.dataset.originalContent = originalContent;
                        btn.innerHTML = '<span class="material-symbols-outlined spin" style="font-size: 18px; margin-right: 4px; vertical-align: middle;">sync</span><span style="vertical-align: middle;">Loading...</span>';
                    }, 10);
                }
            }
        });
    </script>
</body>
</html>
