@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1>Profil Pengguna</h1>
            <p class="text-muted mb-0">Informasi detail akun Anda</p>
        </div>
        <div>
            @if(Auth::user()->role == 'admin')
            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar User
            </a>
            @endif
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-user me-2"></i>
                        Informasi Profil
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold text-muted">Foto</label>
                            <div class="form-control-plaintext bg-light rounded p-3">
                                <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="Foto Profil" class="img-fluid rounded-circle" style="width: 100px; height: 100px;">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-muted">Nama Lengkap</label>
                            <div class="form-control-plaintext bg-light rounded p-3">
                                <i class="fas fa-user me-2 text-primary"></i>
                                {{ Auth::user()->name }}
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-muted">Email</label>
                            <div class="form-control-plaintext bg-light rounded p-3">
                                <i class="fas fa-envelope me-2 text-primary"></i>
                                {{ Auth::user()->email }}
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-muted">Role</label>
                            <div class="form-control-plaintext bg-light rounded p-3">
                                <i class="fas fa-shield-alt me-2 text-primary"></i>
                                @if(Auth::user()->role == 'admin')
                                <span class="badge bg-danger ms-1">Administrator</span>
                                @else
                                <span class="badge bg-primary ms-1">User</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-muted">Divisi Kerja</label>
                            <div class="form-control-plaintext bg-light rounded p-3">
                                <i class="fas fa-building me-2 text-primary"></i>
                                @if(Auth::user()->jobDivision)
                                {{ Auth::user()->jobDivision->name }}
                                @else
                                <span class="text-muted">Belum ditentukan</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-muted">Tanggal Bergabung</label>
                            <div class="form-control-plaintext bg-light rounded p-3">
                                <i class="fas fa-calendar-plus me-2 text-primary"></i>
                                {{ Auth::user()->created_at->format('d M Y') }}
                                <small class="text-muted ms-2">({{ Auth::user()->created_at->diffForHumans() }})</small>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-muted">Terakhir Diperbarui</label>
                            <div class="form-control-plaintext bg-light rounded p-3">
                                <i class="fas fa-clock me-2 text-primary"></i>
                                {{ Auth::user()->updated_at->format('d M Y H:i') }}
                                <small class="text-muted ms-2">({{ Auth::user()->updated_at->diffForHumans() }})</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.form-control-plaintext {
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
}

.form-control-plaintext:hover {
    border-color: var(--bs-primary);
    box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.1);
}
</style>
@endsection
