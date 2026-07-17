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

    /* ===== FORM ELEMENTS ===== */
    .form-label {
        font-weight: 600;
        font-size: 0.85rem;
        color: var(--ink);
        margin-bottom: 0.4rem;
    }

    .form-label .text-danger {
        color: var(--danger) !important;
    }

    .form-control,
    .form-select {
        border: 1px solid var(--line);
        border-radius: 9px;
        padding: 0.7rem 0.9rem;
        font-family: 'Inter', sans-serif;
        font-size: 0.95rem;
        color: var(--ink);
        background: var(--surface);
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(255, 106, 61, 0.15);
        outline: none;
    }

    .form-control.is-invalid,
    .form-select.is-invalid {
        border-color: var(--danger);
    }

    .form-control.is-invalid:focus,
    .form-select.is-invalid:focus {
        border-color: var(--danger);
        box-shadow: 0 0 0 3px rgba(214, 69, 69, 0.15);
    }

    .invalid-feedback {
        color: var(--danger);
        font-size: 0.8rem;
        margin-top: 0.4rem;
    }

    .form-text {
        font-size: 0.75rem;
        color: var(--ink-soft);
        margin-top: 0.3rem;
    }

    .form-control-plaintext {
        border: 1px solid var(--line);
        border-radius: 9px;
        padding: 0.7rem 0.9rem;
        background: var(--paper) !important;
        color: var(--ink);
    }

    .form-control-plaintext .badge {
        font-size: 0.85rem;
        padding: 0.4rem 0.8rem;
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

    .btn-secondary {
        background: var(--surface);
        border-color: var(--line);
        color: var(--ink-soft);
    }

    .btn-secondary:hover {
        background: var(--paper);
        border-color: var(--line);
        color: var(--ink);
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

    /* ===== BADGES ===== */
    .badge {
        font-weight: 600;
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
        font-size: 0.78rem;
    }

    .badge.bg-warning {
        background-color: #F2A93B !important;
        color: #101B2D !important;
    }

    .badge.bg-success {
        background-color: var(--accent-2) !important;
        color: #fff !important;
    }

    .badge.bg-danger {
        background-color: var(--danger) !important;
        color: #fff !important;
    }

    /* ===== DANGER ZONE CARD ===== */
    .card-danger .card-header {
        background: var(--danger);
        color: #fff;
        border-bottom: none;
    }

    .card-danger .card-header h6 {
        color: #fff;
    }

    .card-danger .card-body {
        background: #fef6f6;
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
            <h1>Edit Pengajuan Barang</h1>
            <p class="text-muted mb-0">Ubah data pengajuan barang yang sudah diajukan</p>
        </div>
        <div>
            <a href="{{ route('item-requests.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <!-- ===== ALERTS ===== -->
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- ===== MAIN CONTENT ===== -->
    <div class="row">
        <!-- ===== FORM ===== -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-edit me-2" style="color: var(--accent);"></i>
                        Form Edit Pengajuan
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('item-requests.update', $itemRequest) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Nama Barang -->
                        <div class="mb-3">
                            <label for="name" class="form-label">
                                Nama Barang <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   id="name"
                                   name="name"
                                   value="{{ old('name', $itemRequest->name) }}"
                                   placeholder="Masukkan nama barang yang diajukan"
                                   required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Nama barang yang ingin diajukan untuk pengadaan
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-3">
                            <label for="description" class="form-label">
                                Deskripsi <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description"
                                      name="description"
                                      rows="4"
                                      placeholder="Jelaskan detail barang yang diajukan, spesifikasi, kegunaan, dll."
                                      required>{{ old('description', $itemRequest->description) }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Berikan deskripsi lengkap tentang barang yang diajukan
                            </div>
                        </div>

                        <div class="row">
                            <!-- Tanggal Pengajuan -->
                            <div class="col-md-6 mb-3">
                                <label for="request_date" class="form-label">
                                    <i class="fas fa-calendar me-1"></i>
                                    Tanggal Pengajuan
                                </label>
                                <input type="date"
                                       class="form-control @error('request_date') is-invalid @enderror"
                                       id="request_date"
                                       name="request_date"
                                       value="{{ old('request_date', $itemRequest->request_date->format('Y-m-d')) }}">
                                @error('request_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Status (Admin Only) -->
                            @if(Auth::user()->role == 'admin')
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">
                                    <i class="fas fa-tag me-1"></i>
                                    Status
                                </label>
                                <select class="form-select @error('status') is-invalid @enderror"
                                        id="status"
                                        name="status">
                                    <option value="pending" {{ old('status', $itemRequest->status) == 'pending' ? 'selected' : '' }}>
                                        🕐 Menunggu
                                    </option>
                                    <option value="approved" {{ old('status', $itemRequest->status) == 'approved' ? 'selected' : '' }}>
                                        ✅ Disetujui
                                    </option>
                                    <option value="rejected" {{ old('status', $itemRequest->status) == 'rejected' ? 'selected' : '' }}>
                                        ❌ Ditolak
                                    </option>
                                </select>
                                @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            @else
                            <!-- Status Display (Non-Admin) -->
                            <div class="col-md-6 mb-3">
                                <label for="status_display" class="form-label">
                                    <i class="fas fa-tag me-1"></i>
                                    Status
                                </label>
                                <div class="form-control-plaintext">
                                    @if($itemRequest->status == 'pending')
                                    <span class="badge bg-warning">
                                        <i class="fas fa-clock me-1"></i>Menunggu
                                    </span>
                                    @elseif($itemRequest->status == 'approved')
                                    <span class="badge bg-success">
                                        <i class="fas fa-check me-1"></i>Disetujui
                                    </span>
                                    @elseif($itemRequest->status == 'rejected')
                                    <span class="badge bg-danger">
                                        <i class="fas fa-times me-1"></i>Ditolak
                                    </span>
                                    @endif
                                </div>
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Status hanya dapat diubah oleh admin
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                            <a href="{{ route('item-requests.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- ===== SIDEBAR ===== -->
        <div class="col-lg-4">
            <!-- Info Card -->
            <div class="card">
                <div class="card-header bg-white">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle me-2" style="color: var(--accent);"></i>
                        Informasi Pengajuan
                    </h6>
                </div>
                <div class="card-body">
                    <!-- Pengaju -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted">
                            <i class="fas fa-user me-1"></i> Pengaju
                        </label>
                        <div class="form-control-plaintext">
                            @if($itemRequest->requestedBy)
                            <div class="d-flex align-items-center">
                                <div class="avatar-placeholder me-2"
                                     style="width: 36px; height: 36px; background: var(--accent); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700; font-size: 14px;">
                                    {{ strtoupper(substr($itemRequest->requestedBy->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-bold">{{ $itemRequest->requestedBy->name }}</div>
                                    <small class="text-muted">{{ $itemRequest->requestedBy->email }}</small>
                                </div>
                            </div>
                            @else
                            <span class="text-muted">Tidak diketahui</span>
                            @endif
                        </div>
                    </div>

                    <!-- Dibuat -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted">
                            <i class="fas fa-calendar-plus me-1"></i> Dibuat
                        </label>
                        <div class="form-control-plaintext">
                            <div>{{ $itemRequest->created_at->format('d M Y H:i') }}</div>
                            <small class="text-muted">{{ $itemRequest->created_at->diffForHumans() }}</small>
                        </div>
                    </div>

                    <!-- Terakhir Diubah -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted">
                            <i class="fas fa-clock me-1"></i> Terakhir Diubah
                        </label>
                        <div class="form-control-plaintext">
                            <div>{{ $itemRequest->updated_at->format('d M Y H:i') }}</div>
                            <small class="text-muted">{{ $itemRequest->updated_at->diffForHumans() }}</small>
                        </div>
                    </div>

                    <!-- Status Saat Ini -->
                    <div class="mb-0">
                        <label class="form-label fw-bold text-muted">
                            <i class="fas fa-tag me-1"></i> Status Saat Ini
                        </label>
                        <div class="form-control-plaintext">
                            @if($itemRequest->status == 'pending')
                            <span class="badge bg-warning">
                                <i class="fas fa-clock me-1"></i>Menunggu Persetujuan
                            </span>
                            @elseif($itemRequest->status == 'approved')
                            <span class="badge bg-success">
                                <i class="fas fa-check me-1"></i>Disetujui
                            </span>
                            @elseif($itemRequest->status == 'rejected')
                            <span class="badge bg-danger">
                                <i class="fas fa-times me-1"></i>Ditolak
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="card mt-3 card-danger">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Zona Bahaya
                    </h6>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">
                        <i class="fas fa-skull me-1"></i>
                        Hapus pengajuan barang ini secara permanen. Tindakan ini tidak dapat dibatalkan.
                    </p>
                    <button type="button" class="btn btn-danger w-100"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteModal">
                        <i class="fas fa-trash me-1"></i> Hapus Pengajuan
                    </button>
                </div>
            </div>
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
