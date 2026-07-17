@extends('layouts.app')

@push('styles')
<style>
    h1 {
        font-family: 'Space Grotesk', sans-serif;
        font-weight: 700;
        color: #101B2D;
        font-size: 1.9rem;
    }

    .card { border: 1px solid #E1E4EA; border-radius: 14px; box-shadow: 0 4px 14px rgba(16, 27, 45, 0.04); }
    .card-header { border-bottom: 1px solid #E1E4EA; }
    .card-header h5, .card-title { font-family: 'Space Grotesk', sans-serif; font-weight: 600; color: #101B2D; }

    .form-label {
        font-weight: 600;
        font-size: 0.88rem;
        color: #101B2D;
        margin-bottom: 0.4rem;
    }

    .form-control, .form-select {
        border: 1px solid #E1E4EA;
        border-radius: 9px;
        padding: 0.5rem 0.8rem;
        font-size: 0.92rem;
    }

    .form-control:focus, .form-select:focus {
        border-color: #FF6A3D;
        box-shadow: 0 0 0 0.2rem rgba(255, 106, 61, 0.15);
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

    .pagination .page-link { color: #101B2D; border-color: #E1E4EA; }
    .pagination .page-item.active .page-link { background-color: #FF6A3D; border-color: #FF6A3D; }
    .pagination .page-link:hover { color: #C74E22; }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Laporan Pengambilan Barang</h1>
        <div>
            <button id="printPdf" class="btn btn-primary">
                <i class="fas fa-file-pdf me-1"></i> <span id="exportBtnText">Export PDF</span>
                <span id="exportSpinner" class="spinner-border spinner-border-sm ms-1" role="status" style="display: none;"></span>
            </button>
            <button id="downloadHtml" class="btn btn-outline-secondary ms-2 d-none">
                <i class="fas fa-file-alt me-1"></i> Unduh sebagai HTML
            </button>
            <a href="{{ route('item-pickups.index') }}" class="btn btn-outline-primary ms-2">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Filter Card -->
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Filter Laporan</h5>
                </div>
                <div class="card-body">
                    <form id="reportFilterForm" action="{{ route('item-pickups.report') }}" method="GET" class="row g-3">
                        <div class="col-md-3">
                            <label for="start_date" class="form-label">Dari Tanggal</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date', now()->subDays(30)->format('Y-m-d')) }}">
                        </div>
                        <div class="col-md-3">
                            <label for="end_date" class="form-label">Sampai Tanggal</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date', now()->format('Y-m-d')) }}">
                        </div>
                        <div class="col-md-3">
                            <label for="item_id" class="form-label">Barang (Opsional)</label>
                            <select class="form-select" id="item_id" name="item_id">
                                <option value="">Semua Barang</option>
                                @foreach($items as $item)
                                    <option value="{{ $item->id }}" {{ request('item_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="user_id" class="form-label">Pengguna (Opsional)</label>
                            <select class="form-select" id="user_id" name="user_id">
                                <option value="">Semua Pengguna</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-filter me-1"></i> Terapkan Filter
                            </button>
                            <a href="{{ route('item-pickups.report') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-undo me-1"></i> Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Report Summary Section -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="card-icon" style="background-color: #FF6A3D;">
                    <i class="fas fa-box-open"></i>
                </div>
                <h3>{{ $totalPickups }}</h3>
                <p>Total Pengambilan</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="card-icon" style="background-color: #12805C;">
                    <i class="fas fa-cubes"></i>
                </div>
                <h3>{{ $totalQuantity }}</h3>
                <p>Total Barang Diambil</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="card-icon" style="background-color: #F2A93B;">
                    <i class="fas fa-users"></i>
                </div>
                <h3>{{ $uniqueUsers }}</h3>
                <p>Pengguna Unik</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="card-icon" style="background-color: #2F6FB0;">
                    <i class="fas fa-shapes"></i>
                </div>
                <h3>{{ $uniqueItems }}</h3>
                <p>Barang Unik</p>
            </div>
        </div>
    </div>

    <!-- Report Content -->
    <div class="card">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Detail Pengambilan</h5>
            <span class="text-muted">
                Menampilkan data dari {{ request('start_date', now()->subDays(30)->format('d M Y')) }}
                sampai {{ request('end_date', now()->format('d M Y')) }}
            </span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover" id="pickupReportTable">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Barang</th>
                            <th>Pengguna</th>
                            <th>Divisi</th>
                            <th>Jumlah</th>
                            <th>Tanggal Pengambilan</th>
                            <th>Waktu Pengambilan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($itemPickups as $pickup)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $pickup->item?->name ?? 'N/A' }}</td>
                            <td>{{ $pickup->user?->name ?? 'N/A' }}</td>
                            <td>{{ $pickup->user?->jobDivision?->name ?? 'Belum Ditugaskan' }}</td>
                            <td>{{ $pickup->quantity }}</td>
                            <td>{{ $pickup->taken_date ? $pickup->taken_date->format('d M Y') : '-' }}</td>
                            <td>{{ $pickup->created_at->format('H:i') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="fas fa-search fa-3x mb-3 text-muted"></i>
                                    <h5>Tidak ada catatan pengambilan ditemukan</h5>
                                    <p class="mb-0 text-muted">Coba ubah kriteria filter Anda</p>
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

    <!-- Chart Section -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="card-title">Distribusi Barang</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="height: 300px; position: relative;">
                        <canvas id="itemDistributionChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="card-title">Tren Pengambilan Harian</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="height: 300px; position: relative;">
                        <canvas id="dailyTrendChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- PDF Export Template (Hidden) -->
    <div id="pdf-content" style="display: none;">
        <div style="text-align: center; margin-bottom: 20px;">
            <h2 style="font-family: Arial, sans-serif; color: #C74E22;">Item Pickups Report</h2>
            <p style="font-family: Arial, sans-serif;">{{ request('start_date', now()->subDays(30)->format('d M Y')) }} to {{ request('end_date', now()->format('d M Y')) }}</p>
        </div>

        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px; font-family: Arial, sans-serif;">
            <tr>
                <td style="width: 25%; border: 1px solid #ddd; padding: 8px; background-color: #F4F5F8;">
                    <strong>Total Pickups:</strong> {{ $totalPickups }}
                </td>
                <td style="width: 25%; border: 1px solid #ddd; padding: 8px; background-color: #F4F5F8;">
                    <strong>Total Items Picked:</strong> {{ $totalQuantity }}
                </td>
                <td style="width: 25%; border: 1px solid #ddd; padding: 8px; background-color: #F4F5F8;">
                    <strong>Unique Users:</strong> {{ $uniqueUsers }}
                </td>
                <td style="width: 25%; border: 1px solid #ddd; padding: 8px; background-color: #F4F5F8;">
                    <strong>Unique Items:</strong> {{ $uniqueItems }}
                </td>
            </tr>
        </table>

        <table style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif;">
            <thead>
                <tr style="background-color: #FF6A3D; color: white;">
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">No</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Item</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">User</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Division</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Quantity</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Taken Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($itemPickups as $pickup)
                <tr style="{{ $loop->even ? 'background-color: #F4F5F8;' : '' }}">
                    <td style="border: 1px solid #ddd; padding: 8px;">{{ $loop->iteration }}</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">{{ $pickup->item?->name ?? 'N/A' }}</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">{{ $pickup->user?->name ?? 'N/A' }}</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">{{ $pickup->user?->jobDivision?->name ?? 'Unassigned' }}</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">{{ $pickup->quantity }}</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">{{ $pickup->taken_date ? $pickup->taken_date->format('d M Y') : '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div style="text-align: right; margin-top: 20px; font-family: Arial, sans-serif; font-size: 12px; color: #666;">
            Generated on: {{ now()->format('d M Y H:i') }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<script>
    // Item Distribution Chart
    const itemCtx = document.getElementById('itemDistributionChart').getContext('2d');
    const itemDistributionChart = new Chart(itemCtx, {
        type: 'pie',
        data: {
            labels: {!! json_encode($topItemsLabels) !!},
            datasets: [{
                data: {!! json_encode($topItemsData) !!},
                backgroundColor: [
                    '#FF6A3D', '#12805C', '#F2A93B', '#2F6FB0', '#101B2D',
                    '#C74E22', '#5B8A72', '#D64545', '#8A6D3B', '#4B5768'
                ],
                borderColor: '#ffffff',
                borderWidth: 2
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        color: '#101B2D',
                        font: { family: 'Inter' }
                    }
                }
            }
        }
    });

    // Daily Trend Chart
    const trendCtx = document.getElementById('dailyTrendChart').getContext('2d');
    const dailyTrendChart = new Chart(trendCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($dailyTrendLabels) !!},
            datasets: [{
                label: 'Pickups',
                data: {!! json_encode($dailyTrendData) !!},
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

    // PDF Export Functionality
    document.getElementById('printPdf').addEventListener('click', function() {
        // Show loading state
        document.getElementById('exportBtnText').textContent = 'Generating...';
        document.getElementById('exportSpinner').style.display = 'inline-block';

        // Disable the button to prevent multiple clicks
        this.disabled = true;

        // Create a deep clone of the hidden PDF content to avoid DOM manipulation issues
        const pdfContent = document.getElementById('pdf-content').cloneNode(true);
        pdfContent.style.display = 'block';

        // Create a temporary container for the PDF generation
        const tempContainer = document.createElement('div');
        tempContainer.appendChild(pdfContent);
        document.body.appendChild(tempContainer);

        // Options for PDF generation
        const options = {
            margin: [10, 10, 10, 10],
            filename: 'item-pickups-report.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: {
                scale: 2,
                useCORS: true,
                letterRendering: true,
                logging: false
            },
            jsPDF: {
                unit: 'mm',
                format: 'a4',
                orientation: 'portrait',
                compress: true
            }
        };

        // Generate PDF
        html2pdf().from(pdfContent).set(options).save().then(() => {
            // Clean up temporary elements after PDF generation
            document.body.removeChild(tempContainer);

            // Reset button state
            document.getElementById('exportBtnText').textContent = 'Export PDF';
            document.getElementById('exportSpinner').style.display = 'none';
            this.disabled = false;
        }).catch(error => {
            console.error('PDF generation failed:', error);

            // Reset button state even if there's an error
            document.getElementById('exportBtnText').textContent = 'Export PDF';
            document.getElementById('exportSpinner').style.display = 'none';
            this.disabled = false;

            // Show error message to user
            alert('Failed to generate PDF. Please try again or use the HTML download option.');

            // Show HTML download fallback
            document.getElementById('downloadHtml').classList.remove('d-none');
        });
    });

    // HTML Download Fallback
    document.getElementById('downloadHtml').addEventListener('click', function() {
        // Create a blob with the HTML content
        const pdfContent = document.getElementById('pdf-content').cloneNode(true);
        pdfContent.style.display = 'block';

        // Add basic styling
        const style = document.createElement('style');
        style.textContent = `
            body { font-family: Arial, sans-serif; margin: 20px; }
            table { border-collapse: collapse; width: 100%; margin-bottom: 20px; }
            th, td { border: 1px solid #ddd; padding: 8px; }
            th { background-color: #FF6A3D; color: white; }
            tr:nth-child(even) { background-color: #F4F5F8; }
            h2 { color: #C74E22; }
        `;

        // Create a complete HTML document
        const html = `
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="utf-8">
                <title>Item Pickups Report</title>
                ${style.outerHTML}
            </head>
            <body>
                ${pdfContent.outerHTML}
            </body>
            </html>
        `;

        // Create a blob and download link
        const blob = new Blob([html], { type: 'text/html' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'item-pickups-report.html';
        a.click();

        // Clean up
        setTimeout(() => URL.revokeObjectURL(url), 100);
    });
</script>
@endpush
