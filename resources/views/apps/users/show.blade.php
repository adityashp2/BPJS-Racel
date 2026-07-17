@extends('layouts.app')

@push('styles')
<style>
    /* ===== KONSISTENSI DENGAN DESAIN SEBELUMNYA ===== */
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

    h1 {
        font-family: 'Space Grotesk', sans-serif;
        font-weight: 700;
        color: var(--ink);
        font-size: 1.9rem;
    }

    .text-muted {
        color: var(--ink-soft) !important;
    }

    /* ===== CARDS ===== */
    .card {
        border: 1px solid var(--line);
        border-radius: 14px;
        box-shadow: 0 4px 14px rgba(16, 27, 45, 0.04);
        transition: box-shadow 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 8px 24px rgba(16, 27, 45, 0.08);
    }

    .card-header {
        background: var(--surface);
        border-bottom: 1px solid var(--line);
        padding: 1rem 1.25rem;
    }

    .card-header h5 {
        font-family: 'Space Grotesk', sans-serif;
        font-weight: 600;
        color: var(--ink);
        margin-bottom: 0;
    }

    .card-body {
        padding: 1.5rem;
    }

    /* ===== BUTTONS ===== */
    .btn {
        font-weight: 600;
        border-radius: 9px;
        padding: 0.6rem 1.2rem;
        font-size: 0.9rem;
        transition: all 0.2s ease;
    }

    .btn-warning {
        background: #F2A93B;
        border-color: #F2A93B;
        color: var(--ink);
    }

    .btn-warning:hover {
        background: #d99a2e;
        border-color: #d99a2e;
        color: var(--ink);
        transform: translateY(-1px);
        box-shadow: 0 8px 20px rgba(242, 169, 59, 0.25);
    }

    .btn-outline-primary {
        color: var(--accent);
        border-color: var(--accent);
    }

    .btn-outline-primary:hover {
        background: var(--accent);
        border-color: var(--accent);
        color: #fff;
        transform: translateY(-1px);
    }

    .btn-info {
        background: #2F6FB0;
        border-color: #2F6FB0;
        color: #fff;
    }

    .btn-info:hover {
        background: #1f5a8f;
        border-color: #1f5a8f;
        color: #fff;
        transform: translateY(-1px);
    }

    /* ===== TABLE ===== */
    .table {
        margin-bottom: 0;
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
        padding: 0.9rem 1rem;
        border-top: none;
    }

    .table tbody td {
        padding: 0.9rem 1rem;
        vertical-align: middle;
        border-bottom: 1px solid var(--line);
        color: var(--ink);
    }

    .table tbody tr:hover {
        background-color: rgba(255, 106, 61, 0.04);
    }

    .table tbody tr:last-child td {
        border-bottom: none;
    }

    /* ===== BADGES ===== */
    .badge {
        font-weight: 600;
        padding: 0.35rem 0.7rem;
        border-radius: 6px;
        font-size: 0.75rem;
    }

    .badge.bg-danger {
        background-color: var(--danger) !important;
        color: #fff !important;
    }

    .badge.bg-primary {
        background-color: var(--accent) !important;
        color: #fff !important;
    }

    .badge.bg-success {
        background-color: var(--accent-2) !important;
        color: #fff !important;
    }

    .badge.bg-warning {
        background-color: #F2A93B !important;
        color: var(--ink) !important;
    }

    /* ===== USER PROFILE ===== */
    .profile-avatar {
        position: relative;
        width: 120px;
        height: 120px;
        margin: 0 auto 1rem;
    }

    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid var(--surface);
        box-shadow: 0 4px 14px rgba(16, 27, 45, 0.12);
    }

    .profile-avatar .avatar-placeholder {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--paper);
        border: 4px solid var(--surface);
        box-shadow: 0 4px 14px rgba(16, 27, 45, 0.12);
        font-size: 3.5rem;
        font-weight: 700;
        color: var(--ink-soft);
    }

    .profile-avatar .online-status {
        position: absolute;
        bottom: 4px;
        right: 4px;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background: var(--accent-2);
        border: 3px solid var(--surface);
    }

    .profile-avatar .online-status.offline {
        background: var(--ink-soft);
    }

    .profile-name {
        font-family: 'Space Grotesk', sans-serif;
        font-weight: 700;
        color: var(--ink);
        font-size: 1.25rem;
        text-align: center;
        margin-bottom: 0.25rem;
    }

    .profile-email {
        text-align: center;
        color: var(--ink-soft);
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .profile-role {
        text-align: center;
        margin-bottom: 1.5rem;
    }

    /* ===== INFO ITEMS ===== */
    .info-item {
        display: flex;
        justify-content: space-between;
        padding: 0.6rem 0;
        border-bottom: 1px solid rgba(225, 228, 234, 0.5);
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-item .info-label {
        font-weight: 600;
        color: var(--ink-soft);
        font-size: 0.85rem;
    }

    .info-item .info-label i {
        color: var(--accent);
        width: 1.2rem;
        margin-right: 0.25rem;
    }

    .info-item .info-value {
        color: var(--ink);
        font-weight: 500;
        font-size: 0.9rem;
    }

    /* ===== STATISTICS ===== */
    .stat-box {
        background: var(--paper);
        border-radius: 9px;
        padding: 1rem;
        text-align: center;
        border: 1px solid var(--line);
        transition: all 0.3s ease;
    }

    .stat-box:hover {
        border-color: var(--accent);
        box-shadow: 0 4px 12px rgba(255, 106, 61, 0.08);
    }

    .stat-box .stat-number {
        font-family: 'Space Grotesk', sans-serif;
        font-weight: 700;
        font-size: 1.5rem;
        color: var(--accent);
    }

    .stat-box .stat-label {
        font-size: 0.75rem;
        color: var(--ink-soft);
        text-transform: uppercase;
        letter-spacing: 0.04em;
        margin-top: 0.2rem;
    }

    /* ===== EMPTY STATE ===== */
    .empty-state {
        padding: 3rem 2rem;
        text-align: center;
    }

    .empty-state i {
        color: var(--line);
        margin-bottom: 1rem;
        display: block;
    }

    .empty-state h5 {
        font-family: 'Space Grotesk', sans-serif;
        font-weight: 600;
        color: var(--ink);
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: var(--ink-soft);
        margin-bottom: 0;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        h1 {
            font-size: 1.5rem;
        }

        .card-body {
            padding: 1rem;
        }

        .btn {
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
        }

        .d-flex.justify-content-between.align-items-center {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 1rem;
        }

        .d-flex.justify-content-between.align-items-center > div {
            width: 100%;
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .d-flex.justify-content-between.align-items-center .btn {
            flex: 1;
            min-width: 100px;
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
        }

        .profile-avatar .avatar-placeholder {
            font-size: 2.8rem;
        }

        .table thead.table-light th {
            font-size: 0.65rem;
            padding: 0.6rem 0.5rem;
        }

        .table tbody td {
            padding: 0.6rem 0.5rem;
            font-size: 0.85rem;
        }

        .stat-box .stat-number {
            font-size: 1.25rem;
        }

        .info-item {
            flex-direction: column;
            gap: 0.25rem;
        }
    }

    @media (max-width: 576px) {
        .container-fluid {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }

        .profile-avatar {
            width: 80px;
            height: 80px;
        }

        .profile-avatar .avatar-placeholder {
            font-size: 2.2rem;
        }

        .empty-state {
            padding: 2rem 1rem;
        }

        .empty-state i {
            font-size: 3rem !important;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- ===== HEADER ===== -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <div>
                    <h1>
                        <i class="fas fa-user-circle me-2" style="color: var(--accent);"></i>
                        Detail Pengguna
                    </h1>
                    <p class="text-muted mb-0">Informasi lengkap tentang pengguna</p>
                </div>
                <div class="mt-2 mt-md-0">
                    <a href="{{ route('users.edit', $user) }}" class="btn btn-warning me-2">
                        <i class="fas fa-edit me-1"></i> Edit Pengguna
                    </a>
                    <a href="{{ route('users.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== MAIN CONTENT ===== -->
    <div class="row">
        <!-- ===== LEFT COLUMN: PROFILE ===== -->
        <div class="col-lg-4 mb-4">
            <div class="card">
                <div class="card-header bg-white">
                    <h5>
                        <i class="fas fa-id-card me-2" style="color: var(--accent);"></i>
                        Profil Pengguna
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Profile Avatar -->
                    <div class="profile-avatar">
                        @if($user->photo)
                        <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->name }}">
                        @else
                        <div class="avatar-placeholder">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        @endif
                        <div class="online-status {{ $user->email_verified_at ? '' : 'offline' }}"></div>
                    </div>

                    <!-- Profile Info -->
                    <div class="profile-name">{{ $user->name }}</div>
                    <div class="profile-email">{{ $user->email }}</div>
                    <div class="profile-role">
                        @if($user->role === 'admin')
                        <span class="badge bg-danger">
                            <i class="fas fa-shield-alt me-1"></i>
                            Admin
                        </span>
                        @else
                        <span class="badge bg-primary">
                            <i class="fas fa-user me-1"></i>
                            User
                        </span>
                        @endif
                    </div>

                    <!-- Statistics -->
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <div class="stat-box">
                                <div class="stat-number">{{ $user->itemPickups ? $user->itemPickups->count() : 0 }}</div>
                                <div class="stat-label">Total Pengambilan</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-box">
                                <div class="stat-number">{{ $user->itemRequests ? $user->itemRequests->count() : 0 }}</div>
                                <div class="stat-label">Total Pengajuan</div>
                            </div>
                        </div>
                    </div>

                    <!-- Information -->
                    <div class="info-item">
                        <span class="info-label">
                            <i class="fas fa-envelope"></i>
                            Email
                        </span>
                        <span class="info-value">{{ $user->email }}</span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">
                            <i class="fas fa-building"></i>
                            Divisi Pekerjaan
                        </span>
                        <span class="info-value">
                            @if($user->jobDivision)
                            {{ $user->jobDivision->name }}
                            @else
                            <span class="text-muted">Belum ditugaskan</span>
                            @endif
                        </span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">
                            <i class="fas fa-check-circle"></i>
                            Status Verifikasi
                        </span>
                        <span class="info-value">
                            @if($user->email_verified_at)
                            <span class="badge bg-success">
                                <i class="fas fa-check-circle me-1"></i>
                                Terverifikasi
                            </span>
                            @else
                            <span class="badge bg-warning">
                                <i class="fas fa-clock me-1"></i>
                                Belum Verifikasi
                            </span>
                            @endif
                        </span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">
                            <i class="fas fa-calendar-plus"></i>
                            Bergabung Sejak
                        </span>
                        <span class="info-value">
                            {{ $user->created_at->format('d M Y') }}
                            <small class="text-muted d-block">{{ $user->created_at->diffForHumans() }}</small>
                        </span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">
                            <i class="fas fa-clock"></i>
                            Terakhir Diperbarui
                        </span>
                        <span class="info-value">
                            {{ $user->updated_at->format('d M Y H:i') }}
                            <small class="text-muted d-block">{{ $user->updated_at->diffForHumans() }}</small>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== RIGHT COLUMN: HISTORY ===== -->
        <div class="col-lg-8">
            <!-- ===== PICKUP HISTORY ===== -->
            <div class="card mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5>
                        <i class="fas fa-box me-2" style="color: var(--accent);"></i>
                        Riwayat Pengambilan
                    </h5>
                    <span class="badge bg-primary">{{ $user->itemPickups ? $user->itemPickups->count() : 0 }}</span>
                </div>
                <div class="card-body p-0">
                    @if($user->itemPickups && $user->itemPickups->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Nama Barang</th>
                                    <th class="text-center">Jumlah</th>
                                    <th>Tanggal Pengambilan</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user->itemPickups as $pickup)
                                <tr>
                                    <td>
                                        <div class="fw-bold">{{ $pickup->item->name }}</div>
                                        <small class="text-muted">Kode: {{ $pickup->item->code }}</small>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-info">
                                            <i class="fas fa-hashtag me-1"></i>
                                            {{ $pickup->quantity }}
                                        </span>
                                    </td>
                                    <td>
                                        <div>{{ $pickup->taken_date->format('d M Y') }}</div>
                                        <small class="text-muted">{{ $pickup->taken_date->diffForHumans() }}</small>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('item-pickups.show', $pickup) }}"
                                           class="btn btn-sm btn-info"
                                           title="Lihat Detail Pengambilan">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="empty-state">
                        <i class="fas fa-box fa-3x"></i>
                        <h5>Belum ada riwayat pengambilan</h5>
                        <p>Pengguna ini belum mengambil barang apapun</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- ===== REQUEST HISTORY ===== -->
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5>
                        <i class="fas fa-clipboard-list me-2" style="color: var(--accent);"></i>
                        Riwayat Pengajuan
                    </h5>
                    <span class="badge bg-primary">{{ $user->itemRequests ? $user->itemRequests->count() : 0 }}</span>
                </div>
                <div class="card-body p-0">
                    @if($user->itemRequests && $user->itemRequests->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Status</th>
                                    <th>Tanggal Pengajuan</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user->itemRequests as $request)
                                <tr>
                                    <td>
                                        <div class="fw-bold">{{ $request->name }}</div>
                                        <small class="text-muted">{{ Str::limit($request->description, 30) }}</small>
                                    </td>
                                    <td>
                                        @if($request->status == 'pending')
                                        <span class="badge bg-warning">
                                            <i class="fas fa-clock me-1"></i>Menunggu
                                        </span>
                                        @elseif($request->status == 'approved')
                                        <span class="badge bg-success">
                                            <i class="fas fa-check me-1"></i>Disetujui
                                        </span>
                                        @elseif($request->status == 'rejected')
                                        <span class="badge bg-danger">
                                            <i class="fas fa-times me-1"></i>Ditolak
                                        </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div>{{ $request->request_date->format('d M Y') }}</div>
                                        <small class="text-muted">{{ $request->request_date->diffForHumans() }}</small>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('item-requests.show', $request) }}"
                                           class="btn btn-sm btn-info"
                                           title="Lihat Detail Pengajuan">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="empty-state">
                        <i class="fas fa-clipboard-list fa-3x"></i>
                        <h5>Belum ada riwayat pengajuan</h5>
                        <p>Pengguna ini belum mengajukan barang apapun</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
