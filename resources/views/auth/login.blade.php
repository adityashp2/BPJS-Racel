<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ __('Masuk') }} - {{ config('app.name', 'BPJS Inventory') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&family=IBM+Plex+Mono:wght@500;600&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <style>
            :root {
                --ink: #101B2D;
                --ink-soft: #4B5768;
                --paper: #F4F5F8;
                --surface: #FFFFFF;
                --accent: #FF6A3D;
                --accent-ink: #C74E22;
                --accent-2: #12805C;
                --danger: #D64545;
                --line: #E1E4EA;
            }

            * { margin: 0; padding: 0; box-sizing: border-box; }

            body {
                font-family: 'Inter', sans-serif;
                background-color: var(--paper);
                color: var(--ink);
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 2rem 1.25rem;
                background-image:
                    linear-gradient(var(--line) 1px, transparent 1px),
                    linear-gradient(90deg, var(--line) 1px, transparent 1px);
                background-size: 42px 42px;
            }

            .login-card {
                width: 100%;
                max-width: 400px;
                background: var(--surface);
                border: 1px solid var(--line);
                border-radius: 16px;
                box-shadow: 0 20px 45px rgba(16, 27, 45, 0.10);
                padding: 2.4rem 2.2rem 2.2rem;
            }

            .login-brand {
                display: flex;
                justify-content: center;
                margin-bottom: 1.4rem;
            }

            .login-brand img {
                height: 44px;
                width: auto;
            }

            .eyebrow {
                font-family: 'IBM Plex Mono', monospace;
                font-size: 0.72rem;
                font-weight: 600;
                letter-spacing: 0.12em;
                text-transform: uppercase;
                color: var(--accent-ink);
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 0.4rem;
                margin-bottom: 0.5rem;
            }

            .eyebrow::before {
                content: "";
                width: 7px;
                height: 7px;
                background: var(--accent);
                border-radius: 2px;
            }

            .login-title {
                font-family: 'Space Grotesk', sans-serif;
                font-size: 1.4rem;
                font-weight: 600;
                text-align: center;
                color: var(--ink);
                margin-bottom: 0.3rem;
            }

            .login-subtitle {
                font-size: 0.9rem;
                text-align: center;
                color: var(--ink-soft);
                margin-bottom: 1.8rem;
            }

            .status-banner {
                background: rgba(18, 128, 92, 0.10);
                color: var(--accent-2);
                border: 1px solid rgba(18, 128, 92, 0.25);
                border-radius: 8px;
                padding: 0.7rem 0.9rem;
                font-size: 0.85rem;
                margin-bottom: 1.2rem;
            }

            .field { margin-bottom: 1.2rem; }

            .field label {
                display: block;
                font-size: 0.85rem;
                font-weight: 600;
                color: var(--ink);
                margin-bottom: 0.4rem;
            }

            .field input[type="email"],
            .field input[type="password"] {
                width: 100%;
                padding: 0.7rem 0.9rem;
                border: 1px solid var(--line);
                border-radius: 9px;
                font-family: 'Inter', sans-serif;
                font-size: 0.95rem;
                color: var(--ink);
                background: var(--surface);
                transition: border-color 0.2s ease, box-shadow 0.2s ease;
            }

            .field input:focus {
                outline: none;
                border-color: var(--accent);
                box-shadow: 0 0 0 3px rgba(255, 106, 61, 0.15);
            }

            .field-error {
                font-size: 0.8rem;
                color: var(--danger);
                margin-top: 0.4rem;
            }

            .row-between {
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-bottom: 1.4rem;
            }

            .remember {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                font-size: 0.85rem;
                color: var(--ink-soft);
                cursor: pointer;
            }

            .remember input[type="checkbox"] {
                width: 16px;
                height: 16px;
                accent-color: var(--accent);
                cursor: pointer;
            }

            .forgot-link {
                font-size: 0.85rem;
                color: var(--ink-soft);
                text-decoration: none;
            }

            .forgot-link:hover { color: var(--accent-ink); text-decoration: underline; }

            .btn-submit {
                width: 100%;
                background: var(--accent);
                border: none;
                color: white;
                padding: 0.85rem 1rem;
                border-radius: 9px;
                font-weight: 600;
                font-size: 0.98rem;
                cursor: pointer;
                transition: all 0.2s ease;
            }

            .btn-submit:hover {
                background: var(--accent-ink);
                transform: translateY(-1px);
                box-shadow: 0 12px 24px rgba(255, 106, 61, 0.28);
            }

            .back-home {
                display: block;
                text-align: center;
                margin-top: 1.6rem;
                font-size: 0.85rem;
                color: var(--ink-soft);
                text-decoration: none;
            }

            .back-home:hover { color: var(--accent-ink); }
        </style>
    </head>
    <body>
        <div class="login-card">
            <div class="login-brand">
                <img src="{{ asset('assets/images/bpjs1.png') }}" alt="BPJS Inventory">
            </div>

            <div class="eyebrow">BPJS Inventory</div>
            <h1 class="login-title">{{ __('Masuk ke akun Anda') }}</h1>
            <p class="login-subtitle">{{ __('Kelola dan lacak inventori Anda di satu tempat.') }}</p>

            @if (session('status'))
                <div class="status-banner">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="field">
                    <label for="email">{{ __('Email') }}</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                    @error('email')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="password">{{ __('Password') }}</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password">
                    @error('password')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row-between">
                    <label class="remember" for="remember_me">
                        <input id="remember_me" type="checkbox" name="remember">
                        {{ __('Ingat saya') }}
                    </label>

                    @if (Route::has('password.request'))
                        <a class="forgot-link" href="{{ route('password.request') }}">{{ __('Lupa password?') }}</a>
                    @endif
                </div>

                <button type="submit" class="btn-submit">{{ __('Masuk') }}</button>
            </form>

            <a href="{{ url('/') }}" class="back-home">
                <i class="fas fa-arrow-left me-1"></i>&nbsp;{{ __('Kembali ke beranda') }}
            </a>
        </div>
    </body>
</html>
