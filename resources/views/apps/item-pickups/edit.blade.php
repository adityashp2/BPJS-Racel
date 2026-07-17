@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Edit Pengambilan Barang</h1>
                <a href="{{ route('item-pickups.index') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card">
        <div class="card-header bg-white">
            <h5 class="mb-0">Informasi Pengambilan</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('item-pickups.update', $itemPickup) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="@if (Auth::user()->role == 'admin') col-md-6 @else col-md-12 @endif">
                        <label for="item_id" class="form-label">Barang <span class="text-danger">*</span></label>
                        <select class="form-select @error('item_id') is-invalid @enderror" id="item_id" name="item_id" required>
                            <option value="">Pilih Barang</option>
                            @foreach($items as $item)
                                <option value="{{ $item->id }}"
                                    data-description="{{ $item->description ?? 'Tidak ada deskripsi tersedia' }}"
                                    data-image="{{ $item->image ? asset('storage/' . $item->image) : '' }}"
                                    data-name="{{ $item->name }}"
                                    {{ (old('item_id', $itemPickup->item_id) == $item->id) ? 'selected' : '' }}>
                                    {{ $item->name }} (Stok: {{ $item->stock }})
                                </option>
                            @endforeach
                        </select>
                        @error('item_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    @if (Auth::user()->role == 'admin')
                        <div class="col-md-6">
                            <label for="user_id" class="form-label">Pengguna <span class="text-danger">*</span></label>
                            <select class="form-select @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required>
                                <option value="">Pilih Pengguna</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ (old('user_id', $itemPickup->user_id) == $user->id) ? 'selected' : '' }}>
                                        {{ $user->name }} - {{ $user->jobDivision?->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    @endif
                </div>

                <!-- Item Preview Section -->
                <div id="itemPreview" class="row mb-4" style="display: none;">
                    <div class="col-md-4 text-center">
                        <!-- Image Container - Only one of these divs will be visible at a time -->
                        <div id="itemImageWrapper" class="mb-2" style="display: none;">
                            <img id="itemImage" src="" alt="" class="img-fluid rounded" style="max-height: 150px; max-width: 100%;">
                        </div>

                        <div id="noImagePlaceholder" class="mb-2 d-flex flex-column justify-content-center align-items-center bg-light rounded py-4" style="display: none;">
                            <i class="fas fa-image fa-3x text-muted"></i>
                            <p class="text-muted mt-2 mb-0">Tidak ada gambar tersedia</p>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card h-100">
                            <div class="card-header bg-white py-2">
                                <h6 class="mb-0">Deskripsi Barang</h6>
                            </div>
                            <div class="card-body">
                                <p id="itemDescription" class="mb-0"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="quantity" class="form-label">Jumlah <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" value="{{ old('quantity', $itemPickup->quantity) }}" min="1" required>
                        @error('quantity')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="taken_date" class="form-label">Tanggal Pengambilan <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('taken_date') is-invalid @enderror" id="taken_date" name="taken_date" value="{{ old('taken_date', $itemPickup->taken_date ? $itemPickup->taken_date->format('Y-m-d') : now()->format('Y-m-d')) }}" required>
                        @error('taken_date')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="card bg-light mb-4">
                    <div class="card-body">
                        <h6 class="card-title"><i class="fas fa-info-circle me-2"></i>Riwayat Pengambilan</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Dibuat Pada:</strong></p>
                                <p>{{ $itemPickup->created_at->format('d M Y H:i') }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Terakhir Diperbarui:</strong></p>
                                <p>{{ $itemPickup->updated_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="fas fa-trash me-1"></i> Hapus Pengambilan
                    </button>

                    <div>
                        <a href="{{ route('item-pickups.index') }}" class="btn btn-secondary me-2">Batal</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Perbarui Pengambilan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus catatan pengambilan ini?</p>
                <div class="alert alert-warning">
                    <p class="mb-0"><strong>Barang:</strong> {{ $itemPickup->item?->name ?? 'N/A' }}</p>
                    <p class="mb-0"><strong>Pengguna:</strong> {{ $itemPickup->user?->name ?? 'N/A' }}</p>
                    <p class="mb-0"><strong>Tanggal Pengambilan:</strong> {{ $itemPickup->taken_date ? $itemPickup->taken_date->format('d M Y') : '-' }}</p>
                </div>
                <p class="text-danger">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('item-pickups.destroy', $itemPickup) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus Permanen</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Function to update item preview
    function updateItemPreview() {
        const selectElement = document.getElementById('item_id');
        if (!selectElement) return; // Safety check

        const selectedIndex = selectElement.selectedIndex;
        if (selectedIndex < 0) return; // No selection

        const selectedOption = selectElement.options[selectedIndex];
        const previewSection = document.getElementById('itemPreview');

        // If no value selected, hide the preview
        if (selectElement.value === '') {
            previewSection.style.display = 'none';
            return;
        }

        // Show preview section
        previewSection.style.display = 'flex';

        // Update description
        const description = selectedOption.getAttribute('data-description');
        const descriptionElement = document.getElementById('itemDescription');
        if (descriptionElement) {
            descriptionElement.textContent = description || 'Tidak ada deskripsi tersedia';
        }

        // Update image - completely separate containers
        const imageUrl = selectedOption.getAttribute('data-image');
        const imageName = selectedOption.getAttribute('data-name');
        const imageElement = document.getElementById('itemImage');
        const imageWrapper = document.getElementById('itemImageWrapper');
        const noImagePlaceholder = document.getElementById('noImagePlaceholder');

        // First, hide both elements
        imageWrapper.style.display = 'none';
        noImagePlaceholder.style.display = 'none';

        // Then show only the appropriate one
        if (imageUrl && imageUrl.trim() !== '') {
            // We have an image URL - show the image
            imageElement.src = imageUrl;
            imageElement.alt = imageName || 'Gambar barang';
            imageWrapper.style.display = 'block';
        } else {
            // No image URL - show the placeholder
            noImagePlaceholder.style.display = 'block';
        }
    }

    // Initialize preview if there's a selected value on page load
    document.addEventListener('DOMContentLoaded', function() {
        try {
            updateItemPreview();

            // Add change event listener
            const selectElement = document.getElementById('item_id');
            if (selectElement) {
                selectElement.addEventListener('change', updateItemPreview);
            }
        } catch (err) {
            console.error('Error initializing item preview:', err);
        }
    });
</script>
@endpush
