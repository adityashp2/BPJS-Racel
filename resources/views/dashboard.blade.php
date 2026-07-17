@extends('layouts.app')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@600;700&family=IBM+Plex+Mono:wght@500;600&display=swap" rel="stylesheet">
<style>
    .container-fluid {
        font-family: 'Inter', sans-serif;
        color: #101B2D;
    }

    h1.mb-4 {
        font-family: 'Space Grotesk', sans-serif;
        font-weight: 700;
        color: #101B2D;
    }

    /* Alerts */
    .alert {
        border-radius: 10px;
        border: 1px solid transparent;
        font-size: 0.92rem;
    }
    .alert-success { background: rgba(18, 128, 92, 0.10); color: #12805C; border-color: rgba(18, 128, 92, 0.25); }
    .alert-warning { background: rgba(242, 169, 59, 0.16); color: #8a5a12; border-color: rgba(242, 169, 59, 0.32); }
    .alert-danger  { background: rgba(214, 69, 69, 0.10); color: #D64545; border-color: rgba(214, 69, 69, 0.25); }

    /* Stat cards */
    .stat-card {
        background: #fff;
        border: 1px solid #E1E4EA;
        border-radius: 14px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 14px rgba(16, 27, 45, 0.04);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 14px 30px rgba(16, 27, 45, 0.08);
    }
    .stat-card h3 {
        font-family: 'Space Grotesk', sans-serif;
        font-weight: 700;
        font-size: 1.9rem;
        margin: 0.6rem 0 0.15rem;
        color: #101B2D;
    }
    .stat-card p {
        font-size: 0.85rem;
        color: #4B5768;
        margin: 0;
    }
    .card-icon {
        width: 46px;
        height: 46px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 1.1rem;
    }
    .card-icon.primary { background: #FF6A3D; }
    .card-icon.info { background: #2F6FB0; }

    /* Cards */
    .card {
        border: 1px solid #E1E4EA;
        border-radius: 14px;
        box-shadow: 0 4px 14px rgba(16, 27, 45, 0.04);
    }
    .card-header {
        border-bottom: 1px solid #E1E4EA;
        border-radius: 14px 14px 0 0 !important;
    }
    .card-title {
        font-family: 'Space Grotesk', sans-serif;
        font-weight: 600;
        font-size: 1rem;
        color: #101B2D;
        margin: 0;
    }

    /* Tables */
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
    .badge-status {
        display: inline-block;
        padding: 0.3rem 0.65rem;
        border-radius: 6px;
        font-size: 0.78rem;
        font-weight: 600;
    }
    .bg-danger { background-color: #D64545 !important; }

    /* Buttons & badges */
    .btn-primary {
        background-color: #FF6A3D;
        border-color: #FF6A3D;
    }
    .btn-primary:hover {
        background-color: #C74E22;
        border-color: #C74E22;
    }
    .btn-outline-primary {
        color: #FF6A3D;
        border-color: #FF6A3D;
    }
    .btn-outline-primary:hover {
        background-color: #FF6A3D;
        border-color: #FF6A3D;
        color: #fff;
    }
    .badge.bg-primary { background-color: #FF6A3D !important; }

    .list-group-item { border-color: #E1E4EA; }
</style>
@endpush

@section('content')
<div class="container-fluid">
    {{-- if any flash message, show it --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- if any warning, show it --}}
    @if (session('warning'))
        <div class="alert alert-warning">
            {{ session('warning') }}
        </div>
    @endif

    {{-- if any error, show it --}}
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Dasbor</h1>
        </div>
    </div>

    @if (Auth::user()->role == 'admin')
        <!-- Admin Dashboard Content -->
        <!-- Stats Row -->
        <div class="row">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="card-icon primary">
                        <i class="fas fa-box-open"></i>
                    </div>
                    <h3>{{ $totalPickups }}</h3>
                    <p>Total Pengambilan</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="card-icon" style="background-color: #12805C;">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>{{ $totalUsers }}</h3>
                    <p>Pengguna Terdaftar</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="card-icon" style="background-color: #F2A93B;">
                        <i class="fas fa-calendar-day"></i>
                    </div>
                    <h3>{{ $recentPickups }}</h3>
                    <p>Pengambilan Terbaru (7h)</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="card-icon info">
                        <i class="fas fa-box"></i>
                    </div>
                    <h3>{{ $totalItems }}</h3>
                    <p>Total Barang</p>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row mt-4">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="card-title">Ringkasan Pengambilan Bulanan</h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container" style="height: 300px; position: relative;">
                            <canvas id="pickupsChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h5 class="card-title">Distribusi Pengambilan per Bulan</h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container" style="height: 300px; position: relative;">
                            <canvas id="monthChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="card-title">Distribusi Divisi Pengguna</h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container" style="height: 300px; position: relative;">
                            <canvas id="divisionChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Inventory Status Row -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="card-title">Barang Stok Rendah</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Kode Barang</th>
                                        <th>Nama</th>
                                        <th>Stok Saat Ini</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($lowStockItems as $item)
                                    <tr>
                                        <td>{{ $item->code }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->stock }}</td>
                                        <td>
                                            @if($item->stock == 0)
                                            <span class="badge-status bg-danger text-white">Stok Habis</span>
                                            @else
                                            <span class="badge-status text-white" style="background-color: #F2A93B;">Stok Rendah</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-3">
                                            <p class="mb-0 text-muted">Semua barang memiliki stok yang cukup</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="card-title">Barang Paling Sering Diambil</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Barang</th>
                                        <th>Jumlah Pengambilan</th>
                                        <th>Stok Tersedia</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($topPickedItems as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->pickup_count }}</td>
                                        <td>
                                            <span class="badge-status text-white"
                                                style="background-color: {{ $item->stock > 10 ? '#12805C' : ($item->stock > 0 ? '#F2A93B' : '#D64545') }}">
                                                {{ $item->stock }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-3">
                                            <p class="mb-0 text-muted">Belum ada aktivitas pengambilan</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Pickups Table -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Pengambilan Terbaru</h5>
                        <a href="{{ route('item-pickups.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Barang</th>
                                        <th>Pengguna</th>
                                        <th>Jumlah</th>
                                        <th>Tanggal Pengambilan</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentPickupsList as $pickup)
                                    <tr>
                                        <td>{{ $pickup->item?->name ?? 'N/A' }}</td>
                                        <td>{{ $pickup->user?->name ?? 'N/A' }}</td>
                                        <td>{{ $pickup->quantity }}</td>
                                        <td>{{ $pickup->taken_date->format('d M Y') }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('item-pickups.edit', $pickup) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="fas fa-box-open fa-3x mb-3 text-muted"></i>
                                                <h5>Tidak ada pengambilan ditemukan</h5>
                                                <p class="mb-0">Mulailah dengan membuat pengambilan barang pertama Anda</p>
                                                <div class="mt-3">
                                                    <a href="{{ route('item-pickups.create') }}" class="btn btn-primary">
                                                        <i class="fas fa-plus me-1"></i> Buat Pengambilan Baru
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- User Dashboard Content -->
        <!-- Stats Row -->
        <div class="row">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="card-icon primary">
                        <i class="fas fa-box-open"></i>
                    </div>
                    <h3>{{ $userTotalPickups }}</h3>
                    <p>Total Pengambilan Anda</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="card-icon" style="background-color: #12805C;">
                        <i class="fas fa-calendar-day"></i>
                    </div>
                    <h3>{{ $userRecentPickups }}</h3>
                    <p>Pengambilan Terbaru (7h)</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="card-icon" style="background-color: #F2A93B;">
                        <i class="fas fa-box"></i>
                    </div>
                    <h3>{{ $userTotalItems }}</h3>
                    <p>Jenis Barang Diambil</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="card-icon info">
                        <i class="fas fa-cubes"></i>
                    </div>
                    <h3>{{ $userTotalQuantity }}</h3>
                    <p>Total Unit Diambil</p>
                </div>
            </div>
        </div>

        <!-- Charts and Recent Pickups -->
        <div class="row mt-4">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="card-title">Riwayat Pengambilan Anda</h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container" style="height: 300px; position: relative;">
                            <canvas id="userPickupsChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Pengambilan Terbaru Anda</h5>
                        <a href="{{ route('item-pickups.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus me-1"></i> Baru
                        </a>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @forelse($userRecentPickupsList as $pickup)
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">{{ $pickup->item->name }}</h6>
                                            <small class="text-muted">
                                                <i class="far fa-calendar-alt me-1"></i>
                                                {{ $pickup->taken_date->format('d M Y') }}
                                            </small>
                                        </div>
                                        <span class="badge bg-primary rounded-pill">{{ $pickup->quantity }} unit</span>
                                    </div>
                                </div>
                            @empty
                                <div class="list-group-item py-4 text-center">
                                    <i class="fas fa-box-open fa-2x mb-2 text-muted"></i>
                                    <p class="mb-0">Anda belum melakukan pengambilan barang</p>
                                    <a href="{{ route('item-pickups.create') }}" class="btn btn-sm btn-primary mt-2">
                                        <i class="fas fa-plus me-1"></i> Buat Pengambilan Baru
                                    </a>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
@if (Auth::user()->role == 'admin')
    // Pickups Chart
    const pickupsCtx = document.getElementById('pickupsChart').getContext('2d');
    const pickupsChart = new Chart(pickupsCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($monthlyPickupsLabels) !!},
            datasets: [{
                label: 'Pengambilan',
                data: {!! json_encode($monthlyPickupsData) !!},
                backgroundColor: 'rgba(255, 106, 61, 0.15)',
                borderColor: '#FF6A3D',
                borderWidth: 2,
                tension: 0.3
            }]
        },
        options: {
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });

    // Month Chart
    const monthCtx = document.getElementById('monthChart').getContext('2d');
    const monthChart = new Chart(monthCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($pickupMonthLabels) !!},
            datasets: [{
                label: 'Pengambilan',
                data: {!! json_encode($pickupMonthData) !!},
                backgroundColor: [
                    '#FF6A3D', '#12805C', '#F2A93B', '#FF6A3D', '#12805C',
                    '#F2A93B', '#FF6A3D', '#12805C', '#F2A93B', '#FF6A3D',
                    '#12805C', '#F2A93B'
                ],
                borderWidth: 0
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // Division Chart
    const divisionCtx = document.getElementById('divisionChart').getContext('2d');

    // Generate unique colors for each division
    const divisionColors = [
        '#FF6A3D', // Accent Orange
        '#12805C', // Deep Teal
        '#F2A93B', // Amber
        '#2F6FB0', // Info Blue
        '#101B2D', // Ink Navy
        '#C74E22', // Accent Ink
        '#5B8A72', // Sage Green
        '#D64545', // Danger Red
        '#8A6D3B', // Bronze
        '#4B5768', // Slate
        '#E08E45', // Light Amber
        '#1E5C46', // Forest Teal
        '#7A4A8F', // Muted Violet
        '#3F8FBF', // Sky Blue
        '#B5541F', // Rust
        '#6B7280', // Gray
        '#2E8B75', // Emerald
        '#A63D3D', // Brick
        '#5C6B8A', // Steel Blue
        '#C99A3B'  // Gold
    ];

    const divisionChart = new Chart(divisionCtx, {
        type: 'pie',
        data: {
            labels: {!! json_encode($divisionLabels) !!},
            datasets: [{
                data: {!! json_encode($divisionData) !!},
                backgroundColor: divisionColors.slice(0, {!! count($divisionLabels) !!}),
                borderColor: '#ffffff',
                borderWidth: 3,
                hoverBorderWidth: 4,
                hoverOffset: 8
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: '#374151',
                        font: {
                            size: 12,
                            family: 'Inter'
                        },
                        padding: 15,
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(16, 27, 45, 0.9)',
                    titleColor: '#ffffff',
                    bodyColor: '#ffffff',
                    borderColor: '#e5e7eb',
                    borderWidth: 1,
                    cornerRadius: 8,
                    displayColors: true,
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.parsed;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((value / total) * 100).toFixed(1);
                            return `${label}: ${value} pengguna (${percentage}%)`;
                        }
                    }
                }
            },
            animation: {
                animateRotate: true,
                animateScale: true,
                duration: 1000
            },
            interaction: {
                intersect: false,
                mode: 'nearest'
            }
        }
    });
@else
    // User Pickups Chart
    const userPickupsCtx = document.getElementById('userPickupsChart').getContext('2d');
    const userPickupsChart = new Chart(userPickupsCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($userMonthlyPickupsLabels) !!},
            datasets: [{
                label: 'Pengambilan Anda',
                data: {!! json_encode($userMonthlyPickupsData) !!},
                backgroundColor: 'rgba(18, 128, 92, 0.15)',
                borderColor: '#12805C',
                borderWidth: 2,
                tension: 0.3
            }]
        },
        options: {
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });
@endif
</script>
@endpush
