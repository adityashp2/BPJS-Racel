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

    /* ===== ALERTS ===== */
    .alert {
        border-radius: 10px;
        border: 1px solid transparent;
        font-size: 0.92rem;
    }

    .alert-success {
        background: rgba(18, 128, 92, 0.10);
        color: var(--accent-2);
        border-color: rgba(18, 128, 92, 0.25);
    }

    .alert-danger {
        background: rgba(214, 69, 69, 0.10);
        color: var(--danger);
        border-color: rgba(214, 69, 69, 0.25);
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
        padding: 0;
    }

    .card-footer {
        background: var(--surface);
        border-top: 1px solid var(--line);
        padding: 1rem 1.25rem;
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

    .badge.bg-primary {
        background-color: var(--accent) !important;
        color: #fff !important;
    }

    .badge.bg-info {
        background-color: #2F6FB0 !important;
        color: #fff !important;
    }

    .badge.bg-success {
        background-color: var(--accent-2) !important;
        color: #fff !important;
    }

    /* ===== BUTTONS ===== */
    .btn {
        font-weight: 600;
        border-radius: 9px;
        padding: 0.6rem 1.2rem;
        font-size: 0.9rem;
        transition: all 0.2s ease;
    }

    .btn-primary {
        background: var(--accent);
        border-color: var(--accent);
        color: #fff;
    }

    .btn-primary:hover {
        background: var(--accent-ink);
        border-color: var(--accent-ink);
        transform: translateY(-1px);
        box-shadow: 0 8px 20px rgba(255, 106, 61, 0.25);
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

    .btn-outline-secondary {
        color: var(--ink-soft);
        border-color: var(--line);
    }

    .btn-outline-secondary:hover {
        background: var(--paper);
        border-color: var(--line);
        color: var(--ink);
        transform: translateY(-1px);
    }

    /* ===== ACTION BUTTONS ===== */
    .btn-group .btn {
        padding: 0.35rem 0.6rem;
        font-size: 0.8rem;
        border-radius: 6px;
    }

    .btn-group .btn:first-child {
        border-radius: 6px 0 0 6px;
    }

    .btn-group .btn:last-child {
        border-radius: 0 6px 6px 0;
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
    }

    .btn-danger {
        background: var(--danger);
        border-color: var(--danger);
        color: #fff;
    }

    .btn-danger:hover {
        background: #b83a3a;
        border-color: #b83a3a;
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 8px 20px rgba(214, 69, 69, 0.25);
    }

    /* ===== FORM CONTROLS ===== */
    .form-control {
        border: 1px solid var(--line);
        border-radius: 9px;
        padding: 0.6rem 0.9rem;
        font-family: 'Inter', sans-serif;
        font-size: 0.9rem;
        color: var(--ink);
        background: var(--surface);
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .form-control:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(255, 106, 61, 0.15);
        outline: none;
    }

    .form-control::placeholder {
        color: var(--ink-soft);
        opacity: 0.6;
    }

    /* ===== MODAL ===== */
    .modal-content {
        border-radius: 14px;
        border: 1px solid var(--line);
    }

    .modal-header {
        border-bottom: 1px solid var(--line);
        padding: 1.25rem 1.5rem;
    }

    .modal-header .modal-title {
        font-family: 'Space Grotesk', sans-serif;
        font-weight: 600;
        color: var(--ink);
    }

    .modal-body {
        padding: 1.5rem;
    }

    .modal-footer {
        border-top: 1px solid var(--line);
        padding: 1rem 1.5rem;
    }

    .modal-footer .btn-secondary {
        background: var(--surface);
        border-color: var(--line);
        color: var(--ink-soft);
    }

    .modal-footer .btn-secondary:hover {
        background: var(--paper);
    }

    /* ===== PAGINATION ===== */
    .pagination .page-link {
        color: var(--ink);
        border-color: var(--line);
        padding: 0.5rem 0.9rem;
        font-size: 0.85rem;
        border-radius: 6px;
        margin: 0 2px;
        transition: all 0.2s ease;
    }

    .pagination .page-link:hover {
        color: var(--accent-ink);
        background: var(--paper);
        border-color: var(--line);
    }

    .pagination .page-item.active .page-link {
        background-color: var(--accent);
        border-color: var(--accent);
        color: #fff;
    }

    .pagination .page-item.disabled .page-link {
        color: var(--ink-soft);
        opacity: 0.5;
    }

    /* ===== EMPTY STATE ===== */
    .empty-state {
        padding: 4rem 2rem;
        text-align: center;
    }

    .empty-state i {
        color: var(--line);
        margin-bottom: 1.5rem;
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
        margin-bottom: 1.5rem;
    }

    /* ===== DIVISION BADGE ===== */
    .division-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--paper);
        padding: 0.2rem 0.8rem;
        border-radius: 20px;
        border: 1px solid var(--line);
        font-weight: 600;
        color: var(--ink);
    }

    .division-badge i {
        color: var(--accent);
        font-size: 0.8rem;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        h1 {
            font-size: 1.5rem;
        }

        .btn {
            padding: 0.4rem 0.8rem;
            font-size: 0.8rem;
        }

        .table thead.table-light th {
            font-size: 0.65rem;
            padding: 0.6rem 0.5rem;
        }

        .table tbody td {
            padding: 0.6rem 0.5rem;
            font-size: 0.85rem;
        }

        .card-header {
            flex-direction: column;
            gap: 1rem;
        }

        .card-header .d-flex {
            width: 100%;
        }

        .card-header form {
            width: 100%;
        }

        .card-header form .form-control {
            flex: 1;
        }

        .pagination .page-link {
            padding: 0.3rem 0.6rem;
            font-size: 0.75rem;
        }
    }

    @media (max-width: 576px) {
        .container-fluid {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
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
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h1>
                <i class="fas fa-sitemap me-2" style="color: var(--accent);"></i>
                Manajemen Divisi Pekerjaan
            </h1>
            <p class="text-muted mb-0">Kelola divisi pekerjaan yang ada di perusahaan</p>
        </div>
        <div class="mt-2 mt-md-0">
            <a href="{{ route('job-divisions.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Tambah Divisi Baru
            </a>
        </div>
    </div>

    <!-- ===== ALERTS ===== -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- ===== MAIN CARD ===== -->
    <div class="card">
        <div class="card-header bg-white d-flex flex-wrap justify-content-between align-items-center">
            <h5>
                <i class="fas fa-building me-2" style="color: var(--accent);"></i>
                Semua Divisi Pekerjaan
                <span class="badge bg-primary ms-2">{{ $jobDivisions->total() }}</span>
            </h5>
            <form action="{{ route('job-divisions.index') }}" method="GET" class="d-flex gap-2">
                <input type="text"
                       name="search"
                       class="form-control"
                       placeholder="Cari berdasarkan nama divisi..."
                       value="{{ request('search') }}">
                <button type="submit" class="btn btn-outline-primary">
                    <i class="fas fa-search"></i>
                </button>
                @if(request('search'))
                <a href="{{ route('job-divisions.index') }}" class="btn btn-outline-secondary" title="Hapus pencarian">
                    <i class="fas fa-times"></i>
                </a>
                @endif
            </form>
        </div>

        <div class="card-body p-0">
            @if($jobDivisions->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 25%;">Nama Divisi</th>
                            <th style="width: 45%;">Deskripsi</th>
                            <th style="width: 17%;">Dibuat Pada</th>
                            <th style="width: 13%;" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jobDivisions as $division)
                        <tr>
                            <td>
                                <div class="division-badge">
                                    <i class="fas fa-building"></i>
                                    {{ $division->name }}
                                </div>
                                @if($division->users_count)
                                <div class="mt-1">
                                    <small class="text-muted">
                                        <i class="fas fa-users me-1"></i>
                                        {{ $division->users_count }} karyawan
                                    </small>
                                </div>
                                @endif
                            </td>
                            <td>
                                @if($division->description)
                                {{ Str::limit($division->description, 80) }}
                                @if(strlen($division->description) > 80)
                                <span class="text-muted">...</span>
                                @endif
                                @else
                                <span class="text-muted">
                                    <i class="fas fa-minus-circle me-1"></i>
                                    Tidak ada deskripsi
                                </span>
                                @endif
                            </td>
                            <td>
                                <div>{{ $division->created_at->format('d M Y') }}</div>
                                <small class="text-muted">{{ $division->created_at->diffForHumans() }}</small>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('job-divisions.edit', $division) }}"
                                       class="btn btn-sm btn-warning"
                                       title="Edit Divisi">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button"
                                            class="btn btn-sm btn-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $division->id }}"
                                            title="Hapus Divisi">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>

                                <!-- ===== DELETE MODAL ===== -->
                                <div class="modal fade" id="deleteModal{{ $division->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">
                                                    <i class="fas fa-exclamation-triangle me-2" style="color: var(--danger);"></i>
                                                    Konfirmasi Hapus
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body text-start">
                                                <p>Apakah Anda yakin ingin menghapus divisi <strong>{{ $division->name }}</strong>?</p>
                                                <div class="alert alert-danger" role="alert">
                                                    <i class="fas fa-exclamation-circle me-2"></i>
                                                    Tindakan ini <strong>tidak dapat dibatalkan</strong>.
                                                    @if($division->users_count > 0)
                                                    <br><br>
                                                    <i class="fas fa-users me-1"></i>
                                                    Divisi ini memiliki <strong>{{ $division->users_count }}</strong> karyawan yang terdaftar.
                                                    @endif
                                                </div>
                                                <div class="bg-light rounded p-3">
                                                    <small class="text-muted">
                                                        <i class="fas fa-info-circle me-1"></i>
                                                        Nama Divisi: <strong>{{ $division->name }}</strong>
                                                        @if($division->created_at)
                                                        <span class="mx-2">|</span>
                                                        Dibuat: <strong>{{ $division->created_at->format('d M Y') }}</strong>
                                                        @endif
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    <i class="fas fa-times me-1"></i> Batal
                                                </button>
                                                <form action="{{ route('job-divisions.destroy', $division) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">
                                                        <i class="fas fa-trash me-1"></i> Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- ===== PAGINATION ===== -->
            <div class="card-footer bg-white">
                <div class="d-flex flex-wrap justify-content-between align-items-center">
                    <div class="text-muted mb-2 mb-md-0">
                        <i class="fas fa-database me-1"></i>
                        Menampilkan {{ $jobDivisions->firstItem() ?? 0 }}
                        sampai {{ $jobDivisions->lastItem() ?? 0 }}
                        dari {{ $jobDivisions->total() }} divisi
                    </div>
                    <div>
                        {{ $jobDivisions->withQueryString()->links() }}
                    </div>
                </div>
            </div>

            @else
            <!-- ===== EMPTY STATE ===== -->
            <div class="empty-state">
                <i class="fas fa-sitemap fa-4x"></i>
                <h5>Tidak ada divisi pekerjaan ditemukan</h5>
                @if(request('search'))
                <p>Tidak ada divisi yang sesuai dengan pencarian <strong>"{{ request('search') }}"</strong></p>
                <div>
                    <a href="{{ route('job-divisions.index') }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-times me-1"></i> Hapus Pencarian
                    </a>
                    <a href="{{ route('job-divisions.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Tambah Divisi Baru
                    </a>
                </div>
                @else
                <p>Mulai dengan menambahkan divisi pekerjaan pertama Anda</p>
                <a href="{{ route('job-divisions.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> Tambah Divisi Baru
                </a>
                @endif
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
