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

    .form-control-plaintext {
        border: 1px solid var(--line);
        border-radius: 9px;
        padding: 0.7rem 0.9rem;
        background: var(--paper) !important;
        color: var(--ink);
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

    /* ===== FILE INPUT ===== */
    .form-control[type="file"] {
        padding: 0.5rem 0.7rem;
        cursor: pointer;
    }

    .form-control[type="file"]::-webkit-file-upload-button {
        background: var(--paper);
        border: 1px solid var(--line);
        border-radius: 6px;
        padding: 0.4rem 0.8rem;
        font-family: 'Inter', sans-serif;
        font-weight: 500;
        font-size: 0.8rem;
        color: var(--ink);
        cursor: pointer;
        transition: all 0.2s ease;
        margin-right: 0.5rem;
    }

    .form-control[type="file"]::-webkit-file-upload-button:hover {
        background: var(--line);
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

    /* ===== FORM ROW ===== */
    .form-row {
        margin-bottom: 1.5rem;
    }

    .form-row:last-of-type {
        margin-bottom: 1.5rem;
    }

    /* ===== ICON HELPERS ===== */
    .field-icon {
        color: var(--accent);
        margin-right: 0.5rem;
        width: 1.2rem;
        text-align: center;
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
                        <i class="fas fa-plus-circle me-2" style="color: var(--accent);"></i>
                        Tambah Barang Baru
                    </h1>
                    <p class="text-muted mb-0">Tambahkan barang baru ke dalam sistem inventori</p>
                </div>
                <div class="mt-2 mt-md-0">
                    <a href="{{ route('items.index') }}" class="btn btn-outline-primary">
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
                <i class="fas fa-box me-2" style="color: var(--accent);"></i>
                Informasi Barang
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- ===== ROW 1: Kode & Nama ===== -->
                <div class="row form-row">
                    <div class="col-md-6">
                        <label for="code" class="form-label">
                            <i class="fas fa-barcode field-icon"></i>
                            Kode Barang <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               class="form-control @error('code') is-invalid @enderror"
                               id="code"
                               name="code"
                               value="{{ old('code') }}"
                               placeholder="Masukkan kode barang unik"
                               required>
                        @error('code')
                        <div class="invalid-feedback">
                            <i class="fas fa-exclamation-circle me-1"></i>
                            {{ $message }}
                        </div>
                        @enderror
                        <div class="form-text">
                            <i class="fas fa-info-circle"></i>
                            Identifikasi unik untuk barang ini, misal: BRG-001
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="name" class="form-label">
                            <i class="fas fa-tag field-icon"></i>
                            Nama Barang <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               class="form-control @error('name') is-invalid @enderror"
                               id="name"
                               name="name"
                               value="{{ old('name') }}"
                               placeholder="Masukkan nama barang"
                               required>
                        @error('name')
                        <div class="invalid-feedback">
                            <i class="fas fa-exclamation-circle me-1"></i>
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <!-- ===== ROW 2: Slug & Stok ===== -->
                <div class="row form-row">
                    <div class="col-md-6">
                        <label for="slug" class="form-label">
                            <i class="fas fa-link field-icon"></i>
                            Slug
                        </label>
                        <input type="text"
                               class="form-control @error('slug') is-invalid @enderror"
                               id="slug"
                               name="slug"
                               value="{{ old('slug') }}"
                               placeholder="Akan dibuat otomatis dari nama">
                        @error('slug')
                        <div class="invalid-feedback">
                            <i class="fas fa-exclamation-circle me-1"></i>
                            {{ $message }}
                        </div>
                        @enderror
                        <div class="form-text">
                            <i class="fas fa-info-circle"></i>
                            Biarkan kosong untuk dibuat otomatis dari nama barang
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="stock" class="form-label">
                            <i class="fas fa-boxes field-icon"></i>
                            Stok Awal <span class="text-danger">*</span>
                        </label>
                        <input type="number"
                               class="form-control @error('stock') is-invalid @enderror"
                               id="stock"
                               name="stock"
                               value="{{ old('stock', 0) }}"
                               min="0"
                               placeholder="Jumlah stok awal"
                               required>
                        @error('stock')
                        <div class="invalid-feedback">
                            <i class="fas fa-exclamation-circle me-1"></i>
                            {{ $message }}
                        </div>
                        @enderror
                        <div class="form-text">
                            <i class="fas fa-info-circle"></i>
                            Jumlah stok awal barang (minimal 0)
                        </div>
                    </div>
                </div>

                <!-- ===== ROW 3: Deskripsi ===== -->
                <div class="form-row">
                    <div class="col-12">
                        <label for="description" class="form-label">
                            <i class="fas fa-align-left field-icon"></i>
                            Deskripsi
                        </label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  id="description"
                                  name="description"
                                  rows="4"
                                  placeholder="Jelaskan detail barang, spesifikasi, kegunaan, dll.">{{ old('description') }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">
                            <i class="fas fa-exclamation-circle me-1"></i>
                            {{ $message }}
                        </div>
                        @enderror
                        <div class="form-text">
                            <i class="fas fa-info-circle"></i>
                            Berikan deskripsi lengkap tentang barang (opsional)
                        </div>
                    </div>
                </div>

                <!-- ===== ROW 4: Gambar ===== -->
                <div class="form-row">
                    <div class="col-12">
                        <label for="image" class="form-label">
                            <i class="fas fa-image field-icon"></i>
                            Gambar Barang
                        </label>
                        <input type="file"
                               class="form-control @error('image') is-invalid @enderror"
                               id="image"
                               name="image"
                               accept="image/*">
                        @error('image')
                        <div class="invalid-feedback">
                            <i class="fas fa-exclamation-circle me-1"></i>
                            {{ $message }}
                        </div>
                        @enderror
                        <div class="form-text">
                            <i class="fas fa-info-circle"></i>
                            Unggah gambar barang (opsional). Format: JPG, PNG, GIF. Maks: 2MB
                        </div>
                    </div>
                </div>

                <!-- ===== ACTION BUTTONS ===== -->
                <div class="d-flex flex-wrap justify-content-end gap-2 mt-4 pt-3 border-top">
                    <button type="reset" class="btn btn-secondary">
                        <i class="fas fa-undo me-1"></i> Reset
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Simpan Barang
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // ===== AUTO-GENERATE SLUG FROM NAME =====
    document.addEventListener('DOMContentLoaded', function() {
        const nameInput = document.getElementById('name');
        const slugInput = document.getElementById('slug');

        nameInput.addEventListener('input', function() {
            if (!slugInput.value || slugInput.dataset.generated === 'true') {
                const name = this.value;
                const slug = name.toLowerCase()
                    .replace(/[^\w\s-]/g, '')  // Remove special characters
                    .replace(/[\s_]+/g, '-')   // Replace spaces with hyphens
                    .replace(/-+/g, '-')        // Remove multiple hyphens
                    .replace(/^-+|-+$/g, '');   // Remove leading/trailing hyphens

                slugInput.value = slug;
                slugInput.dataset.generated = 'true';
            }
        });

        // Allow manual editing of slug
        slugInput.addEventListener('input', function() {
            this.dataset.generated = 'false';
        });

        // Reset generated flag when form is reset
        document.querySelector('form').addEventListener('reset', function() {
            slugInput.dataset.generated = 'false';
        });

        // ===== PREVIEW IMAGE (Optional Enhancement) =====
        const imageInput = document.getElementById('image');
        const imagePreview = document.createElement('div');
        imagePreview.className = 'mt-3';
        imagePreview.style.display = 'none';
        imageInput.parentNode.insertBefore(imagePreview, imageInput.nextSibling);

        imageInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.innerHTML = `
                        <div class="bg-light rounded p-3" style="max-width: 200px;">
                            <img src="${e.target.result}" alt="Preview" class="img-fluid rounded" style="max-height: 150px; width: auto;">
                            <div class="mt-2 text-muted small">
                                <i class="fas fa-check-circle text-success"></i>
                                ${imageInput.files[0].name} (${(imageInput.files[0].size / 1024).toFixed(1)} KB)
                            </div>
                        </div>
                    `;
                    imagePreview.style.display = 'block';
                };
                reader.readAsDataURL(this.files[0]);
            } else {
                imagePreview.style.display = 'none';
            }
        });
    });
</script>
@endpush
@endsection
