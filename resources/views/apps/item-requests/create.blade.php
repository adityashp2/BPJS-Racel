@extends('layouts.app')

@push('styles')
<style>
    h1 {
        font-family: 'Space Grotesk', sans-serif;
        font-weight: 700;
        color: #101B2D;
        font-size: 1.9rem;
    }

    .alert {
        border-radius: 10px;
        border: 1px solid transparent;
        font-size: 0.92rem;
    }
    .alert-danger { background: rgba(214, 69, 69, 0.10); color: #D64545; border-color: rgba(214, 69, 69, 0.25); }

    .card { border: 1px solid #E1E4EA; border-radius: 14px; box-shadow: 0 4px 14px rgba(16, 27, 45, 0.04); }
    .card-header { border-bottom: 1px solid #E1E4EA; }
    .card-header h5 { font-family: 'Space Grotesk', sans-serif; font-weight: 600; color: #101B2D; }

    .form-label {
        font-weight: 600;
        font-size: 0.88rem;
        color: #101B2D;
        margin-bottom: 0.4rem;
    }

    .form-control, .form-select {
        border: 1px solid #E1E4EA;
        border-radius: 9px;
        padding: 0.55rem 0.85rem;
        font-size: 0.95rem;
    }

    .form-control:focus, .form-select:focus {
        border-color: #FF6A3D;
        box-shadow: 0 0 0 0.2rem rgba(255, 106, 61, 0.15);
    }

    .form-control.is-invalid, .form-select.is-invalid {
        border-color: #D64545;
    }

    .invalid-feedback {
        color: #D64545;
        font-size: 0.82rem;
    }

    .form-text {
        font-size: 0.8rem;
        color: #4B5768;
    }

    /* Requester info panel */
    .card.bg-light {
        background-color: #F4F5F8 !important;
        border: 1px dashed #E1E4EA;
        box-shadow: none;
    }
    .card.bg-light .card-title {
        font-family: 'Space Grotesk', sans-serif;
        font-weight: 600;
        font-size: 0.95rem;
        color: #101B2D;
    }

    .btn-secondary {
        background-color: #fff;
        border-color: #E1E4EA;
        color: #4B5768;
    }
    .btn-secondary:hover {
        background-color: #F4F5F8;
        border-color: #E1E4EA;
        color: #101B2D;
    }

    .btn-outline-secondary {
        color: #4B5768;
        border-color: #E1E4EA;
    }
    .btn-outline-secondary:hover {
        background-color: #F4F5F8;
        border-color: #E1E4EA;
        color: #101B2D;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1>Tambah Pengajuan Barang</h1>
            <p class="text-muted mb-0">Buat pengajuan barang baru</p>
        </div>
        <div>
            <a href="{{ route('item-requests.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-plus me-2"></i>
                        Form Pengajuan Barang
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('item-requests.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="name" class="form-label">Nama Barang <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       id="name"
                                       name="name"
                                       value="{{ old('name') }}"
                                       placeholder="Masukkan nama barang yang diajukan"
                                       required>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Nama barang yang ingin diajukan untuk pengadaan</div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="description" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                          id="description"
                                          name="description"
                                          rows="4"
                                          placeholder="Jelaskan detail barang yang diajukan, spesifikasi, kegunaan, dll."
                                          required>{{ old('description') }}</textarea>
                                @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Berikan deskripsi lengkap tentang barang yang diajukan</div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="request_date" class="form-label">Tanggal Pengajuan</label>
                                <input type="date"
                                       class="form-control @error('request_date') is-invalid @enderror"
                                       id="request_date"
                                       name="request_date"
                                       value="{{ old('request_date', date('Y-m-d')) }}">
                                @error('request_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Tanggal pengajuan (default: hari ini)</div>
                            </div>

                            @if(Auth::user()->role == 'admin')
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select @error('status') is-invalid @enderror"
                                        id="status"
                                        name="status">
                                    <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>
                                        Menunggu
                                    </option>
                                    <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>
                                        Disetujui
                                    </option>
                                    <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>
                                        Ditolak
                                    </option>
                                </select>
                                @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Status pengajuan barang</div>
                            </div>
                            @endif
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">
                                            <i class="fas fa-info-circle me-2"></i>
                                            Informasi Pengaju
                                        </h6>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Nama:</strong> {{ Auth::user()->name }}
                                            </div>
                                            <div class="col-md-6">
                                                <strong>Email:</strong> {{ Auth::user()->email }}
                                            </div>
                                            @if(Auth::user()->jobDivision)
                                            <div class="col-md-6 mt-2">
                                                <strong>Divisi:</strong> {{ Auth::user()->jobDivision->name }}
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('item-requests.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Simpan Pengajuan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
