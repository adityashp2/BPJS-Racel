<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'BPJS Inventory') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&family=IBM+Plex+Mono:wght@500;600&display=swap" rel="stylesheet">

        <!-- Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Styles -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <style>
            :root {
                --ink: #101B2D;
                --ink-soft: #4B5768;
                --paper: #F4F5F8;
                --surface: #ffffff;
                --accent: #FF6A3D;
                --accent-ink: #C74E22;
                --accent-2: #12805C;
                --info-color: #2F6FB0;
                --warning-color: #F2A93B;
                --danger-color: #D64545;
                --line: #E1E4EA;
                --sidebar-width: 250px;
                --header-height: 60px;
                --transition-speed: 0.3s;
            }

            html, body {
                height: 100%;
                margin: 0;
                padding: 0;
                overflow-x: hidden;
            }

            body {
                font-family: 'Inter', sans-serif;
                background-color: var(--paper);
                color: var(--ink);
            }

            /* Sidebar */
            .sidebar {
                position: fixed;
                width: var(--sidebar-width);
                height: 100vh;
                top: 0;
                left: 0;
                background: linear-gradient(165deg, #101B2D 0%, #0A1220 100%);
                color: white;
                transition: all var(--transition-speed);
                z-index: 1000;
                box-shadow: 0 0 20px rgba(0,0,0,0.15);
                overflow-y: auto;
            }

            .sidebar.collapsed {
                width: 70px;
            }

            .sidebar-header {
                padding: 22px 20px;
                text-align: center;
                border-bottom: 1px solid rgba(255,255,255,0.08);
            }

            .sidebar-brand {
                font-family: 'Space Grotesk', sans-serif;
                font-size: 19px;
                font-weight: 700;
                color: white;
                text-decoration: none;
                display: flex;
                align-items: center;
                justify-content: center;
                letter-spacing: -0.01em;
            }

            .sidebar-brand i {
                margin-right: 10px;
                color: var(--accent);
            }

            .sidebar.collapsed .sidebar-brand span {
                display: none;
            }

            .sidebar.collapsed .sidebar-brand {
                justify-content: center;
            }

            .sidebar.collapsed .sidebar-brand i {
                margin-right: 0;
            }

            .sidebar-nav {
                padding: 20px 0;
            }

            .nav-item {
                margin-bottom: 3px;
            }

            .nav-link {
                padding: 11px 20px;
                color: rgba(255,255,255,0.65);
                text-decoration: none;
                display: flex;
                align-items: center;
                transition: all 0.2s;
                border-radius: 8px;
                margin: 0 10px;
                border-left: 3px solid transparent;
                font-size: 0.92rem;
            }

            .nav-link:hover {
                background-color: rgba(255,255,255,0.06);
                color: white;
            }

            .nav-link.active {
                background-color: rgba(255,106,61,0.14);
                color: white;
                border-left: 3px solid var(--accent);
            }

            .nav-link i {
                margin-right: 10px;
                min-width: 25px;
                text-align: center;
            }

            .sidebar.collapsed .nav-link span {
                display: none;
            }

            .sidebar.collapsed .nav-link {
                justify-content: center;
                padding: 12px 0;
            }

            .sidebar.collapsed .nav-link i {
                margin-right: 0;
            }

            .nav-divider {
                height: 1px;
                background-color: rgba(255,255,255,0.08);
                margin: 15px 20px;
            }

            /* Header */
            .header {
                position: fixed;
                top: 0;
                left: var(--sidebar-width);
                right: 0;
                height: var(--header-height);
                background-color: var(--surface);
                border-bottom: 1px solid var(--line);
                box-shadow: 0 2px 5px rgba(16,27,45,0.03);
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 0 30px;
                transition: left var(--transition-speed);
                z-index: 999;
            }

            .header.full-width {
                left: 70px;
            }

            .toggle-sidebar {
                cursor: pointer;
                color: var(--ink);
                font-size: 18px;
            }

            .search-box {
                position: relative;
                flex: 1;
                max-width: 400px;
                margin: 0 20px;
            }

            .search-box input {
                width: 100%;
                padding: 8px 15px 8px 40px;
                border-radius: 50px;
                border: 1px solid var(--line);
                background-color: var(--paper);
                font-size: 14px;
                font-family: 'Inter', sans-serif;
                transition: border-color 0.2s ease;
            }

            .search-box input:focus {
                outline: none;
                border-color: var(--accent);
                background-color: var(--surface);
            }

            .search-box i {
                position: absolute;
                left: 15px;
                top: 50%;
                transform: translateY(-50%);
                color: #a3aab5;
            }

            .user-menu {
                display: flex;
                align-items: center;
            }

            .notification {
                position: relative;
                margin-right: 20px;
                cursor: pointer;
            }

            .notification i {
                font-size: 20px;
                color: var(--ink-soft);
            }

            .notification .badge {
                position: absolute;
                top: -5px;
                right: -5px;
                padding: 2px 5px;
                border-radius: 50%;
                background-color: var(--accent);
                color: white;
                font-size: 10px;
                box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            }

            .user-profile {
                display: flex;
                align-items: center;
                cursor: pointer;
            }

            .user-img {
                width: 36px;
                height: 36px;
                border-radius: 50%;
                overflow: hidden;
                margin-right: 10px;
                cursor: pointer;
                border: 1px solid var(--line);
            }

            .dropdown-menu {
                padding: 0.5rem 0;
                box-shadow: 0 10px 30px rgba(16,27,45,0.12);
                border: 1px solid var(--line);
                border-radius: 10px;
            }

            .dropdown-item {
                padding: 0.6rem 1.2rem;
                font-size: 0.9rem;
                color: var(--ink);
                transition: all 0.2s;
            }

            .dropdown-item:hover {
                background-color: rgba(255,106,61,0.08);
                color: var(--accent-ink);
            }

            .dropdown-divider {
                margin: 0.3rem 0;
                border-top: 1px solid var(--line);
            }

            .user-img img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .user-info {
                line-height: 1.2;
            }

            .user-name {
                font-weight: 600;
                font-size: 14px;
                color: var(--ink);
            }

            .user-role {
                font-size: 12px;
                color: var(--ink-soft);
                text-transform: capitalize;
            }

            /* Main Content */
            .main-content {
                margin-left: var(--sidebar-width);
                margin-top: var(--header-height);
                padding: 30px;
                transition: margin-left var(--transition-speed);
                min-height: calc(100vh - var(--header-height));
            }

            .main-content.full-width {
                margin-left: 70px;
            }

            /* Dashboard Widgets */
            .stat-card {
                background-color: var(--surface);
                border: 1px solid var(--line);
                border-radius: 14px;
                padding: 20px;
                box-shadow: 0 4px 14px rgba(16,27,45,0.04);
                margin-bottom: 20px;
                transition: transform 0.2s, box-shadow 0.2s;
            }

            .stat-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 14px 30px rgba(16,27,45,0.08);
            }

            .card-icon {
                width: 48px;
                height: 48px;
                border-radius: 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 15px;
                font-size: 20px;
                color: white;
            }

            .card-icon.primary {
                background-color: var(--accent);
            }

            .card-icon.success {
                background-color: var(--accent-2);
            }

            .card-icon.warning {
                background-color: var(--warning-color);
            }

            .card-icon.info {
                background-color: var(--info-color);
            }

            .stat-card h3 {
                font-family: 'Space Grotesk', sans-serif;
                font-size: 24px;
                font-weight: 700;
                margin-bottom: 5px;
                color: var(--ink);
            }

            .stat-card p {
                color: var(--ink-soft);
                margin-bottom: 0;
                font-size: 14px;
            }

            /* Cards (used across the app) */
            .card {
                border: 1px solid var(--line);
                border-radius: 14px;
                box-shadow: 0 4px 14px rgba(16,27,45,0.04);
            }

            .card-header {
                border-bottom: 1px solid var(--line);
                border-radius: 14px 14px 0 0 !important;
            }

            .card-title {
                font-family: 'Space Grotesk', sans-serif;
                font-weight: 600;
                color: var(--ink);
            }

            .table thead.table-light th {
                background: var(--paper);
                font-family: 'IBM Plex Mono', monospace;
                font-size: 0.72rem;
                letter-spacing: 0.04em;
                text-transform: uppercase;
                color: var(--ink-soft);
                border-bottom: 1px solid var(--line);
                font-weight: 600;
            }

            /* Footer */
            .footer {
                background-color: var(--surface);
                padding: 15px 30px;
                margin-left: var(--sidebar-width);
                transition: margin-left var(--transition-speed);
                border-top: 1px solid var(--line);
                color: var(--ink-soft);
                font-size: 0.85rem;
            }

            .footer.full-width {
                margin-left: 70px;
            }

            /* Responsive */
            @media (max-width: 991px) {
                .sidebar {
                    transform: translateX(-100%);
                }

                .sidebar.mobile-active {
                    transform: translateX(0);
                }

                .header, .main-content, .footer {
                    left: 0;
                    margin-left: 0;
                }

                .mobile-overlay {
                    position: fixed;
                    top: 0;
                    left: 0;
                    right: 0;
                    bottom: 0;
                    background-color: rgba(16,27,45,0.5);
                    z-index: 999;
                    display: none;
                }

                .mobile-overlay.active {
                    display: block;
                }
            }

            /* Status badges */
            .badge-status {
                padding: 0.35rem 0.65rem;
                border-radius: 50px;
                font-size: 0.75rem;
                font-weight: 500;
                display: inline-block;
                text-align: center;
                white-space: nowrap;
                vertical-align: middle;
            }

            .badge-status.in-stock {
                background-color: var(--accent-2);
                color: white;
            }

            /* Custom status badges */
            .status-badge {
                padding: 0.35rem 0.65rem;
                border-radius: 30px;
                font-size: 0.75rem;
                font-weight: 500;
                display: inline-block;
            }

            .status-badge.in-stock {
                background-color: var(--accent-2);
                color: white;
                padding: 0.35rem 0.8rem;
                border-radius: 30px;
                font-size: 0.75rem;
                font-weight: 600;
            }

            /* Override Bootstrap badge/button colors for our palette */
            .bg-success { background-color: var(--accent-2) !important; }
            .bg-primary { background-color: var(--accent) !important; }
            .bg-danger  { background-color: var(--danger-color) !important; }
            .bg-warning { background-color: var(--warning-color) !important; }

            .btn-primary {
                background-color: var(--accent);
                border-color: var(--accent);
            }
            .btn-primary:hover {
                background-color: var(--accent-ink);
                border-color: var(--accent-ink);
            }
            .btn-outline-primary {
                color: var(--accent);
                border-color: var(--accent);
            }
            .btn-outline-primary:hover {
                background-color: var(--accent);
                border-color: var(--accent);
                color: white;
            }
        </style>

        @stack('styles')
    </head>
    <body>
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <a href="{{ route('welcome') }}" class="sidebar-brand">
                    <i class="fas fa-boxes"></i>
                    <span>BPJS Inventory</span>
                </a>
            </div>

            <div class="sidebar-nav">
                <div class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </div>

                <div class="nav-item">
                    <a href="{{ route('items.item-gallery') }}" class="nav-link {{ request()->routeIs('items.item-gallery') ? 'active' : '' }}">
                        <i class="fas fa-th-large"></i>
                        <span>Galeri Barang</span>
                    </a>
                </div>

                <div class="nav-item">
                    <a href="{{ route('item-pickups.index') }}" class="nav-link {{ request()->routeIs('item-pickups.*') ? 'active' : '' }}">
                        <i class="fas fa-box"></i>
                        <span>Pengambilan</span>
                    </a>
                </div>

                <div class="nav-item">
                    <a href="{{ route('item-requests.index') }}" class="nav-link {{ request()->routeIs('item-requests.*') ? 'active' : '' }}">
                        <i class="fas fa-clipboard-list"></i>
                        <span>Pengajuan Barang</span>
                    </a>
                </div>

                @if (Auth::user()->role == 'admin')
                    <!-- Master Data -->
                    <div class="nav-divider"></div>

                    <div class="nav-item">
                        <a href="{{ route('items.index') }}" class="nav-link {{ request()->routeIs('items.*') ? 'active' : '' }}">
                            <i class="fas fa-box"></i>
                            <span>Barang</span>
                        </a>
                    </div>

                    <div class="nav-item">
                        <a href="{{ route('job-divisions.index') }}" class="nav-link {{ request()->routeIs('job-divisions.*') ? 'active' : '' }}">
                            <i class="fas fa-sitemap"></i>
                            <span>Divisi Bagian</span>
                        </a>
                    </div>

                    <div class="nav-item">
                        <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                            <i class="fas fa-user"></i>
                            <span>Pengguna</span>
                        </a>
                    </div>
                @endif
            </div>
        </aside>

        <!-- Mobile Overlay -->
        <div class="mobile-overlay" id="mobileOverlay"></div>

        <!-- Header -->
        <header class="header" id="header">
            <div class="toggle-sidebar" id="toggleSidebar">
                <i class="fas fa-bars"></i>
            </div>

            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Cari...">
            </div>

            <div class="user-menu z-2">
                <div class="user-profile dropdown">
                    <a href="#" class="dropdown-toggle d-flex align-items-center" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-img">
                            <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="User" onerror="this.onerror=null; this.src='{{ asset('assets/images/users/default.png') }}'">
                        </div>
                        <div class="user-info d-none d-md-block">
                            <div class="user-name">{{ Auth::user()->name }}</div>
                            <div class="user-role">{{ Auth::user()->role }}</div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li>
                            <a href="{{ route('users.profile') }}" class="dropdown-item">
                                <i class="fas fa-user me-2"></i> Profile
                            </a>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                @csrf
                                <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                </a>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="main-content" id="mainContent">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="footer" id="footer">
            <div class="text-center">
                &copy; {{ date('Y') }} {{ config('app.name', 'BPJS Inventory') }}. Seluruh hak cipta dilindungi.
            </div>
        </footer>

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const sidebar = document.getElementById('sidebar');
                const header = document.getElementById('header');
                const mainContent = document.getElementById('mainContent');
                const footer = document.getElementById('footer');
                const toggleSidebar = document.getElementById('toggleSidebar');
                const mobileOverlay = document.getElementById('mobileOverlay');

                // Enable all dropdowns
                var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'))
                var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
                    return new bootstrap.Dropdown(dropdownToggleEl)
                });

                // Toggle sidebar
                toggleSidebar.addEventListener('click', function() {
                    if (window.innerWidth > 991) {
                        sidebar.classList.toggle('collapsed');
                        header.classList.toggle('full-width');
                        mainContent.classList.toggle('full-width');
                        footer.classList.toggle('full-width');
                    } else {
                        sidebar.classList.toggle('mobile-active');
                        mobileOverlay.classList.toggle('active');
                    }
                });

                // Close sidebar when clicking overlay
                mobileOverlay.addEventListener('click', function() {
                    sidebar.classList.remove('mobile-active');
                    mobileOverlay.classList.remove('active');
                });

                // Resize handling
                window.addEventListener('resize', function() {
                    if (window.innerWidth <= 991) {
                        sidebar.classList.remove('collapsed');
                        header.classList.remove('full-width');
                        mainContent.classList.remove('full-width');
                        footer.classList.remove('full-width');
                    }
                });
            });
        </script>

        @stack('scripts')
    </body>
</html>
