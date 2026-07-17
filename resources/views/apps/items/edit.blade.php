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

    .card-footer {
        background: var(--surface);
        border-top: 1px solid var(--line);
        padding: 1rem 1.25rem;
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

    /* ===== CHECKBOX ===== */
    .form-check {
        padding-left: 1.75rem;
    }

    .form-check-input {
        width: 1.1rem;
        height: 1.1rem;
        margin-top: 0.15rem;
        border: 2px solid var(--line);
        border-radius: 4px;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .form-check-input:checked {
        background-color: var(--accent);
        border-color: var(--accent);
    }

    .form-check-input:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(255, 106, 61, 0.15);
    }

    .form-check-label {
        font-size: 0.85rem;
        color: var(--ink-soft);
        cursor: pointer;
        margin-left: 0.25rem;
    }

    /* ===== IMAGE PREVIEW ===== */
    .current-image-container {
        position: relative;
        display: inline-block;
        border-radius: 9px;
        overflow: hidden;
        border: 2px solid var(--line);
        transition: border-color 0.2s ease;
    }

    .current-image-container:hover {
        border-color: var(--accent);
    }

    .current-image-container img {
        max-height: 200px;
        width: auto;
        display: block;
    }

    .image-actions {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 1rem;
        margin-top: 0.75rem;
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

    /* ===== FORM ROW ===== */
    .form-row {
        margin-bottom: 1.5rem;
    }

    .form-row:last-of-type {
        margin-bottom: 1.5rem;
    }

    /* ===== DIVIDER ===== */
    .divider {
        border-top: 1px solid var(--line);
        margin: 1.5rem 0;
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
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .d-flex.justify-content-between.align-items-center .btn {
            flex: 1;
            min-width: 100px;
        }

        .image-actions {
            flex-direction: column;
            align-items: flex-start;
        }

        .current-image-container img {
            max-height: 150px;
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
                        Edit Barang
                    </h1>
                    <p class="text-muted mb-0">Perbarui informasi barang yang sudah ada</p>
                </div>
                <div class="mt-2 mt-md-0">
                    <a href="{{ route('items.show', $item) }}" class="btn btn-info me-2">
                        <i class="fas fa-eye me-1"></i> Lihat Detail
                    </a>
                    <a href="{{ route('items.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
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
            <form action="{{ route('items.update', $item) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

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
                               value="{{ old('code', $item->code) }}"
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
                               value="{{ old('name', $item->name) }}"
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
                               value="{{ old('slug', $item->slug) }}"
                               placeholder="URL-friendly version of name">
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
                            Stok <span class="text-danger">*</span>
                        </label>
                        <input type="number"
                               class="form-control @error('stock') is-invalid @enderror"
                               id="stock"
                               name="stock"
                               value="{{ old('stock', $item->stock) }}"
                               min="0"
                               placeholder="Jumlah stok saat ini"
                               required>
                        @error('stock')
                        <div class="invalid-feedback">
                            <i class="fas fa-exclamation-circle me-1"></i>
                            {{ $message }}
                        </div>
                        @enderror
                        <div class="form-text">
                            <i class="fas fa-info-circle"></i>
                            Jumlah stok saat ini (minimal 0)
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
                                  placeholder="Jelaskan detail barang, spesifikasi, kegunaan, dll.">{{ old('description', $item->description) }}</textarea>
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

                        @if($item->image)
                        <div class="mb-3">
                            <div class="current-image-container">
                                <img src="{{ asset('storage/' . $item->image) }}"
                                     alt="{{ $item->name }}"
                                     class="img-fluid">
                            </div>
                            <div class="image-actions">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remove_image" name="remove_image">
                                    <label class="form-check-label" for="remove_image">
                                        <i class="fas fa-trash me-1" style="color: var(--danger);"></i>
                                        Hapus gambar saat ini
                                    </label>
                                </div>
                                <div class="text-muted small">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Centang untuk menghapus gambar yang ada
                                </div>
                            </div>
                        </div>
                        @endif

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
                            @if($item->image)
                            Upload gambar baru untuk menggantikan yang saat ini (opsional)
                            @else
                            Upload gambar untuk barang (opsional)
                            @endif
                            Format: JPG, PNG, GIF. Maks: 2MB
                        </div>

                        <!-- ===== PREVIEW ===== -->
                        <div id="imagePreview" class="mt-3" style="display: none;">
                            <div class="bg-light rounded p-3" style="max-width: 200px;">
                                <img id="previewImage" src="#" alt="Preview" class="img-fluid rounded" style="max-height: 150px; width: auto;">
                                <div id="fileInfo" class="mt-2 text-muted small">
                                    <i class="fas fa-check-circle text-success"></i>
                                    <span id="fileName"></span> (<span id="fileSize"></span> KB)
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ===== DIVIDER ===== -->
                <div class="divider"></div>

                <!-- ===== ACTION BUTTONS ===== -->
                <div class="d-flex flex-wrap justify-content-end gap-2">
                    <a href="{{ route('items.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-1"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Perbarui Barang
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ===== AUTO-GENERATE SLUG FROM NAME =====
        const nameInput = document.getElementById('name');
        const slugInput = document.getElementById('slug');
        const originalSlug = slugInput.value;

        nameInput.addEventListener('input', function() {
            // Only auto-generate if slug is empty or equals original
            if (!slugInput.value || slugInput.value === originalSlug) {
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

        // ===== IMAGE PREVIEW =====
        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('imagePreview');
        const previewImage = document.getElementById('previewImage');
        const fileName = document.getElementById('fileName');
        const fileSize = document.getElementById('fileSize');

        imageInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    fileName.textContent = imageInput.files[0].name;
                    fileSize.textContent = (imageInput.files[0].size / 1024).toFixed(1);
                    imagePreview.style.display = 'block';
                };
                reader.readAsDataURL(this.files[0]);
            } else {
                imagePreview.style.display = 'none';
            }
        });

        // ===== REMOVE IMAGE CHECKBOX BEHAVIOR =====
        const removeImageCheckbox = document.getElementById('remove_image');
        if (removeImageCheckbox) {
            removeImageCheckbox.addEventListener('change', function() {
                const imageInput = document.getElementById('image');
                if (this.checked) {
                    imageInput.disabled = true;
                    imageInput.value = '';
                    imagePreview.style.display = 'none';
                } else {
                    imageInput.disabled = false;
                }
            });
        }
    });
</script>
@endpush
@endsection
