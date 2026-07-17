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

    .form-control, .form-select {
        border: 1px solid var(--line);
        border-radius: 9px;
        padding: 0.7rem 0.9rem;
        font-family: 'Inter', sans-serif;
        font-size: 0.95rem;
        color: var(--ink);
        background: var(--surface);
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(255, 106, 61, 0.15);
        outline: none;
    }

    .form-control.is-invalid, .form-select.is-invalid {
        border-color: var(--danger);
    }

    .form-control.is-invalid:focus, .form-select.is-invalid:focus {
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

    /* ===== CURRENT PHOTO ===== */
    .current-photo-container {
        position: relative;
        display: inline-block;
        border-radius: 50%;
        overflow: hidden;
        border: 3px solid var(--line);
        transition: border-color 0.2s ease;
        width: 100px;
        height: 100px;
        flex-shrink: 0;
    }

    .current-photo-container:hover {
        border-color: var(--accent);
    }

    .current-photo-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .current-photo-container .no-photo {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--paper);
        color: var(--ink-soft);
        font-size: 2.5rem;
    }

    .photo-actions {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 1rem;
        margin-top: 0.75rem;
    }

    /* ===== PHOTO PREVIEW ===== */
    .photo-preview {
        display: none;
        margin-top: 0.75rem;
        padding: 0.75rem;
        background: var(--paper);
        border-radius: 9px;
        border: 1px solid var(--line);
        max-width: 150px;
    }

    .photo-preview img {
        width: 100%;
        height: auto;
        border-radius: 50%;
        aspect-ratio: 1/1;
        object-fit: cover;
        border: 3px solid var(--surface);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
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

    /* ===== PASSWORD SECTION ===== */
    .password-section {
        background: var(--paper);
        border-radius: 9px;
        padding: 1rem;
        border: 1px solid var(--line);
        margin-bottom: 1.5rem;
    }

    .password-section .section-title {
        font-family: 'Space Grotesk', sans-serif;
        font-weight: 600;
        color: var(--ink);
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }

    .password-section .section-title i {
        color: var(--accent);
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

        .form-control, .form-select {
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

        .current-photo-container {
            width: 80px;
            height: 80px;
        }

        .photo-actions {
            flex-direction: column;
            align-items: flex-start;
        }

        .info-card .info-item {
            flex-direction: column;
            gap: 0.25rem;
        }

        .info-card .info-item:last-child {
            border-bottom: none;
        }

        .photo-preview {
            max-width: 120px;
        }
    }

    @media (max-width: 576px) {
        .container-fluid {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }

        .current-photo-container {
            width: 70px;
            height: 70px;
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
                        <i class="fas fa-user-edit me-2" style="color: var(--accent);"></i>
                        Edit Pengguna
                    </h1>
                    <p class="text-muted mb-0">Perbarui informasi pengguna yang sudah ada</p>
                </div>
                <div class="mt-2 mt-md-0">
                    <a href="{{ route('users.index') }}" class="btn btn-outline-primary">
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
                <i class="fas fa-user-cog me-2" style="color: var(--accent);"></i>
                Informasi Pengguna
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('users.update', $user) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- ===== ROW 1: PHOTO ===== -->
                <div class="row mb-4">
                    <div class="col-12">
                        <label class="form-label">
                            <i class="fas fa-camera field-icon"></i>
                            Foto Profil
                        </label>
                        <div class="d-flex flex-wrap align-items-center gap-3">
                            <div class="current-photo-container">
                                @if($user->photo)
                                <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->name }}">
                                @else
                                <div class="no-photo">
                                    <i class="fas fa-user"></i>
                                </div>
                                @endif
                            </div>
                            <div>
                                <input type="file"
                                       class="form-control @error('photo') is-invalid @enderror"
                                       id="photo"
                                       name="photo"
                                       accept="image/*">
                                @error('photo')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    {{ $message }}
                                </div>
                                @enderror
                                <div class="photo-actions">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="remove_photo" name="remove_photo">
                                        <label class="form-check-label" for="remove_photo">
                                            <i class="fas fa-trash me-1" style="color: var(--danger);"></i>
                                            Hapus foto saat ini
                                        </label>
                                    </div>
                                    <div class="text-muted small">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Format: JPG, PNG, GIF. Maks: 2MB
                                    </div>
                                </div>
                                <div class="photo-preview" id="photoPreview">
                                    <img id="previewImage" src="#" alt="Preview Foto">
                                    <div class="text-center mt-2">
                                        <small class="text-muted" id="photoFileName"></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ===== ROW 2: NAME & EMAIL ===== -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">
                            <i class="fas fa-user field-icon"></i>
                            Nama Lengkap <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               class="form-control @error('name') is-invalid @enderror"
                               id="name"
                               name="name"
                               value="{{ old('name', $user->name) }}"
                               placeholder="Masukkan nama lengkap"
                               required
                               autofocus>
                        @error('name')
                        <div class="invalid-feedback">
                            <i class="fas fa-exclamation-circle me-1"></i>
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope field-icon"></i>
                            Alamat Email <span class="text-danger">*</span>
                        </label>
                        <input type="email"
                               class="form-control @error('email') is-invalid @enderror"
                               id="email"
                               name="email"
                               value="{{ old('email', $user->email) }}"
                               placeholder="Masukkan alamat email"
                               required>
                        @error('email')
                        <div class="invalid-feedback">
                            <i class="fas fa-exclamation-circle me-1"></i>
                            {{ $message }}
                        </div>
                        @enderror
                        @if($user->email_verified_at)
                        <div class="form-text text-success">
                            <i class="fas fa-check-circle me-1"></i>
                            Email terverifikasi pada {{ $user->email_verified_at->format('d M Y H:i') }}
                        </div>
                        @else
                        <div class="form-text text-warning">
                            <i class="fas fa-clock me-1"></i>
                            Email belum terverifikasi
                        </div>
                        @endif
                    </div>
                </div>

                <!-- ===== ROW 3: ROLE & DIVISION ===== -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="role" class="form-label">
                            <i class="fas fa-shield-alt field-icon"></i>
                            Role <span class="text-danger">*</span>
                        </label>
                        <select class="form-select @error('role') is-invalid @enderror"
                                id="role"
                                name="role"
                                required>
                            <option value="">Pilih Role</option>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>
                                <i class="fas fa-shield-alt me-1"></i> Admin
                            </option>
                            <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>
                                <i class="fas fa-user me-1"></i> User
                            </option>
                        </select>
                        @error('role')
                        <div class="invalid-feedback">
                            <i class="fas fa-exclamation-circle me-1"></i>
                            {{ $message }}
                        </div>
                        @enderror
                        <div class="form-text">
                            <i class="fas fa-info-circle"></i>
                            Admin memiliki akses penuh ke sistem. User hanya dapat mengelola pengajuan.
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="job_division_id" class="form-label">
                            <i class="fas fa-building field-icon"></i>
                            Divisi Pekerjaan
                        </label>
                        <select class="form-select @error('job_division_id') is-invalid @enderror"
                                id="job_division_id"
                                name="job_division_id">
                            <option value="">Pilih Divisi Pekerjaan</option>
                            @foreach($jobDivisions as $division)
                            <option value="{{ $division->id }}" {{ old('job_division_id', $user->job_division_id) == $division->id ? 'selected' : '' }}>
                                {{ $division->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('job_division_id')
                        <div class="invalid-feedback">
                            <i class="fas fa-exclamation-circle me-1"></i>
                            {{ $message }}
                        </div>
                        @enderror
                        <div class="form-text">
                            <i class="fas fa-info-circle"></i>
                            Pilih divisi pekerjaan pengguna (opsional)
                        </div>
                    </div>
                </div>

                <!-- ===== PASSWORD SECTION ===== -->
                <div class="password-section">
                    <div class="section-title">
                        <i class="fas fa-lock me-2"></i>
                        Ubah Password (Opsional)
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="password" class="form-label">
                                <i class="fas fa-key field-icon"></i>
                                Password Baru
                            </label>
                            <input type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   id="password"
                                   name="password"
                                   placeholder="Kosongkan jika tidak ingin mengubah">
                            @error('password')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                {{ $message }}
                            </div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-info-circle"></i>
                                Minimal 8 karakter. Kosongkan jika tidak ingin mengubah password.
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label">
                                <i class="fas fa-check-circle field-icon"></i>
                                Konfirmasi Password Baru
                            </label>
                            <input type="password"
                                   class="form-control"
                                   id="password_confirmation"
                                   name="password_confirmation"
                                   placeholder="Ketik ulang password baru">
                        </div>
                    </div>

                    <!-- Password Strength Indicator -->
                    <div class="password-strength mt-2" style="display: none;" id="strengthContainer">
                        <div style="display: flex; gap: 4px; margin-top: 0.3rem;">
                            <span style="flex: 1; height: 3px; background: var(--line); border-radius: 2px; transition: all 0.3s ease;"></span>
                            <span style="flex: 1; height: 3px; background: var(--line); border-radius: 2px; transition: all 0.3s ease;"></span>
                            <span style="flex: 1; height: 3px; background: var(--line); border-radius: 2px; transition: all 0.3s ease;"></span>
                            <span style="flex: 1; height: 3px; background: var(--line); border-radius: 2px; transition: all 0.3s ease;"></span>
                        </div>
                        <div style="font-size: 0.7rem; color: var(--ink-soft); margin-top: 0.2rem;" id="strengthText">Ketik password untuk melihat kekuatan</div>
                    </div>
                </div>

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
                                {{ $user->created_at->format('d M Y H:i') }}
                                <small class="text-muted ms-2">({{ $user->created_at->diffForHumans() }})</small>
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">
                                <i class="fas fa-clock me-1"></i>
                                Terakhir Diperbarui
                            </span>
                            <span class="info-value">
                                {{ $user->updated_at->format('d M Y H:i') }}
                                <small class="text-muted ms-2">({{ $user->updated_at->diffForHumans() }})</small>
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">
                                <i class="fas fa-envelope me-1"></i>
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
                    </div>
                </div>

                <!-- ===== DIVIDER ===== -->
                <div class="divider"></div>

                <!-- ===== ACTION BUTTONS ===== -->
                <div class="d-flex flex-wrap justify-content-end gap-2">
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-1"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Perbarui Pengguna
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ===== PHOTO PREVIEW =====
        const photoInput = document.getElementById('photo');
        const photoPreview = document.getElementById('photoPreview');
        const previewImage = document.getElementById('previewImage');
        const photoFileName = document.getElementById('photoFileName');

        photoInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    photoFileName.textContent = this.files[0].name + ' (' + (this.files[0].size / 1024).toFixed(1) + ' KB)';
                    photoPreview.style.display = 'block';
                }.bind(this);
                reader.readAsDataURL(this.files[0]);
            } else {
                photoPreview.style.display = 'none';
            }
        });

        // ===== REMOVE PHOTO CHECKBOX =====
        const removePhotoCheckbox = document.getElementById('remove_photo');
        if (removePhotoCheckbox) {
            removePhotoCheckbox.addEventListener('change', function() {
                const photoInput = document.getElementById('photo');
                if (this.checked) {
                    photoInput.disabled = true;
                    photoInput.value = '';
                    photoPreview.style.display = 'none';
                } else {
                    photoInput.disabled = false;
                }
            });
        }

        // ===== AUTO-CAPITALIZE NAME =====
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

        // ===== PASSWORD STRENGTH INDICATOR =====
        const passwordInput = document.getElementById('password');
        const strengthContainer = document.getElementById('strengthContainer');
        const bars = strengthContainer ? strengthContainer.querySelectorAll('span') : [];
        const strengthText = document.getElementById('strengthText');

        passwordInput.addEventListener('input', function() {
            const value = this.value;

            if (value.length > 0) {
                strengthContainer.style.display = 'block';
                let strength = 0;

                if (value.length >= 8) strength++;
                if (/[a-z]/.test(value) && /[A-Z]/.test(value)) strength++;
                if (/\d/.test(value)) strength++;
                if (/[^a-zA-Z0-9]/.test(value)) strength++;

                bars.forEach((bar, index) => {
                    bar.style.background = index < strength ?
                        (strength <= 2 ? 'var(--danger)' :
                         strength === 3 ? '#F2A93B' : 'var(--accent-2)') : 'var(--line)';
                });

                const messages = [
                    'Password lemah - tambahkan huruf besar, angka, dan simbol',
                    'Password lemah - tambahkan variasi karakter',
                    'Password sedang - tambahkan simbol untuk lebih kuat',
                    'Password kuat!',
                    'Password sangat kuat!'
                ];
                strengthText.textContent = messages[strength];
                strengthText.style.color = strength >= 3 ? 'var(--accent-2)' : 'var(--ink-soft)';
            } else {
                strengthContainer.style.display = 'none';
            }
        });

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
