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

    .alert-success {
        background: rgba(18, 128, 92, 0.10);
        color: var(--accent-2);
        border-color: rgba(18, 128, 92, 0.25);
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

    /* ===== STICKY CARD ===== */
    .sticky-card {
        position: sticky;
        top: 85px;
        z-index: 2;
    }

    /* ===== TABLE ===== */
    .table-borderless td,
    .table-borderless th {
        padding: 0.7rem 0.5rem;
        border: none;
        vertical-align: middle;
    }

    .table-borderless th {
        font-weight: 600;
        color: var(--ink-soft);
        font-size: 0.85rem;
        width: 30%;
    }

    .table-borderless td {
        font-weight: 500;
        color: var(--ink);
        font-size: 0.95rem;
    }

    /* ===== BADGES ===== */
    .badge {
        font-weight: 600;
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
        font-size: 0.78rem;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    .badge.bg-success {
        background-color: var(--accent-2) !important;
        color: #fff !important;
    }

    .badge.bg-warning {
        background-color: #F2A93B !important;
        color: var(--ink) !important;
    }

    .badge.bg-danger {
        background-color: var(--danger) !important;
        color: #fff !important;
    }

    .badge.bg-info {
        background-color: #2F6FB0 !important;
        color: #fff !important;
    }

    /* ===== STATUS BADGE ===== */
    .status-badge {
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.8rem;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    .status-badge.in-stock {
        background: rgba(18, 128, 92, 0.15);
        color: var(--accent-2);
    }

    .status-badge.out-of-stock {
        background: rgba(214, 69, 69, 0.15);
        color: var(--danger);
    }

    .status-badge.low-stock {
        background: rgba(242, 169, 59, 0.15);
        color: #b8791f;
    }

    /* ===== BUTTONS ===== */
    .btn {
        font-weight: 600;
        border-radius: 9px;
        padding: 0.6rem 1.2rem;
        font-size: 0.9rem;
        transition: all 0.2s ease;
    }

    .btn-warning {
        background: #F2A93B;
        border-color: #F2A93B;
        color: var(--ink);
    }

    .btn-warning:hover {
        background: #d99a2e;
        border-color: #d99a2e;
        color: var(--ink);
        transform: translateY(-1px);
        box-shadow: 0 8px 20px rgba(242, 169, 59, 0.25);
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

    /* ===== IMAGE PLACEHOLDER ===== */
    .image-placeholder {
        background: var(--paper);
        border-radius: 9px;
        padding: 3rem 2rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 250px;
    }

    .image-placeholder i {
        color: var(--line);
        font-size: 4rem;
        margin-bottom: 1rem;
    }

    .image-placeholder p {
        color: var(--ink-soft);
        margin-bottom: 0;
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

    /* ===== CHART CONTAINER ===== */
    .chart-container {
        position: relative;
        height: 250px;
        width: 100%;
        margin: 0 auto;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 992px) {
        .sticky-card {
            position: relative;
            top: 0;
        }
    }

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

        .table-borderless th {
            width: 40%;
            font-size: 0.8rem;
        }

        .table-borderless td {
            font-size: 0.85rem;
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
            min-width: 120px;
        }

        .image-placeholder {
            min-height: 180px;
            padding: 2rem 1rem;
        }

        .image-placeholder i {
            font-size: 3rem;
        }

        .card-footer .d-flex {
            flex-direction: column;
            gap: 0.5rem;
            align-items: flex-start !important;
        }
    }

    @media (max-width: 576px) {
        .container-fluid {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }

        .table-borderless th {
            width: 45%;
            font-size: 0.75rem;
        }

        .table-borderless td {
            font-size: 0.8rem;
        }

        .badge {
            font-size: 0.7rem;
            padding: 0.3rem 0.6rem;
        }

        .chart-container {
            height: 200px;
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
                        <i class="fas fa-box me-2" style="color: var(--accent);"></i>
                        Detail Barang
                    </h1>
                    <p class="text-muted mb-0">Informasi lengkap tentang barang</p>
                </div>
                <div class="mt-2 mt-md-0">
                    <a href="{{ route('items.edit', $item) }}" class="btn btn-warning me-2">
                        <i class="fas fa-edit me-1"></i> Edit Barang
                    </a>
                    <a href="{{ route('items.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== ALERTS ===== -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- ===== MAIN CONTENT ===== -->
    <div class="row">
        <!-- ===== LEFT COLUMN: IMAGE ===== -->
        <div class="col-lg-4 mb-4">
            <div class="card sticky-card">
                <div class="card-header bg-white">
                    <h5>
                        <i class="fas fa-image me-2" style="color: var(--accent);"></i>
                        Gambar Barang
                    </h5>
                </div>
                <div class="card-body text-center">
                    @if($item->image)
                    <img src="{{ asset('storage/' . $item->image) }}"
                         alt="{{ $item->name }}"
                         class="img-fluid rounded"
                         style="max-height: 300px; width: auto; object-fit: contain;">
                    <div class="mt-2">
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Klik gambar untuk melihat ukuran penuh
                        </small>
                    </div>
                    @else
                    <div class="image-placeholder">
                        <i class="fas fa-image"></i>
                        <p>Tidak ada gambar tersedia</p>
                        <small class="text-muted">Unggah gambar melalui halaman edit</small>
                    </div>
                    @endif
                </div>
            </div>

            <!-- ===== STOCK SUMMARY CARD (Mobile) ===== -->
            <div class="card mt-3 d-lg-none">
                <div class="card-header bg-white">
                    <h5>
                        <i class="fas fa-chart-pie me-2" style="color: var(--accent);"></i>
                        Ringkasan Stok
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="bg-success bg-opacity-10 rounded p-3">
                                <div class="fw-bold" style="font-size: 1.5rem; color: var(--accent-2);">
                                    {{ $item->stock }}
                                </div>
                                <div class="text-muted small">Stok Tersedia</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-primary bg-opacity-10 rounded p-3">
                                <div class="fw-bold" style="font-size: 1.5rem; color: #2F6FB0;">
                                    {{ $currentLoans->sum('quantity') }}
                                </div>
                                <div class="text-muted small">Sedang Dipinjam</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== RIGHT COLUMN ===== -->
        <div class="col-lg-8">
            <!-- ===== INFORMASI UMUM ===== -->
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5>
                        <i class="fas fa-info-circle me-2" style="color: var(--accent);"></i>
                        Informasi Umum
                    </h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <th>
                                    <i class="fas fa-barcode me-2" style="color: var(--accent);"></i>
                                    Kode Barang
                                </th>
                                <td>
                                    <span class="code-badge" style="background: var(--paper); padding: 0.2rem 0.6rem; border-radius: 4px; font-family: 'IBM Plex Mono', monospace; border: 1px solid var(--line);">
                                        {{ $item->code }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <i class="fas fa-tag me-2" style="color: var(--accent);"></i>
                                    Nama Barang
                                </th>
                                <td>
                                    <strong>{{ $item->name }}</strong>
                                    @if($item->category)
                                    <span class="badge bg-info ms-2">
                                        <i class="fas fa-folder me-1"></i>
                                        {{ $item->category->name }}
                                    </span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <i class="fas fa-link me-2" style="color: var(--accent);"></i>
                                    Slug
                                </th>
                                <td>
                                    <code style="background: var(--paper); padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.85rem;">
                                        {{ $item->slug }}
                                    </code>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <i class="fas fa-boxes me-2" style="color: var(--accent);"></i>
                                    Stok
                                </th>
                                <td>
                                    @if($item->stock > 20)
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle me-1"></i>
                                        {{ $item->stock }} unit
                                    </span>
                                    @elseif($item->stock > 5)
                                    <span class="badge bg-info">
                                        <i class="fas fa-minus-circle me-1"></i>
                                        {{ $item->stock }} unit
                                    </span>
                                    @elseif($item->stock > 0)
                                    <span class="badge bg-warning">
                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                        {{ $item->stock }} unit
                                    </span>
                                    @else
                                    <span class="badge bg-danger">
                                        <i class="fas fa-times-circle me-1"></i>
                                        {{ $item->stock }} unit
                                    </span>
                                    @endif
                                    <span class="text-muted ms-2" style="font-size: 0.85rem;">
                                        @if($item->stock > 20)
                                        (Stok aman)
                                        @elseif($item->stock > 5)
                                        (Stok sedang)
                                        @elseif($item->stock > 0)
                                        (Stok rendah)
                                        @else
                                        (Stok habis)
                                        @endif
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <i class="fas fa-circle me-2" style="color: var(--accent);"></i>
                                    Status
                                </th>
                                <td>
                                    @if($item->stock > 20)
                                    <span class="status-badge in-stock">
                                        <i class="fas fa-check-circle me-1"></i>
                                        Tersedia
                                    </span>
                                    @elseif($item->stock > 0)
                                    <span class="status-badge low-stock">
                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                        Stok Terbatas
                                    </span>
                                    @else
                                    <span class="status-badge out-of-stock">
                                        <i class="fas fa-times-circle me-1"></i>
                                        Stok Habis
                                    </span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- ===== DESKRIPSI ===== -->
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5>
                        <i class="fas fa-align-left me-2" style="color: var(--accent);"></i>
                        Deskripsi
                    </h5>
                </div>
                <div class="card-body">
                    @if($item->description)
                    <div style="white-space: pre-wrap; line-height: 1.8;">
                        {{ $item->description }}
                    </div>
                    @else
                    <div class="text-center py-3">
                        <i class="fas fa-file-alt fa-2x text-muted mb-2 d-block"></i>
                        <p class="text-muted mb-0">Tidak ada deskripsi tersedia untuk barang ini</p>
                    </div>
                    @endif
                </div>
                <div class="card-footer bg-white">
                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class="fas fa-calendar-plus me-1"></i>
                            Dibuat: {{ $item->created_at->format('d M Y H:i') }}
                        </small>
                        <small class="text-muted">
                            <i class="fas fa-clock me-1"></i>
                            Terakhir Diperbarui: {{ $item->updated_at->format('d M Y H:i') }}
                        </small>
                    </div>
                </div>
            </div>

            <!-- ===== DIVISION LOAN CHART ===== -->
            @if($currentLoans->count() > 0)
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5>
                        <i class="fas fa-chart-pie me-2" style="color: var(--accent);"></i>
                        Distribusi Peminjaman per Divisi
                    </h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="divisionPieChart"></canvas>
                    </div>
                    <div class="mt-3">
                        <div class="row g-2">
                            <div class="col-md-6">
                                <div class="bg-light rounded p-2 text-center">
                                    <div class="text-muted small">Total Stok</div>
                                    <div class="fw-bold" style="font-size: 1.2rem;">{{ $item->stock }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="bg-light rounded p-2 text-center">
                                    <div class="text-muted small">Sedang Dipinjam</div>
                                    <div class="fw-bold" style="font-size: 1.2rem; color: #2F6FB0;">{{ $currentLoans->sum('quantity') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- ===== DANGER ZONE ===== -->
            <div class="card border-danger">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Zona Bahaya
                    </h5>
                </div>
                <div class="card-body" style="background: #fef6f6;">
                    <p class="text-muted mb-3">
                        <i class="fas fa-skull me-1"></i>
                        Hapus barang ini secara permanen dari sistem. Tindakan ini tidak dapat dibatalkan.
                    </p>
                    @if($currentLoans->count() > 0)
                    <div class="alert alert-warning" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Perhatian!</strong> Barang ini sedang dipinjam oleh {{ $currentLoans->count() }} peminjam.
                        Hapus hanya jika yakin.
                    </div>
                    @endif
                    <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="fas fa-trash me-1"></i> Hapus Barang
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
                <p>Apakah Anda yakin ingin menghapus barang <strong>{{ $item->name }}</strong>?</p>
                <div class="alert alert-danger" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    Tindakan ini <strong>tidak dapat dibatalkan</strong>.
                    Semua data terkait akan hilang secara permanen.
                </div>
                <div class="bg-light rounded p-3">
                    <small class="text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        Kode Barang: <strong>{{ $item->code }}</strong>
                        @if($item->stock > 0)
                        <span class="mx-2">|</span>
                        Stok tersedia: <strong>{{ $item->stock }}</strong>
                        @endif
                        @if($currentLoans->count() > 0)
                        <span class="mx-2">|</span>
                        Dipinjam: <strong>{{ $currentLoans->count() }}</strong> peminjam
                        @endif
                    </small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Batal
                </button>
                <form action="{{ route('items.destroy', $item) }}" method="POST" class="d-inline">
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ===== CHART DATA =====
        const availableStock = {{ $item->stock }};
        const loansByDivision = @json(
            $currentLoans->groupBy(fn($loan) => $loan->user->jobDivision?->name ?? 'Belum Ditugaskan')
                ->map(fn($loans) => $loans->sum('quantity'))
        );

        // Only create chart if there are loans
        @if($currentLoans->count() > 0)
        const labels = ['Stok Tersedia', ...Object.keys(loansByDivision)];
        const data = [availableStock, ...Object.values(loansByDivision)];
        const colors = [
            '#10b981', // available - green
            '#4e73df', '#f6c23e', '#e74a3b', '#36b9cc',
            '#fd7e14', '#20c997', '#6f42c1', '#858796', '#5a5c69'
        ];

        const ctx = document.getElementById('divisionPieChart').getContext('2d');

        // Check if chart already exists and destroy it
        if (window.divisionChart) {
            window.divisionChart.destroy();
        }

        window.divisionChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: colors.slice(0, labels.length),
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 15,
                            usePointStyle: true,
                            pointStyle: 'circle',
                            font: {
                                size: 11,
                                family: 'Inter, sans-serif'
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                let value = context.parsed || 0;
                                let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                let percentage = ((value / total) * 100).toFixed(1);
                                return label + ': ' + value + ' unit (' + percentage + '%)';
                            }
                        }
                    }
                },
                cutout: '0%'
            }
        });
        @endif

        // ===== IMAGE CLICK TO OPEN FULL SIZE =====
        const detailImage = document.querySelector('.card-body img');
        if (detailImage) {
            detailImage.style.cursor = 'pointer';
            detailImage.addEventListener('click', function() {
                // You can implement a lightbox here if needed
                window.open(this.src, '_blank');
            });
        }
    });
</script>
@endpush
@endsection
