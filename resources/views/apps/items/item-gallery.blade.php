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
    .card-header h5, .card-title { font-family: 'Space Grotesk', sans-serif; font-weight: 600; color: #101B2D; }

    /* Item cards in the gallery grid */
    .gallery-item-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .gallery-item-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 14px 30px rgba(16, 27, 45, 0.10) !important;
    }
    .gallery-item-card .card-img-top {
        border-radius: 14px 14px 0 0;
    }

    .badge.bg-success { background-color: #12805C !important; }
    .badge.bg-warning { background-color: #F2A93B !important; color: #fff !important; }
    .badge.bg-danger  { background-color: #D64545 !important; }

    /* Quantity stepper */
    .btn-decrease, .btn-increase {
        border-color: #E1E4EA;
        color: #4B5768;
    }
    .btn-decrease:hover, .btn-increase:hover {
        background-color: #FF6A3D;
        border-color: #FF6A3D;
        color: #fff;
    }
    .item-quantity:focus {
        border-color: #FF6A3D;
        box-shadow: 0 0 0 0.2rem rgba(255, 106, 61, 0.15);
    }

    /* Search box */
    .card-header form .form-control:focus {
        border-color: #FF6A3D;
        box-shadow: 0 0 0 0.2rem rgba(255, 106, 61, 0.12);
    }

    /* Cart sidebar */
    .cart-item {
        border: 1px solid #E1E4EA;
        border-radius: 10px;
        padding: 0.75rem 0.9rem;
    }

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
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Galeri Barang</h1>
        <a href="{{ route('items.index') }}" class="btn btn-outline-primary">
            <i class="fas fa-list"></i> Tampilan Daftar
        </a>
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

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-9">
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Galeri Semua Barang</h5>
                    <form action="{{ route('items.item-gallery') }}" method="GET" class="d-flex">
                        <input type="text" name="search" class="form-control me-2" placeholder="Cari berdasarkan nama..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-outline-primary">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
                <div class="card-body">
                    @if($items->count() > 0)
                    <div class="row">
                        @foreach($items as $item)
                        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                            <div class="card gallery-item-card h-100 shadow-sm">
                                <div class="position-relative">
                                    @if($item->image)
                                    <img src="{{ Storage::url($item->image) }}" class="card-img-top" alt="{{ $item->name }}" style="height: 200px; object-fit: cover;">
                                    @else
                                    <div class="card-img-top d-flex align-items-center justify-content-center bg-light" style="height: 200px;">
                                        <i class="fas fa-image fa-3x text-muted"></i>
                                    </div>
                                    @endif

                                    <!-- Stock Badge -->
                                    <div class="position-absolute top-0 end-0 m-2">
                                        @if($item->stock > 10)
                                        <span class="badge bg-success">Stok: {{ $item->stock }}</span>
                                        @elseif($item->stock > 0)
                                        <span class="badge bg-warning">Stok: {{ $item->stock }}</span>
                                        @else
                                        <span class="badge bg-danger">Stok Habis</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="card-body d-flex flex-column">
                                    <h6 class="card-title">{{ $item->name }}</h6>
                                    <p class="text-muted small mb-1">Kode: {{ $item->code }}</p>
                                    <p class="card-text flex-grow-1">{{ Str::limit($item->description, 80) }}</p>

                                    @if($item->stock > 0)
                                    <div class="mt-auto border-top pt-3">
                                        <!-- Quantity Counter -->
                                        <div class="mb-3">
                                            <label class="form-label small fw-bold">Jumlah:</label>
                                            <div class="input-group input-group-sm">
                                                <button type="button" class="btn btn-outline-secondary btn-decrease" data-target="quantity-{{ $item->id }}">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                                <input type="number" id="quantity-{{ $item->id }}" class="form-control text-center item-quantity" value="1" min="1" max="{{ $item->stock }}" data-item-id="{{ $item->id }}" data-item-name="{{ $item->name }}" data-item-stock="{{ $item->stock }}">
                                                <button type="button" class="btn btn-outline-secondary btn-increase" data-target="quantity-{{ $item->id }}" data-max="{{ $item->stock }}">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                            <small class="text-muted">Maksimal: {{ $item->stock }} unit</small>
                                        </div>

                                        <!-- Add to Cart Button -->
                                        <button type="button" class="btn btn-primary btn-sm w-100 btn-add-to-cart" data-item-id="{{ $item->id }}" data-item-name="{{ $item->name }}" data-item-stock="{{ $item->stock }}">
                                            <i class="fas fa-cart-plus"></i> Tambah ke Keranjang
                                        </button>
                                    </div>
                                    @else
                                    <div class="mt-auto border-top pt-3">
                                        <button type="button" class="btn btn-secondary btn-sm w-100" disabled>
                                            <i class="fas fa-times"></i> Stok Tidak Tersedia
                                        </button>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <!-- Empty State -->
                    <div class="text-center py-5">
                        <div class="d-flex flex-column align-items-center">
                            <i class="fas fa-images fa-4x mb-3 text-muted"></i>
                            <h5>Tidak ada barang ditemukan</h5>
                            @if(request('search'))
                            <p class="mb-0">Coba hapus pencarian atau tambahkan barang baru</p>
                            <div class="mt-3">
                                <a href="{{ route('items.item-gallery') }}" class="btn btn-outline-primary me-2">Hapus Pencarian</a>
                                <a href="{{ route('items.create') }}" class="btn btn-primary">Tambah Barang Baru</a>
                            </div>
                            @else
                            <p class="mb-0">Mulai dengan menambahkan barang pertama Anda</p>
                            <div class="mt-3">
                                <a href="{{ route('items.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-1"></i> Tambah Barang Baru
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>

                @if($items->hasPages())
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            Menampilkan {{ $items->firstItem() ?? 0 }} sampai {{ $items->lastItem() ?? 0 }} dari {{ $items->total() }} entri
                        </div>
                        <div>
                            {{ $items->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Right Sidebar - Shopping Cart -->
        <div class="col-lg-3">
            <div class="card sticky-top z-2" style="top: 80px;">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-shopping-cart"></i> Keranjang Pengambilan
                    </h5>
                </div>
                <div class="card-body">
                    <form id="pickup-form" action="{{ route('item-pickups.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="taken_date" value="{{ date('Y-m-d') }}">

                        <div id="cart-items" class="mb-3">
                            <!-- Cart items will be dynamically added here -->
                            <div class="text-center text-muted py-3" id="empty-cart-message">
                                <i class="fas fa-shopping-cart fa-2x mb-2"></i>
                                <p class="mb-0">Keranjang masih kosong</p>
                            </div>
                        </div>

                        <div class="border-top pt-3">
                            <button type="submit" class="btn btn-primary w-100" id="submit-pickup" disabled>
                                <i class="fas fa-check"></i> Proses Pengambilan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const cart = new Map();
    const cartItemsContainer = document.getElementById('cart-items');
    const emptyCartMessage = document.getElementById('empty-cart-message');
    const submitButton = document.getElementById('submit-pickup');

    // Handle quantity increase/decrease buttons
    document.querySelectorAll('.btn-increase').forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const maxValue = parseInt(this.getAttribute('data-max'));
            const input = document.getElementById(targetId);
            const currentValue = parseInt(input.value);

            if (currentValue < maxValue) {
                input.value = currentValue + 1;
            }
        });
    });

    document.querySelectorAll('.btn-decrease').forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);
            const currentValue = parseInt(input.value);

            if (currentValue > 1) {
                input.value = currentValue - 1;
            }
        });
    });

    // Add to Cart functionality
    document.querySelectorAll('.btn-add-to-cart').forEach(button => {
        button.addEventListener('click', function() {
            const itemId = this.getAttribute('data-item-id');
            const itemName = this.getAttribute('data-item-name');
            const maxStock = parseInt(this.getAttribute('data-item-stock'));
            const quantityInput = document.getElementById(`quantity-${itemId}`);
            const quantity = parseInt(quantityInput.value);

            if (quantity > 0 && quantity <= maxStock) {
                addToCart(itemId, itemName, quantity, maxStock);
                quantityInput.value = 1; // Reset quantity input
            }
        });
    });

    function addToCart(itemId, itemName, quantity, maxStock) {
        cart.set(itemId, {
            name: itemName,
            quantity: quantity,
            maxStock: maxStock
        });
        updateCartDisplay();
    }

    function removeFromCart(itemId) {
        cart.delete(itemId);
        updateCartDisplay();
    }

    function updateCartDisplay() {
        if (cart.size === 0) {
            emptyCartMessage.style.display = 'block';
            submitButton.disabled = true;
            cartItemsContainer.innerHTML = emptyCartMessage.outerHTML;
            return;
        }

        emptyCartMessage.style.display = 'none';
        submitButton.disabled = false;

        let cartHtml = '';
        cart.forEach((item, itemId) => {
            cartHtml += `
                <div class="cart-item mb-3">
                    <input type="hidden" name="items[${itemId}][item_id]" value="${itemId}">
                    <input type="hidden" name="items[${itemId}][quantity]" value="${item.quantity}">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">${item.name}</h6>
                            <small class="text-muted">Jumlah: ${item.quantity}</small>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeFromCart('${itemId}')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;
        });

        cartItemsContainer.innerHTML = cartHtml;
    }

    // Make removeFromCart function globally available
    window.removeFromCart = removeFromCart;
});
</script>
@endpush
