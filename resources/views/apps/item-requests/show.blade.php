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

    .card-header h5,
    .card-header h6 {
        font-family: 'Space Grotesk', sans-serif;
        font-weight: 600;
        color: var(--ink);
    }

    .card-body {
        padding: 1.5rem;
    }

    .card-footer {
        background: var(--surface);
        border-top: 1px solid var(--line);
    }

    /* ===== FORM LABELS ===== */
    .form-label {
        font-weight: 600;
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: var(--ink-soft);
        margin-bottom: 0.5rem;
    }

    .form-control-plaintext {
        border: 1px solid var(--line);
        border-radius: 9px;
        padding: 0.7rem 0.9rem;
        background: var(--paper) !important;
        color: var(--ink);
        font-size: 0.95rem;
        transition: all 0.2s ease;
    }

    .form-control-plaintext:hover {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(255, 106, 61, 0.08);
    }

    /* ===== BADGES ===== */
    .badge {
        font-weight: 600;
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
        font-size: 0.78rem;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    .badge.bg-warning {
        background-color: #F2A93B !important;
        color: var(--ink) !important;
    }

    .badge.bg-success {
        background-color: var(--accent-2) !important;
        color: #fff !important;
    }

    .badge.bg-danger {
        background-color: var(--danger) !important;
        color: #fff !important;
    }

    .badge.fs-6 {
        font-size: 0.85rem !important;
        padding: 0.5rem 1rem;
    }

    /* ===== BUTTONS ===== */
    .btn {
        font-weight: 600;
        border-radius: 9px;
        padding: 0.6rem 1.2rem;
        font-size: 0.9rem;
        transition: all 0.2s ease;
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

    .btn-danger {
        background: var(--danger);
        border-color: var(--danger);
        color: #fff;
    }

    .btn-danger:hover {
        background: #b83a3a;
        border-color: #b83a3a;
        transform: translateY(-1px);
        box-shadow: 0 8px 20px rgba(214, 69, 69, 0.25);
    }

    .btn-success {
        background: var(--accent-2);
        border-color: var(--accent-2);
        color: #fff;
    }

    .btn-success:hover {
        background: #0e6a4a;
        border-color: #0e6a4a;
        transform: translateY(-1px);
        box-shadow: 0 8px 20px rgba(18, 128, 92, 0.25);
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

    /* ===== ADMIN ACTION CARD ===== */
    .card-admin .card-header {
        background: var(--accent);
        color: #fff;
        border-bottom: none;
    }

    .card-admin .card-header h6 {
        color: #fff;
    }

    .card-admin .card-body {
        background: #fffaf8;
    }

    /* ===== DIVIDER ===== */
    .divider {
        border-top: 1px solid var(--line);
        margin: 1.5rem 0;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .card-body {
            padding: 1rem;
        }

        .btn {
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
        }

        h1 {
            font-size: 1.5rem;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- ===== HEADER ===== -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1>Detail Pengajuan Barang</h1>
            <p class="text-muted mb-0">Informasi lengkap pengajuan barang</p>
        </div>
        <div>
            <a href="{{ route('item-requests.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <!-- ===== MAIN CONTENT ===== -->
    <div class="row">
        <!-- ===== LEFT COLUMN ===== -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-clipboard-list me-2" style="color: var(--accent);"></i>
                            {{ $itemRequest->name }}
                        </h5>
                        <div>
                            @if($itemRequest->status == 'pending')
                            <span class="badge bg-warning fs-6">
                                <i class="fas fa-clock me-1"></i>Menunggu Persetujuan
                            </span>
                            @elseif($itemRequest->status == 'approved')
                            <span class="badge bg-success fs-6">
                                <i class="fas fa-check-circle me-1"></i>Disetujui
                            </span>
                            @elseif($itemRequest->status == 'rejected')
                            <span class="badge bg-danger fs-6">
                                <i class="fas fa-times-circle me-1"></i>Ditolak
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Nama Barang -->
                        <div class="col-md-6 mb-4">
                            <label class="form-label">
                                <i class="fas fa-box me-1"></i> Nama Barang
                            </label>
                            <div class="form-control-plaintext">
                                <strong>{{ $itemRequest->name }}</strong>
                            </div>
                        </div>

                        <!-- Tanggal Pengajuan -->
                        <div class="col-md-6 mb-4">
                            <label class="form-label">
                                <i class="fas fa-calendar me-1"></i> Tanggal Pengajuan
                            </label>
                            <div class="form-control-plaintext">
                                {{ $itemRequest->request_date->format('d M Y') }}
                                <small class="text-muted d-block">{{ $itemRequest->request_date->diffForHumans() }}</small>
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="col-12 mb-4">
                            <label class="form-label">
                                <i class="fas fa-align-left me-1"></i> Deskripsi Barang
                            </label>
                            <div class="form-control-plaintext" style="min-height: 120px; white-space: pre-wrap;">
                                {{ $itemRequest->description }}
                            </div>
                        </div>

                        <div class="divider"></div>

                        <!-- Status -->
                        <div class="col-md-6 mb-4">
                            <label class="form-label">
                                <i class="fas fa-tag me-1"></i> Status Pengajuan
                            </label>
                            <div class="form-control-plaintext">
                                @if($itemRequest->status == 'pending')
                                <span class="badge bg-warning me-2">
                                    <i class="fas fa-clock me-1"></i>Menunggu
                                </span>
                                <span class="text-muted">Pengajuan sedang menunggu persetujuan admin</span>
                                @elseif($itemRequest->status == 'approved')
                                <span class="badge bg-success me-2">
                                    <i class="fas fa-check me-1"></i>Disetujui
                                </span>
                                <span class="text-muted">Pengajuan telah disetujui</span>
                                @elseif($itemRequest->status == 'rejected')
                                <span class="badge bg-danger me-2">
                                    <i class="fas fa-times me-1"></i>Ditolak
                                </span>
                                <span class="text-muted">Pengajuan ditolak</span>
                                @endif
                            </div>
                        </div>

                        <!-- Pengaju -->
                        <div class="col-md-6 mb-4">
                            <label class="form-label">
                                <i class="fas fa-user me-1"></i> Pengaju
                            </label>
                            <div class="form-control-plaintext">
                                @if($itemRequest->requestedBy)
                                <div class="d-flex align-items-center">
                                    <div class="avatar-placeholder me-2"
                                         style="width: 36px; height: 36px; background: var(--accent); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700; font-size: 14px; flex-shrink: 0;">
                                        {{ strtoupper(substr($itemRequest->requestedBy->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold">{{ $itemRequest->requestedBy->name }}</div>
                                        <small class="text-muted">{{ $itemRequest->requestedBy->email }}</small>
                                        @if($itemRequest->requestedBy->jobDivision)
                                        <div class="text-muted small">{{ $itemRequest->requestedBy->jobDivision->name }}</div>
                                        @endif
                                    </div>
                                </div>
                                @else
                                <span class="text-muted">Tidak diketahui</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- ===== ACTION BUTTONS ===== -->
                    <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                        <a href="{{ route('item-requests.edit', $itemRequest) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-1"></i> Edit
                        </a>
                        <button type="button" class="btn btn-danger"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteModal">
                            <i class="fas fa-trash me-1"></i> Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== RIGHT COLUMN ===== -->
        <div class="col-lg-4">
            <!-- Informasi Tambahan -->
            <div class="card">
                <div class="card-header bg-white">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle me-2" style="color: var(--accent);"></i>
                        Informasi Tambahan
                    </h6>
                </div>
                <div class="card-body">
                    <!-- ID Pengajuan -->
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-hashtag me-1"></i> ID Pengajuan
                        </label>
                        <div class="form-control-plaintext">
                            <code style="background: var(--surface); padding: 0.2rem 0.5rem; border-radius: 4px; border: 1px solid var(--line);">
                                #{{ str_pad($itemRequest->id, 4, '0', STR_PAD_LEFT) }}
                            </code>
                        </div>
                    </div>

                    <!-- Dibuat -->
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-calendar-plus me-1"></i> Dibuat
                        </label>
                        <div class="form-control-plaintext">
                            {{ $itemRequest->created_at->format('d M Y H:i') }}
                            <small class="text-muted d-block">{{ $itemRequest->created_at->diffForHumans() }}</small>
                        </div>
                    </div>

                    <!-- Terakhir Diperbarui -->
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-clock me-1"></i> Terakhir Diperbarui
                        </label>
                        <div class="form-control-plaintext">
                            {{ $itemRequest->updated_at->format('d M Y H:i') }}
                            <small class="text-muted d-block">{{ $itemRequest->updated_at->diffForHumans() }}</small>
                        </div>
                    </div>

                    <!-- Status Card -->
                    <div class="mb-0">
                        <label class="form-label">
                            <i class="fas fa-tag me-1"></i> Status Saat Ini
                        </label>
                        <div class="form-control-plaintext text-center">
                            @if($itemRequest->status == 'pending')
                            <span class="badge bg-warning" style="font-size: 0.9rem; padding: 0.5rem 1.2rem;">
                                <i class="fas fa-clock me-1"></i> Menunggu
                            </span>
                            @elseif($itemRequest->status == 'approved')
                            <span class="badge bg-success" style="font-size: 0.9rem; padding: 0.5rem 1.2rem;">
                                <i class="fas fa-check me-1"></i> Disetujui
                            </span>
                            @elseif($itemRequest->status == 'rejected')
                            <span class="badge bg-danger" style="font-size: 0.9rem; padding: 0.5rem 1.2rem;">
                                <i class="fas fa-times me-1"></i> Ditolak
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- ===== ADMIN ACTION CARD ===== -->
            @if(Auth::user()->role == 'admin' && $itemRequest->status == 'pending')
            <div class="card mt-3 card-admin">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-gavel me-2"></i>
                        Aksi Admin
                    </h6>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">
                        <i class="fas fa-info-circle me-1"></i>
                        Sebagai admin, Anda dapat menyetujui atau menolak pengajuan ini.
                    </p>

                    <form action="{{ route('item-requests.update', $itemRequest) }}" method="POST" class="mb-2">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="name" value="{{ $itemRequest->name }}">
                        <input type="hidden" name="description" value="{{ $itemRequest->description }}">
                        <input type="hidden" name="request_date" value="{{ $itemRequest->request_date->format('Y-m-d') }}">
                        <input type="hidden" name="status" value="approved">
                        <button type="submit" class="btn btn-success w-100 mb-2">
                            <i class="fas fa-check-circle me-1"></i> Setujui Pengajuan
                        </button>
                    </form>

                    <form action="{{ route('item-requests.update', $itemRequest) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="name" value="{{ $itemRequest->name }}">
                        <input type="hidden" name="description" value="{{ $itemRequest->description }}">
                        <input type="hidden" name="request_date" value="{{ $itemRequest->request_date->format('Y-m-d') }}">
                        <input type="hidden" name="status" value="rejected">
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="fas fa-times-circle me-1"></i> Tolak Pengajuan
                        </button>
                    </form>
                </div>
            </div>
            @endif

            <!-- ===== STATUS HISTORY (Optional) ===== -->
            @if($itemRequest->status != 'pending')
            <div class="card mt-3">
                <div class="card-header bg-white">
                    <h6 class="mb-0">
                        <i class="fas fa-history me-2" style="color: var(--accent);"></i>
                        Riwayat Status
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="me-3" style="width: 32px; text-align: center;">
                            <i class="fas fa-circle" style="color: var(--accent-2); font-size: 12px;"></i>
                        </div>
                        <div>
                            <div class="fw-bold">Pengajuan Dibuat</div>
                            <small class="text-muted">{{ $itemRequest->created_at->format('d M Y H:i') }}</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="me-3" style="width: 32px; text-align: center;">
                            <i class="fas fa-circle" style="color: {{ $itemRequest->status == 'approved' ? 'var(--accent-2)' : 'var(--danger)' }}; font-size: 12px;"></i>
                        </div>
                        <div>
                            <div class="fw-bold">
                                {{ $itemRequest->status == 'approved' ? '✅ Disetujui' : '❌ Ditolak' }}
                            </div>
                            <small class="text-muted">{{ $itemRequest->updated_at->format('d M Y H:i') }}</small>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- ===== DELETE MODAL ===== -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle me-2" style="color: var(--danger);"></i>
                    Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus pengajuan barang <strong>{{ $itemRequest->name }}</strong>?</p>
                <div class="alert alert-danger" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    Tindakan ini <strong>tidak dapat dibatalkan</strong>. Semua data terkait akan hilang secara permanen.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Batal
                </button>
                <form action="{{ route('item-requests.destroy', $itemRequest) }}" method="POST" class="d-inline">
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
@endsection
