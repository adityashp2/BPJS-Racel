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
    .alert-success { background: rgba(18, 128, 92, 0.10); color: #12805C; border-color: rgba(18, 128, 92, 0.25); }
    .alert-danger  { background: rgba(214, 69, 69, 0.10); color: #D64545; border-color: rgba(214, 69, 69, 0.25); }

    .card { border: 1px solid #E1E4EA; border-radius: 14px; box-shadow: 0 4px 14px rgba(16, 27, 45, 0.04); }
    .card-header { border-bottom: 1px solid #E1E4EA; }
    .card-header h5 { font-family: 'Space Grotesk', sans-serif; font-weight: 600; color: #101B2D; }

    .table thead.table-light th {
        background: #F4F5F8;
        font-family: 'IBM Plex Mono', monospace;
        font-size: 0.72rem;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        color: #4B5768;
        border-bottom: 1px solid #E1E4EA;
        font-weight: 600;
    }

    .badge.bg-warning { background-color: #F2A93B !important; }
    .badge.bg-success { background-color: #12805C !important; }
    .badge.bg-danger  { background-color: #D64545 !important; }

    /* Outline action buttons in the row actions */
    .btn-outline-info { color: #2F6FB0; border-color: #2F6FB0; }
    .btn-outline-info:hover { background-color: #2F6FB0; border-color: #2F6FB0; color: #fff; }
    .btn-outline-warning { color: #b8791f; border-color: #F2A93B; }
    .btn-outline-warning:hover { background-color: #F2A93B; border-color: #F2A93B; color: #fff; }
    .btn-outline-danger { color: #D64545; border-color: #D64545; }
    .btn-outline-danger:hover { background-color: #D64545; border-color: #D64545; color: #fff; }
    .btn-outline-secondary { color: #4B5768; border-color: #E1E4EA; }
    .btn-outline-secondary:hover { background-color: #F4F5F8; border-color: #E1E4EA; color: #101B2D; }

    .form-control:focus { border-color: #FF6A3D; box-shadow: 0 0 0 0.2rem rgba(255, 106, 61, 0.15); }

    /* Modal */
    .modal-content { border-radius: 14px; border: 1px solid #E1E4EA; }
    .modal-header, .modal-footer { border-color: #E1E4EA; }
    .modal-title { font-family: 'Space Grotesk', sans-serif; font-weight: 600; color: #101B2D; }

    .btn-secondary { background-color: #fff; border-color: #E1E4EA; color: #4B5768; }
    .btn-secondary:hover { background-color: #F4F5F8; border-color: #E1E4EA; color: #101B2D; }

    /* Pagination */
    .pagination .page-link { color: #101B2D; border-color: #E1E4EA; }
    .pagination .page-item.active .page-link { background-color: #FF6A3D; border-color: #FF6A3D; }
    .pagination .page-link:hover { color: #C74E22; }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1>Pengajuan Barang</h1>
            <p class="text-muted mb-0">Kelola pengajuan barang dari pengguna</p>
        </div>
        <div>
            <a href="{{ route('item-requests.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Tambah Pengajuan
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card">
        <div class="card-header bg-white">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="mb-0">
                        <i class="fas fa-clipboard-list me-2"></i>
                        Daftar Pengajuan Barang
                    </h5>
                </div>
                <div class="col-md-6">
                    <form method="GET" action="{{ route('item-requests.index') }}" class="d-flex">
                        <input type="text" name="search" class="form-control me-2"
                               placeholder="Cari nama atau deskripsi barang..."
                               value="{{ request('search') }}">
                        <button type="submit" class="btn btn-outline-primary">
                            <i class="fas fa-search"></i>
                        </button>
                        @if(request('search'))
                        <a href="{{ route('item-requests.index') }}" class="btn btn-outline-secondary ms-2">
                            <i class="fas fa-times"></i>
                        </a>
                        @endif
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            @if($itemRequests->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Pengaju</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($itemRequests as $index => $itemRequest)
                        <tr>
                            <td>{{ $itemRequests->firstItem() + $index }}</td>
                            <td>
                                <div class="fw-bold">{{ $itemRequest->name }}</div>
                                <small class="text-muted">{{ Str::limit($itemRequest->description, 50) }}</small>
                            </td>
                            <td>
                                @if($itemRequest->requestedBy)
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-user me-2 text-primary"></i>
                                    <div>
                                        <div class="fw-bold">{{ $itemRequest->requestedBy->name }}</div>
                                        <small class="text-muted">{{ $itemRequest->requestedBy->email }}</small>
                                    </div>
                                </div>
                                @else
                                <span class="text-muted">Tidak diketahui</span>
                                @endif
                            </td>
                            <td>
                                <div>{{ $itemRequest->request_date->format('d M Y') }}</div>
                                <small class="text-muted">{{ $itemRequest->request_date->diffForHumans() }}</small>
                            </td>
                            <td>
                                @if($itemRequest->status == 'pending')
                                <span class="badge bg-warning text-dark">
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
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('item-requests.show', $itemRequest) }}"
                                       class="btn btn-sm btn-outline-info" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('item-requests.edit', $itemRequest) }}"
                                       class="btn btn-sm btn-outline-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $itemRequest->id }}" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal{{ $itemRequest->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Konfirmasi Hapus</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Apakah Anda yakin ingin menghapus pengajuan barang <strong>{{ $itemRequest->name }}</strong>?</p>
                                                <p class="text-muted">Tindakan ini tidak dapat dibatalkan.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <form action="{{ route('item-requests.destroy', $itemRequest) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Hapus</button>
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

            <div class="card-footer bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted">
                        Menampilkan {{ $itemRequests->firstItem() }} - {{ $itemRequests->lastItem() }}
                        dari {{ $itemRequests->total() }} pengajuan
                    </div>
                    <div>
                        {{ $itemRequests->links() }}
                    </div>
                </div>
            </div>
            @else
            <div class="text-center py-5">
                <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Belum ada pengajuan barang</h5>
                <p class="text-muted">
                    @if(request('search'))
                    Tidak ada pengajuan yang sesuai dengan pencarian "{{ request('search') }}"
                    @else
                    Mulai dengan menambahkan pengajuan barang baru
                    @endif
                </p>
                @if(!request('search'))
                <a href="{{ route('item-requests.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> Tambah Pengajuan Pertama
                </a>
                @endif
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
