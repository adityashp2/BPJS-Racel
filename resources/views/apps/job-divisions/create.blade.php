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

    /* ===== INFO BOX ===== */
    .info-box {
        background: var(--paper);
        border-radius: 9px;
        padding: 1rem;
        border-left: 4px solid var(--accent);
        margin-bottom: 1.5rem;
    }

    .info-box i {
        color: var(--accent);
        margin-right: 0.5rem;
    }

    .info-box .text-muted {
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

        .form-control {
            font-size: 0.9rem;
            padding: 0.6rem 0.8rem;
        }

        .d-flex.justify-content-end {
            flex-direction: column-reverse;
            gap: 0.5rem;
        }

        .d-flex.justify-content-end .btn {
            width: 100%;
        }

        .d-flex.justify-content-end .btn:first-child {
            margin-right: 0 !important;
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
    }

    @media (max-width: 576px) {
        .container-fluid {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }

        .info-box {
            padding: 0.75rem;
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
                        <i class="fas fa-plus-circle me-2" style="color: var(--accent);"></i>
                        Tambah Divisi Pekerjaan Baru
                    </h1>
                    <p class="text-muted mb-0">Tambahkan divisi pekerjaan baru ke dalam sistem</p>
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

    <!-- ===== INFO BOX ===== -->
    <div class="info-box">
        <i class="fas fa-info-circle"></i>
        <span class="text-muted">
            Divisi pekerjaan digunakan untuk mengelompokkan karyawan berdasarkan fungsi atau departemen.
            Setiap karyawan akan ditugaskan ke satu divisi.
        </span>
    </div>

    <!-- ===== FORM CARD ===== -->
    <div class="card">
        <div class="card-header bg-white">
            <h5>
                <i class="fas fa-building me-2" style="color: var(--accent);"></i>
                Informasi Divisi
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('job-divisions.store') }}" method="POST">
                @csrf

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
                           value="{{ old('name') }}"
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
                              placeholder="Jelaskan tentang divisi ini, tanggung jawab, dan fungsinya">{{ old('description') }}</textarea>
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

                <!-- ===== ACTION BUTTONS ===== -->
                <div class="d-flex flex-wrap justify-content-end gap-2">
                    <button type="reset" class="btn btn-secondary">
                        <i class="fas fa-undo me-1"></i> Reset
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Simpan Divisi
                    </button>
                </div>
            </form>
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
        const counterContainer = document.createElement('div');
        counterContainer.className = 'form-text mt-1';
        counterContainer.innerHTML = `
            <i class="fas fa-font me-1"></i>
            <span id="charCount">0</span> karakter
        `;
        descriptionInput.parentNode.appendChild(counterContainer);

        const charCount = document.getElementById('charCount');

        descriptionInput.addEventListener('input', function() {
            const length = this.value.length;
            charCount.textContent = length;

            // Optional: Add visual indicator for long text
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
