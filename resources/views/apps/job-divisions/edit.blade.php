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
        padding: 1.5rem;
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

    .form-control {
        border: 1px solid var(--line);
        border-radius: 9px;
        padding: 0.7rem 0.9rem;
        font-family: 'Inter', sans-serif;
        font-size: 0.95rem;
        color: var(--ink);
        background: var(--surface);
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .form-control:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(255, 106, 61, 0.15);
        outline: none;
    }

    .form-control.is-invalid {
        border-color: var(--danger);
    }

    .form-control.is-invalid:focus {
        border-color: var(--danger);
        box-shadow: 0 0 0 3px rgba(214, 69, 69, 0.15);
    }

    .form-control::placeholder {
        color: var(--ink-soft);
        opacity: 0.6;
    }

    .invalid-feedback {
        color: var(--danger);
        font-size: 0.8rem;
        margin-top: 0.4rem;
        display: block;
    }

    .form-text {
        font-size: 0.75rem;
        color: var(--ink-soft);
        margin-top: 0.3rem;
    }

    .form-text i {
        margin-right: 0.25rem;
    }

    /* ===== TEXTAREA ===== */
    textarea.form-control {
        resize: vertical;
        min-height: 120px;
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

    .btn-primary:active {
        transform: translateY(0);
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

    .btn-secondary {
        background: var(--surface);
        border-color: var(--line);
        color: var(--ink-soft);
    }

    .btn-secondary:hover {
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
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 8px 20px rgba(214, 69, 69, 0.25);
    }

    /* ===== ICON HELPERS ===== */
    .field-icon {
        color: var(--accent);
        margin-right: 0.5rem;
        width: 1.2rem;
        text-align: center;
    }

    /* ===== DIVIDER ===== */
    .divider {
        border-top: 1px solid var(--line);
        margin: 1.5rem 0;
    }

    /* ===== INFO CARD ===== */
    .info-card {
        background: var(--paper);
        border-radius: 9px;
        border: 1px solid var(--line);
        transition: border-color 0.2s ease;
    }

    .info-card:hover {
        border-color: var(--accent);
    }

    .info-card .card-title {
        font-family: 'Space Grotesk', sans-serif;
        font-weight: 600;
        color: var(--ink);
        font-size: 0.95rem;
        margin-bottom: 1rem;
    }

    .info-card .card-title i {
        color: var(--accent);
    }

    .info-card .info-item {
        display: flex;
        justify-content: space-between;
        padding: 0.5rem 0;
        border-bottom: 1px solid rgba(225, 228, 234, 0.5);
    }

    .info-card .info-item:last-child {
        border-bottom: none;
    }

    .info-card .info-label {
        font-weight: 600;
        color: var(--ink-soft);
        font-size: 0.85rem;
    }

    .info-card .info-value {
        color: var(--ink);
        font-weight: 500;
        font-size: 0.9rem;
    }

    .info-card .info-value code {
        background: var(--surface);
        padding: 0.1rem 0.5rem;
        border-radius: 4px;
        border: 1px solid var(--line);
        font-size: 0.85rem;
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

        .form-control {
            font-size: 0.9rem;
            padding: 0.6rem 0.8rem;
        }

        .d-flex.justify-content-between {
            flex-direction: column;
            gap: 1rem;
        }

        .d-flex.justify-content-between > div {
            width: 100%;
        }

        .d-flex.justify-content-between .btn {
            width: 100%;
        }

        .d-flex.justify-content-between .btn-secondary {
            margin-bottom: 0.5rem;
        }

        .d-flex.justify-content-between .btn + .btn {
            margin-left: 0 !important;
        }

        .d-flex.justify-content-between.align-items-center {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 1rem;
        }

        .d-flex.justify-content-between.align-items-center > div {
            width: 100%;
        }

        .d-flex.justify-content-between.align-items-center .btn {
            width: 100%;
        }

        .info-card .info-item {
            flex-direction: column;
            gap: 0.25rem;
        }

        .info-card .info-item:last-child {
            border-bottom: none;
        }
    }

    @media (max-width: 576px) {
        .container-fluid {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
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
                        <i class="fas fa-edit me-2" style="color: var(--accent);"></i>
                        Edit Divisi Pekerjaan
                    </h1>
                    <p class="text-muted mb-0">Perbarui informasi divisi pekerjaan yang sudah ada</p>
                </div>
                <div class="mt-2 mt-md-0">
                    <a href="{{ route('job-divisions.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar
                    </a>
                </div>
            </div>
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

    <!-- ===== FORM CARD ===== -->
    <div class="card">
        <div class="card-header bg-white">
            <h5>
                <i class="fas fa-building me-2" style="color: var(--accent);"></i>
                Informasi Divisi
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('job-divisions.update', $jobDivision) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- ===== NAMA DIVISI ===== -->
                <div class="mb-3">
                    <label for="name" class="form-label">
                        <i class="fas fa-tag field-icon"></i>
                        Nama Divisi <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           class="form-control @error('name') is-invalid @enderror"
                           id="name"
                           name="name"
                           value="{{ old('name', $jobDivision->name) }}"
                           placeholder="Masukkan nama divisi pekerjaan"
                           required
                           autofocus>
                    @error('name')
                    <div class="invalid-feedback">
                        <i class="fas fa-exclamation-circle me-1"></i>
                        {{ $message }}
                    </div>
                    @enderror
                    <div class="form-text">
                        <i class="fas fa-info-circle"></i>
                        Masukkan nama divisi pekerjaan (mis., Marketing, HR, Engineering, Finance)
                    </div>
                </div>

                <!-- ===== DESKRIPSI ===== -->
                <div class="mb-3">
                    <label for="description" class="form-label">
                        <i class="fas fa-align-left field-icon"></i>
                        Deskripsi
                    </label>
                    <textarea class="form-control @error('description') is-invalid @enderror"
                              id="description"
                              name="description"
                              rows="4"
                              placeholder="Jelaskan tentang divisi ini, tanggung jawab, dan fungsinya">{{ old('description', $jobDivision->description) }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">
                        <i class="fas fa-exclamation-circle me-1"></i>
                        {{ $message }}
                    </div>
                    @enderror
                    <div class="form-text">
                        <i class="fas fa-info-circle"></i>
                        Berikan deskripsi singkat tentang divisi pekerjaan ini dan tanggung jawabnya (opsional)
                    </div>
                </div>

                <!-- ===== DIVIDER ===== -->
                <div class="divider"></div>

                <!-- ===== INFO CARD ===== -->
                <div class="info-card card mb-4">
                    <div class="card-body">
                        <h6 class="card-title">
                            <i class="fas fa-info-circle me-2"></i>
                            Informasi Tambahan
                        </h6>
                        <div class="info-item">
                            <span class="info-label">
                                <i class="fas fa-calendar-plus me-1"></i>
                                Dibuat Pada
                            </span>
                            <span class="info-value">
                                {{ $jobDivision->created_at->format('d M Y H:i') }}
                                <small class="text-muted ms-2">({{ $jobDivision->created_at->diffForHumans() }})</small>
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">
                                <i class="fas fa-clock me-1"></i>
                                Terakhir Diperbarui
                            </span>
                            <span class="info-value">
                                {{ $jobDivision->updated_at->format('d M Y H:i') }}
                                <small class="text-muted ms-2">({{ $jobDivision->updated_at->diffForHumans() }})</small>
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">
                                <i class="fas fa-link me-1"></i>
                                Slug
                            </span>
                            <span class="info-value">
                                <code>{{ $jobDivision->slug }}</code>
                                <small class="text-muted ms-2">(Dibuat otomatis dari nama)</small>
                            </span>
                        </div>
                        @if($jobDivision->users_count > 0)
                        <div class="info-item">
                            <span class="info-label">
                                <i class="fas fa-users me-1"></i>
                                Jumlah Karyawan
                            </span>
                            <span class="info-value">
                                <span class="badge bg-primary">
                                    <i class="fas fa-user me-1"></i>
                                    {{ $jobDivision->users_count }} karyawan
                                </span>
                            </span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- ===== ACTION BUTTONS ===== -->
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <div>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="fas fa-trash me-1"></i> Hapus Divisi
                        </button>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('job-divisions.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Perbarui Divisi
                        </button>
                    </div>
                </div>
            </form>
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
            <div class="modal-body text-start">
                <p>Apakah Anda yakin ingin menghapus divisi <strong>{{ $jobDivision->name }}</strong>?</p>
                <div class="alert alert-danger" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    Tindakan ini <strong>tidak dapat dibatalkan</strong>.
                    @if($jobDivision->users_count > 0)
                    <br><br>
                    <i class="fas fa-users me-1"></i>
                    Divisi ini memiliki <strong>{{ $jobDivision->users_count }}</strong> karyawan yang terdaftar.
                    Menghapus divisi akan mempengaruhi data karyawan tersebut.
                    @endif
                </div>
                <div class="bg-light rounded p-3">
                    <small class="text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        Nama Divisi: <strong>{{ $jobDivision->name }}</strong>
                        <span class="mx-2">|</span>
                        Slug: <code>{{ $jobDivision->slug }}</code>
                        @if($jobDivision->created_at)
                        <span class="mx-2">|</span>
                        Dibuat: <strong>{{ $jobDivision->created_at->format('d M Y') }}</strong>
                        @endif
                    </small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Batal
                </button>
                <form action="{{ route('job-divisions.destroy', $jobDivision) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i> Hapus Permanen
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ===== AUTO-CAPITALIZE FIRST LETTER OF EACH WORD =====
        const nameInput = document.getElementById('name');

        nameInput.addEventListener('blur', function() {
            if (this.value) {
                const words = this.value.split(' ');
                const capitalized = words.map(word => {
                    if (word.length > 0) {
                        return word.charAt(0).toUpperCase() + word.slice(1).toLowerCase();
                    }
                    return word;
                });
                this.value = capitalized.join(' ');
            }
        });

        // ===== CHARACTER COUNTER FOR DESCRIPTION =====
        const descriptionInput = document.getElementById('description');
        const formText = descriptionInput.parentElement.querySelector('.form-text');

        const counterContainer = document.createElement('div');
        counterContainer.className = 'form-text mt-1';
        counterContainer.innerHTML = `
            <i class="fas fa-font me-1"></i>
            <span id="charCount">0</span> karakter
        `;

        // Insert before the existing form-text
        descriptionInput.parentElement.insertBefore(counterContainer, formText);

        // Move the existing form-text after the counter
        descriptionInput.parentElement.appendChild(formText);

        const charCount = document.getElementById('charCount');

        descriptionInput.addEventListener('input', function() {
            const length = this.value.length;
            charCount.textContent = length;

            // Visual indicator for long text
            if (length > 500) {
                charCount.style.color = 'var(--danger)';
            } else if (length > 300) {
                charCount.style.color = '#F2A93B';
            } else {
                charCount.style.color = 'var(--ink-soft)';
            }
        });

        // Initialize counter
        const initialLength = descriptionInput.value.length;
        charCount.textContent = initialLength;

        // ===== PREVENT DOUBLE SUBMIT =====
        const form = document.querySelector('form');
        const submitButton = form.querySelector('button[type="submit"]');

        form.addEventListener('submit', function() {
            submitButton.disabled = true;
            submitButton.innerHTML = `
                <i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...
            `;
        });
    });
</script>
@endpush
@endsection
