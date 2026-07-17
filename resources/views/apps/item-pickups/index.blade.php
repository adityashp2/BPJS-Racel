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
    .alert-warning { background: rgba(242, 169, 59, 0.16); color: #8a5a12; border-color: rgba(242, 169, 59, 0.32); }

    .card { border: 1px solid #E1E4EA; border-radius: 14px; box-shadow: 0 4px 14px rgba(16, 27, 45, 0.04); }
    .card-header { border-bottom: 1px solid #E1E4EA; }
    .card-header h5 { font-family: 'Space Grotesk', sans-serif; font-weight: 600; color: #101B2D; }

    /* Buttons beyond primary/outline-primary (already global) */
    .btn-warning { background-color: #F2A93B; border-color: #F2A93B; color: #fff; }
    .btn-warning:hover { background-color: #d68f22; border-color: #d68f22; color: #fff; }
    .btn-info { background-color: #2F6FB0; border-color: #2F6FB0; color: #fff; }
    .btn-info:hover { background-color: #255a8c; border-color: #255a8c; color: #fff; }
    .btn-success { background-color: #12805C; border-color: #12805C; }
    .btn-success:hover { background-color: #0d6249; border-color: #0d6249; }
    .btn-danger { background-color: #D64545; border-color: #D64545; }
    .btn-danger:hover { background-color: #b83636; border-color: #b83636; }
    .btn-outline-danger { color: #D64545; border-color: #D64545; }
    .btn-outline-danger:hover { background-color: #D64545; border-color: #D64545; }

    /* Badge / bg utility (bg-info not yet global) */
    .bg-info { background-color: #2F6FB0 !important; }
    .bg-secondary { background-color: #4B5768 !important; }

    /* Stat cards on the user history view */
    .card.bg-primary, .card.bg-success, .card.bg-info, .card.bg-warning {
        border: none;
        border-radius: 14px;
    }

    /* Table */
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

    /* Search box focus */
    .card-header form .form-control:focus {
        border-color: #FF6A3D;
        box-shadow: 0 0 0 0.2rem rgba(255, 106, 61, 0.12);
    }

    /* Modal */
    .modal-content { border-radius: 14px; border: 1px solid #E1E4EA; }
    .modal-header, .modal-footer { border-color: #E1E4EA; }
    .modal-title { font-family: 'Space Grotesk', sans-serif; font-weight: 600; color: #101B2D; }

    /* Pagination */
    .pagination .page-link {
        color: #101B2D;
        border-color: #E1E4EA;
    }
    .pagination .page-item.active .page-link {
        background-color: #FF6A3D;
        border-color: #FF6A3D;
    }
    .pagination .page-link:hover {
        color: #C74E22;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    @if (Auth::user()->role == 'admin')
        <!-- Admin View -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Manajemen Pengambilan Barang</h1>
            <div>
                <a href="{{ route('item-pickups.report') }}" class="btn btn-info me-2">
                    <i class="fas fa-chart-line me-1"></i> Buat Laporan
                </a>
                <a href="{{ route('item-pickups.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Buat Pengambilan Baru
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
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Semua Pengambilan Barang</h5>
                <form action="{{ route('item-pickups.index') }}" method="GET" class="d-flex">
                    <input type="text" name="search" class="form-control me-2" placeholder="Cari..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Barang</th>
                                <th>Pengguna</th>
                                <th>Jumlah</th>
                                <th>Tanggal Pengambilan</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($itemPickups as $pickup)
                            <tr>
                                <td>{{ $loop->iteration + ($itemPickups->currentPage() - 1) * $itemPickups->perPage() }}</td>
                                <td>{{ $pickup->item?->name ?? 'N/A' }}</td>
                                <td>{{ $pickup->user?->name ?? 'N/A' }}</td>
                                <td>{{ $pickup->quantity }}</td>
                                <td>{{ $pickup->taken_date ? $pickup->taken_date->format('d M Y') : '-' }}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ route('item-pickups.edit', $pickup) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $pickup->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $pickup->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $pickup->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel{{ $pickup->id }}">Konfirmasi Hapus</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Apakah Anda yakin ingin menghapus catatan pengambilan ini?</p>
                                                    <div class="alert alert-warning">
                                                        <p class="mb-0"><strong>Barang:</strong> {{ $pickup->item?->name ?? 'N/A' }}</p>
                                                        <p class="mb-0"><strong>Pengguna:</strong> {{ $pickup->user?->name ?? 'N/A' }}</p>
                                                        <p class="mb-0"><strong>Tanggal Pengambilan:</strong> {{ $pickup->taken_date ? $pickup->taken_date->format('d M Y') : '-' }}</p>
                                                    </div>
                                                    <p class="text-danger">Tindakan ini tidak dapat dibatalkan.</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <form action="{{ route('item-pickups.destroy', $pickup) }}" method="POST">
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
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="fas fa-box-open fa-3x mb-3 text-muted"></i>
                                        <h5>Tidak ada pengambilan barang ditemukan</h5>
                                        @if(request('search'))
                                        <p class="mb-0">Coba hapus pencarian atau buat pengambilan baru</p>
                                        <div class="mt-3">
                                            <a href="{{ route('item-pickups.index') }}" class="btn btn-outline-primary me-2">Hapus Pencarian</a>
                                            <a href="{{ route('item-pickups.create') }}" class="btn btn-primary">Buat Pengambilan Baru</a>
                                        </div>
                                        @else
                                        <p class="mb-0">Mulai dengan membuat pengambilan barang pertama Anda</p>
                                        <div class="mt-3">
                                            <a href="{{ route('item-pickups.create') }}" class="btn btn-primary">
                                                <i class="fas fa-plus me-1"></i> Buat Pengambilan Baru
                                            </a>
                                        </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        Menampilkan {{ $itemPickups->firstItem() ?? 0 }} sampai {{ $itemPickups->lastItem() ?? 0 }} dari {{ $itemPickups->total() }} entri
                    </div>
                    <div>
                        {{ $itemPickups->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- User View - History Pengambilan -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1>Riwayat Pengambilan Barang</h1>
                <p class="text-muted mb-0">Lihat semua barang yang pernah Anda ambil</p>
            </div>
            <div>
                <a href="{{ route('items.item-gallery') }}" class="btn btn-success me-2">
                    <i class="fas fa-images me-1"></i> Galeri Barang
                </a>
                {{-- <a href="{{ route('item-pickups.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Ambil Barang Baru
                </a> --}}
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

        <!-- User Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0">{{ $itemPickups->total() }}</h4>
                                <p class="mb-0">Total Pengambilan</p>
                            </div>
                            <i class="fas fa-box-open fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0">{{ $itemPickups->where('taken_date', '>=', now()->subDays(30))->count() }}</h4>
                                <p class="mb-0">Bulan Ini</p>
                            </div>
                            <i class="fas fa-calendar-month fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0">{{ $itemPickups->where('taken_date', '>=', now()->subDays(7))->count() }}</h4>
                                <p class="mb-0">Minggu Ini</p>
                            </div>
                            <i class="fas fa-calendar-week fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0">{{ $itemPickups->sum('quantity') }}</h4>
                                <p class="mb-0">Total Unit</p>
                            </div>
                            <i class="fas fa-cubes fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Riwayat Pengambilan Anda</h5>
                <form action="{{ route('item-pickups.index') }}" method="GET" class="d-flex">
                    <input type="text" name="search" class="form-control me-2" placeholder="Cari barang..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
            <div class="card-body p-0">
                @if($itemPickups->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Barang</th>
                                <th>Kode Barang</th>
                                <th>Jumlah</th>
                                <th>Tanggal Pengambilan</th>
                                <th>Status</th>
                                {{-- <th class="text-center">Aksi</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($itemPickups as $pickup)
                            <tr>
                                <td>{{ $loop->iteration + ($itemPickups->currentPage() - 1) * $itemPickups->perPage() }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($pickup->item?->image)
                                        <img src="{{ Storage::url($pickup->item->image) }}" alt="{{ $pickup->item->name }}" class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                        @else
                                        <div class="bg-light rounded me-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <i class="fas fa-box text-muted"></i>
                                        </div>
                                        @endif
                                        <div>
                                            <h6 class="mb-0">{{ $pickup->item?->name ?? 'N/A' }}</h6>
                                            <small class="text-muted">{{ Str::limit($pickup->item?->description, 30) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge bg-secondary">{{ $pickup->item?->code ?? 'N/A' }}</span></td>
                                <td>
                                    <span class="badge bg-primary rounded-pill">{{ $pickup->quantity }} unit</span>
                                </td>
                                <td>
                                    <div>
                                        <strong>{{ $pickup->taken_date ? $pickup->taken_date->format('d M Y') : '-' }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $pickup->taken_date ? $pickup->taken_date->format('H:i') : '' }}</small>
                                    </div>
                                </td>
                                <td>
                                    @if($pickup->taken_date && $pickup->taken_date->isToday())
                                    <span class="badge bg-success">Hari Ini</span>
                                    @elseif($pickup->taken_date && $pickup->taken_date->isYesterday())
                                    <span class="badge bg-info">Kemarin</span>
                                    @elseif($pickup->taken_date && $pickup->taken_date->diffInDays() <= 7)
                                    <span class="badge bg-warning">{{ $pickup->taken_date->diffForHumans() }}</span>
                                    @else
                                    <span class="badge bg-secondary">{{ $pickup->taken_date ? $pickup->taken_date->diffForHumans() : '-' }}</span>
                                    @endif
                                </td>
                                {{-- <td class="text-center">
                                    <a href="{{ route('item-pickups.edit', $pickup) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td> --}}
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-5">
                    <div class="d-flex flex-column align-items-center">
                        <i class="fas fa-history fa-4x mb-3 text-muted"></i>
                        <h5>Belum Ada Riwayat Pengambilan</h5>
                        @if(request('search'))
                        <p class="mb-0">Tidak ditemukan pengambilan dengan kata kunci "{{ request('search') }}"</p>
                        <div class="mt-3">
                            <a href="{{ route('item-pickups.index') }}" class="btn btn-outline-primary me-2">Hapus Pencarian</a>
                            <a href="{{ route('items.item-gallery') }}" class="btn btn-primary">Lihat Galeri Barang</a>
                        </div>
                        @else
                        <p class="mb-0">Mulai dengan mengambil barang pertama Anda dari galeri</p>
                        <div class="mt-3">
                            <a href="{{ route('items.item-gallery') }}" class="btn btn-success me-2">
                                <i class="fas fa-images me-1"></i> Lihat Galeri Barang
                            </a>
                            <a href="{{ route('item-pickups.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i> Ambil Barang Baru
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
            @if($itemPickups->hasPages())
            <div class="card-footer bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        Menampilkan {{ $itemPickups->firstItem() ?? 0 }} sampai {{ $itemPickups->lastItem() ?? 0 }} dari {{ $itemPickups->total() }} entri
                    </div>
                    <div>
                        {{ $itemPickups->withQueryString()->links() }}
                    </div>
                </div>
            </div>
            @endif
        </div>
    @endif
</div>
@endsection
