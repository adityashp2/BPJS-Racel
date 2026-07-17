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
    .card-header h5, .card-header h6 { font-family: 'Space Grotesk', sans-serif; font-weight: 600; color: #101B2D; }

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

    #itemPreview .card {
        background-color: #F4F5F8;
    }

    #imageContainer .bg-light {
        background-color: #F4F5F8 !important;
        border: 1px dashed #E1E4EA;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Buat Pengambilan Barang Baru</h1>
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
            <form action="{{ route('item-pickups.store') }}" method="POST">
                @csrf

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
                                    {{ old('item_id') == $item->id ? 'selected' : '' }}>
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
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
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

                <!-- Simplified Item Preview Section -->
                <div id="itemPreview" class="row mb-4" style="display: none;">
                    <div class="col-md-4 text-center">
                        <!-- We'll render this container content dynamically via JavaScript -->
                        <div id="imageContainer" class="mb-2">
                            <!-- Content will be injected here by JavaScript -->
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
                        <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" value="{{ old('quantity', 1) }}" min="1" required>
                        @error('quantity')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="taken_date" class="form-label">Tanggal Pengambilan <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('taken_date') is-invalid @enderror" id="taken_date" name="taken_date" value="{{ old('taken_date', now()->format('Y-m-d')) }}" required>
                        @error('taken_date')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="reset" class="btn btn-secondary me-2">Reset</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Buat Pengambilan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Function to create image element HTML
    function createImageElement(imageUrl, imageName) {
        return `<img src="${imageUrl}" alt="${imageName || 'Gambar barang'}" class="img-fluid rounded" style="max-height: 150px; max-width: 100%;">`;
    }

    // Function to create placeholder HTML
    function createPlaceholderElement() {
        return `
            <div class="d-flex flex-column justify-content-center align-items-center bg-light rounded py-4">
                <i class="fas fa-image fa-3x text-muted"></i>
                <p class="text-muted mt-2 mb-0">Tidak ada gambar tersedia</p>
            </div>
        `;
    }

    // Main function to update item preview
    function updateItemPreview() {
        console.log("updateItemPreview called");

        // Get select element safely
        const selectElement = document.getElementById('item_id');
        if (!selectElement) {
            console.log("Select element not found");
            return;
        }

        // Handle case when no option is selected
        if (selectElement.selectedIndex < 0 || selectElement.value === '') {
            console.log("No option selected");
            document.getElementById('itemPreview').style.display = 'none';
            return;
        }

        // Get selected option and show preview section
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const previewSection = document.getElementById('itemPreview');
        previewSection.style.display = 'flex';

        // Update description field
        const description = selectedOption.getAttribute('data-description') || 'Tidak ada deskripsi tersedia';
        document.getElementById('itemDescription').textContent = description;

        // Get image container element
        const imageContainer = document.getElementById('imageContainer');
        if (!imageContainer) {
            console.log("Image container not found");
            return;
        }

        // Get image URL and name from data attributes
        const imageUrl = selectedOption.getAttribute('data-image');
        const imageName = selectedOption.getAttribute('data-name');

        console.log("Image URL:", imageUrl);

        // Clear previous content from the container
        imageContainer.innerHTML = '';

        // Render either image or placeholder based on URL availability
        if (imageUrl && imageUrl.trim() !== '') {
            console.log("Showing image");
            imageContainer.innerHTML = createImageElement(imageUrl, imageName);
        } else {
            console.log("Showing placeholder");
            imageContainer.innerHTML = createPlaceholderElement();
        }
    }

    // Initialize when DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
        console.log("DOM loaded");

        try {
            // Initial update
            updateItemPreview();

            // Add event listener for changes
            const selectElement = document.getElementById('item_id');
            if (selectElement) {
                selectElement.addEventListener('change', function() {
                    console.log("Select changed");
                    updateItemPreview();
                });
            }

            // Handle form reset
            const resetButton = document.querySelector('button[type="reset"]');
            if (resetButton) {
                resetButton.addEventListener('click', function() {
                    console.log("Reset clicked");
                    setTimeout(function() {
                        document.getElementById('itemPreview').style.display = 'none';
                        document.getElementById('imageContainer').innerHTML = '';
                    }, 10);
                });
            }
        } catch (err) {
            console.error('Error initializing item preview:', err);
        }
    });
</script>
@endpush
