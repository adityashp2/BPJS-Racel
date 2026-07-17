<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'BPJS Inventory') }} - Sistem Manajemen Inventori</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&family=IBM+Plex+Mono:wght@500;600&display=swap" rel="stylesheet">

        <!-- Font Awesome -->
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
                --line: #E1E4EA;
                --radius: 14px;
            }

            * { margin: 0; padding: 0; box-sizing: border-box; }

            html { scroll-behavior: smooth; }

            body {
                font-family: 'Inter', sans-serif;
                background-color: var(--paper);
                color: var(--ink);
                min-height: 100vh;
                overflow-x: hidden;
                line-height: 1.6;
            }

            .eyebrow {
                font-family: 'IBM Plex Mono', monospace;
                font-size: 0.78rem;
                font-weight: 600;
                letter-spacing: 0.14em;
                text-transform: uppercase;
                color: var(--accent-ink);
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
            }

            .eyebrow::before {
                content: "";
                width: 8px;
                height: 8px;
                background: var(--accent);
                display: inline-block;
                border-radius: 2px;
            }

            /* Navbar */
            .navbar {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                z-index: 50;
                background: rgba(244, 245, 248, 0.85);
                backdrop-filter: blur(10px);
                border-bottom: 1px solid var(--line);
                padding: 0.9rem 0;
            }

            .navbar .container {
                max-width: 1180px;
                margin: 0 auto;
                padding: 0 1.5rem;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .navbar-brand {
                display: flex;
                align-items: center;
                text-decoration: none;
            }

            .navbar-brand img {
                height: 52px;
                width: auto;
                max-width: 200px;
                object-fit: contain;
            }

            .btn-login {
                background: var(--ink);
                border: 1px solid var(--ink);
                color: var(--surface);
                padding: 0.6rem 1.4rem;
                border-radius: 8px;
                font-weight: 600;
                font-size: 0.92rem;
                transition: all 0.25s ease;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
            }

            .btn-login:hover {
                background: var(--accent);
                border-color: var(--accent);
                color: white;
                transform: translateY(-1px);
            }

            /* Hero */
            .hero-section {
                padding: 168px 1.5rem 96px;
                position: relative;
                background-image:
                    linear-gradient(var(--line) 1px, transparent 1px),
                    linear-gradient(90deg, var(--line) 1px, transparent 1px);
                background-size: 42px 42px;
                background-position: center top;
                -webkit-mask-image: linear-gradient(to bottom, black 0%, black 70%, transparent 100%);
                mask-image: linear-gradient(to bottom, black 0%, black 70%, transparent 100%);
            }

            .hero-inner {
                max-width: 1180px;
                margin: 0 auto;
                display: grid;
                grid-template-columns: 1.05fr 0.95fr;
                gap: 3rem;
                align-items: center;
            }

            .hero-title {
                font-family: 'Space Grotesk', sans-serif;
                font-size: 3.1rem;
                font-weight: 700;
                line-height: 1.12;
                letter-spacing: -0.01em;
                margin: 1.1rem 0 1.4rem;
                color: var(--ink);
            }

            .hero-title .highlight {
                color: var(--accent-ink);
                position: relative;
                white-space: nowrap;
            }

            .hero-subtitle {
                font-size: 1.08rem;
                color: var(--ink-soft);
                max-width: 520px;
                margin-bottom: 2.2rem;
            }

            .cta-buttons {
                display: flex;
                flex-wrap: wrap;
                gap: 0.9rem;
            }

            .btn-primary-custom,
            .btn-outline-custom {
                padding: 0.9rem 1.9rem;
                border-radius: 9px;
                font-weight: 600;
                font-size: 1rem;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                transition: all 0.25s ease;
            }

            .btn-primary-custom {
                background: var(--accent);
                border: 1px solid var(--accent);
                color: white;
            }

            .btn-primary-custom:hover {
                background: var(--accent-ink);
                border-color: var(--accent-ink);
                transform: translateY(-2px);
                color: white;
                box-shadow: 0 12px 24px rgba(255, 106, 61, 0.28);
            }

            .btn-outline-custom {
                background: transparent;
                border: 1px solid var(--ink);
                color: var(--ink);
            }

            .btn-outline-custom:hover {
                background: var(--ink);
                color: white;
                transform: translateY(-2px);
            }

            /* Signature element: inventory tag stack */
            .tag-stack {
                position: relative;
                height: 380px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .inv-tag {
                position: absolute;
                width: 260px;
                background: var(--surface);
                border: 1px solid var(--line);
                border-radius: 10px;
                box-shadow: 0 18px 40px rgba(16, 27, 45, 0.10);
                padding: 1.25rem 1.3rem 1.4rem;
            }

            .inv-tag::before {
                content: "";
                position: absolute;
                top: 18px;
                left: -9px;
                width: 18px;
                height: 18px;
                background: var(--paper);
                border: 1px solid var(--line);
                border-radius: 50%;
            }

            .inv-tag-back {
                transform: rotate(-9deg) translate(-58px, -18px);
                opacity: 0.65;
                z-index: 1;
            }

            .inv-tag-front {
                transform: rotate(6deg) translate(28px, 26px);
                z-index: 2;
            }

            .inv-tag-code {
                font-family: 'IBM Plex Mono', monospace;
                font-size: 0.72rem;
                letter-spacing: 0.06em;
                color: var(--ink-soft);
                margin-bottom: 0.6rem;
            }

            .inv-tag-name {
                font-family: 'Space Grotesk', sans-serif;
                font-weight: 600;
                font-size: 1.02rem;
                color: var(--ink);
                margin-bottom: 0.2rem;
            }

            .inv-tag-status {
                display: inline-block;
                font-size: 0.72rem;
                font-weight: 600;
                padding: 0.2rem 0.55rem;
                border-radius: 5px;
                margin-top: 0.5rem;
            }

            .status-ok { background: rgba(18, 128, 92, 0.12); color: var(--accent-2); }
            .status-pending { background: rgba(255, 106, 61, 0.14); color: var(--accent-ink); }

            .inv-tag-barcode {
                display: flex;
                align-items: flex-end;
                gap: 2px;
                height: 34px;
                margin-top: 0.9rem;
            }

            .inv-tag-barcode span {
                display: block;
                width: 3px;
                background: var(--ink);
                opacity: 0.85;
            }

            /* Features */
            .features-section {
                max-width: 1180px;
                margin: 2rem auto 0;
                padding: 0 1.5rem;
            }

            .features {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 1.25rem;
            }

            .feature-item {
                background: var(--surface);
                padding: 2rem 1.75rem;
                border-radius: var(--radius);
                border: 1px solid var(--line);
                border-left: 3px solid var(--accent);
                transition: all 0.25s ease;
            }

            .feature-item:hover {
                transform: translateY(-4px);
                box-shadow: 0 16px 30px rgba(16, 27, 45, 0.08);
            }

            .feature-item i {
                font-size: 1.5rem;
                color: var(--accent-ink);
                margin-bottom: 1.1rem;
                display: block;
            }

            .feature-item h5 {
                font-family: 'Space Grotesk', sans-serif;
                font-weight: 600;
                margin-bottom: 0.5rem;
                font-size: 1.12rem;
                color: var(--ink);
            }

            .feature-item p {
                font-size: 0.92rem;
                color: var(--ink-soft);
                margin: 0;
            }

            /* Corporate / stats band */
            .corporate-section {
                background: var(--ink);
                color: white;
                padding: 4rem 1.5rem;
                margin-top: 5rem;
            }

            .corporate-content {
                max-width: 880px;
                margin: 0 auto;
                text-align: center;
            }

            .corporate-title {
                font-family: 'Space Grotesk', sans-serif;
                font-size: 2rem;
                font-weight: 600;
                margin-bottom: 1rem;
            }

            .corporate-description {
                font-size: 1.05rem;
                color: rgba(255,255,255,0.72);
                line-height: 1.65;
                max-width: 640px;
                margin: 0 auto 2.5rem;
            }

            .stats-grid {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 2rem;
                border-top: 1px solid rgba(255,255,255,0.14);
                padding-top: 2.5rem;
            }

            .stat-item { text-align: center; }

            .stat-number {
                font-family: 'Space Grotesk', sans-serif;
                font-size: 2.3rem;
                font-weight: 700;
                color: var(--accent);
                display: block;
            }

            .stat-label {
                font-size: 0.86rem;
                color: rgba(255,255,255,0.65);
                margin-top: 0.4rem;
            }

            footer.site-footer {
                text-align: center;
                padding: 2rem 1.5rem;
                font-size: 0.85rem;
                color: var(--ink-soft);
            }

            @media (max-width: 900px) {
                .hero-inner { grid-template-columns: 1fr; }
                .tag-stack { height: 260px; margin-top: 1rem; }
                .features { grid-template-columns: 1fr; }
                .stats-grid { grid-template-columns: 1fr; gap: 1.5rem; }
            }

            @media (max-width: 560px) {
                .hero-section { padding: 140px 1.25rem 64px; }
                .hero-title { font-size: 2.1rem; }
                .hero-subtitle { font-size: 1rem; }
                .cta-buttons { flex-direction: column; }
                .btn-primary-custom, .btn-outline-custom { justify-content: center; }
            }
        </style>
    </head>
    <body>
        <!-- Navigation -->
        <nav class="navbar">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <img src="{{ asset('assets/images/bpjs1.png') }}" alt="BPJS Inventory">
                </a>

                @if (Route::has('login'))
                    <div>
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn-login">
                                <i class="fas fa-tachometer-alt me-2"></i>&nbsp;Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn-login">
                                <i class="fas fa-sign-in-alt me-2"></i>&nbsp;Masuk
                            </a>
                        @endauth
                    </div>
                @endif
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="hero-section">
            <div class="hero-inner">
                <div>
                    <span class="eyebrow">Sistem Manajemen Inventori</span>
                    <h1 class="hero-title">
                        Setiap barang tercatat,<br>
                        setiap alur <span class="highlight">jadi jelas</span>.
                    </h1>
                    <p class="hero-subtitle">
                        BPJS Inventory membantu Anda mengelola stok barang, melacak pengambilan,
                        dan mengatur pengajuan &mdash; semua dalam satu sistem yang rapi dan mudah dipakai.
                    </p>

                    <div class="cta-buttons">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn-primary-custom">
                                <i class="fas fa-tachometer-alt me-2"></i>&nbsp;Buka Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn-primary-custom">
                                <i class="fas fa-sign-in-alt me-2"></i>&nbsp;Mulai Sekarang
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn-outline-custom">
                                    <i class="fas fa-user-plus me-2"></i>&nbsp;Daftar Akun
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>

                <div class="tag-stack">
                    <div class="inv-tag inv-tag-back">
                        <div class="inv-tag-code">SKU / BPJS-INV-0182</div>
                        <div class="inv-tag-name">Kertas A4 80gsm</div>
                        <span class="inv-tag-status status-ok">Tersedia</span>
                        <div class="inv-tag-barcode">
                            <span style="height:60%"></span><span style="height:90%"></span><span style="height:40%"></span><span style="height:75%"></span><span style="height:55%"></span><span style="height:95%"></span><span style="height:35%"></span><span style="height:80%"></span><span style="height:50%"></span><span style="height:70%"></span>
                        </div>
                    </div>
                    <div class="inv-tag inv-tag-front">
                        <div class="inv-tag-code">SKU / BPJS-INV-0417</div>
                        <div class="inv-tag-name">Printer Laser</div>
                        <span class="inv-tag-status status-pending">Pengajuan</span>
                        <div class="inv-tag-barcode">
                            <span style="height:80%"></span><span style="height:45%"></span><span style="height:95%"></span><span style="height:30%"></span><span style="height:65%"></span><span style="height:50%"></span><span style="height:85%"></span><span style="height:40%"></span><span style="height:70%"></span><span style="height:55%"></span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features -->
        <section class="features-section">
            <div class="features">
                <div class="feature-item">
                    <i class="fas fa-box"></i>
                    <h5>Kelola Barang</h5>
                    <p>Manajemen inventori yang mudah dan efisien, dari stok masuk sampai keluar.</p>
                </div>
                <div class="feature-item">
                    <i class="fas fa-handshake"></i>
                    <h5>Lacak Barang</h5>
                    <p>Pantau setiap pengambilan barang secara real-time, tanpa catatan manual.</p>
                </div>
                <div class="feature-item">
                    <i class="fas fa-clipboard-list"></i>
                    <h5>Pengajuan</h5>
                    <p>Ajukan kebutuhan barang lewat alur yang terstruktur dan mudah dipantau.</p>
                </div>
            </div>
        </section>

        <!-- Corporate / stats -->
        <section class="corporate-section">
            <div class="corporate-content">
                <h2 class="corporate-title">Satu sistem, seluruh inventori</h2>
                <p class="corporate-description">
                    BPJS Inventory dirancang untuk menyederhanakan pengelolaan barang di lingkungan kerja Anda,
                    dari pencatatan stok sampai persetujuan pengajuan.
                </p>
                <div class="stats-grid">
                    <div class="stat-item">
                        <span class="stat-number">100%</span>
                        <span class="stat-label">Tercatat Digital</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">24/7</span>
                        <span class="stat-label">Akses Sistem</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">3</span>
                        <span class="stat-label">Alur Utama</span>
                    </div>
                </div>
            </div>
        </section>

        <footer class="site-footer">
            &copy; {{ date('Y') }} BPJS Inventory. Seluruh hak cipta dilindungi.
        </footer>
    </body>
</html>
