<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ __('Daftar') }} - {{ config('app.name', 'BPJS Inventory') }}</title>

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

            .register-card {
                width: 100%;
                max-width: 440px;
                background: var(--surface);
                border: 1px solid var(--line);
                border-radius: 16px;
                box-shadow: 0 20px 45px rgba(16, 27, 45, 0.10);
                padding: 2.4rem 2.2rem 2.2rem;
            }

            .register-brand {
                display: flex;
                justify-content: center;
                margin-bottom: 1.4rem;
            }

            .register-brand img {
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

            .register-title {
                font-family: 'Space Grotesk', sans-serif;
                font-size: 1.4rem;
                font-weight: 600;
                text-align: center;
                color: var(--ink);
                margin-bottom: 0.3rem;
            }

            .register-subtitle {
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

            .field input[type="text"],
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

            .password-hint {
                font-size: 0.75rem;
                color: var(--ink-soft);
                margin-top: 0.3rem;
                line-height: 1.4;
            }

            .password-hint i {
                margin-right: 0.2rem;
            }

            .row-between {
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-top: 0.5rem;
            }

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
                margin-top: 0.5rem;
            }

            .btn-submit:hover {
                background: var(--accent-ink);
                transform: translateY(-1px);
                box-shadow: 0 12px 24px rgba(255, 106, 61, 0.28);
            }

            .login-link {
                display: block;
                text-align: center;
                margin-top: 1.6rem;
                font-size: 0.85rem;
                color: var(--ink-soft);
                text-decoration: none;
            }

            .login-link:hover { color: var(--accent-ink); }

            .login-link i {
                margin-right: 0.3rem;
            }

            .back-home {
                display: block;
                text-align: center;
                margin-top: 0.8rem;
                font-size: 0.85rem;
                color: var(--ink-soft);
                text-decoration: none;
            }

            .back-home:hover { color: var(--accent-ink); }

            /* Password strength indicator (optional) */
            .password-strength {
                display: flex;
                gap: 4px;
                margin-top: 0.4rem;
            }

            .password-strength span {
                flex: 1;
                height: 3px;
                background: var(--line);
                border-radius: 2px;
                transition: background 0.3s ease;
            }

            .password-strength span.active.weak { background: #FF6B6B; }
            .password-strength span.active.medium { background: #FFA94D; }
            .password-strength span.active.strong { background: var(--accent-2); }

            /* Responsive adjustments */
            @media (max-width: 480px) {
                .register-card {
                    padding: 1.8rem 1.4rem 1.8rem;
                }

                .register-title {
                    font-size: 1.2rem;
                }
            }
        </style>
    </head>
    <body>
        <div class="register-card">
            <div class="register-brand">
                <img src="{{ asset('assets/images/bpjs1.png') }}" alt="BPJS Inventory">
            </div>

            <div class="eyebrow">BPJS Inventory</div>
            <h1 class="register-title">{{ __('Buat akun baru') }}</h1>
            <p class="register-subtitle">{{ __('Daftar sekarang untuk mulai mengelola inventori Anda.') }}</p>

            @if (session('status'))
                <div class="status-banner">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="field">
                    <label for="name">{{ __('Nama lengkap') }}</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="{{ __('Masukkan nama lengkap') }}">
                    @error('name')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="email">{{ __('Email') }}</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="{{ __('Masukkan alamat email') }}">
                    @error('email')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="password">{{ __('Password') }}</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="{{ __('Minimal 8 karakter') }}">
                    <div class="password-hint">
                        <i class="fas fa-info-circle"></i>
                        {{ __('Password harus terdiri dari minimal 8 karakter.') }}
                    </div>
                    @error('password')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="password_confirmation">{{ __('Konfirmasi Password') }}</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="{{ __('Ketik ulang password') }}">
                    @error('password_confirmation')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fas fa-user-plus me-2"></i>{{ __('Daftar') }}
                </button>
            </form>

            <a href="{{ route('login') }}" class="login-link">
                <i class="fas fa-arrow-left"></i>{{ __('Sudah punya akun? Masuk di sini') }}
            </a>

            <a href="{{ url('/') }}" class="back-home">
                <i class="fas fa-home me-1"></i>{{ __('Kembali ke beranda') }}
            </a>
        </div>

        <script>
            // Optional: Simple password strength indicator (visual only)
            document.addEventListener('DOMContentLoaded', function() {
                const passwordInput = document.getElementById('password');
                const strengthContainer = document.createElement('div');
                strengthContainer.className = 'password-strength';
                strengthContainer.innerHTML = `
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                `;
                passwordInput.parentNode.insertBefore(strengthContainer, passwordInput.nextSibling);

                passwordInput.addEventListener('input', function() {
                    const value = this.value;
                    const bars = strengthContainer.querySelectorAll('span');
                    let strength = 0;

                    if (value.length >= 8) strength++;
                    if (/[a-z]/.test(value) && /[A-Z]/.test(value)) strength++;
                    if (/\d/.test(value)) strength++;
                    if (/[^a-zA-Z0-9]/.test(value)) strength++;

                    bars.forEach((bar, index) => {
                        bar.className = '';
                        if (index < strength) {
                            bar.classList.add('active');
                            if (strength <= 2) bar.classList.add('weak');
                            else if (strength === 3) bar.classList.add('medium');
                            else bar.classList.add('strong');
                        }
                    });
                });
            });
        </script>
    </body>
</html>
