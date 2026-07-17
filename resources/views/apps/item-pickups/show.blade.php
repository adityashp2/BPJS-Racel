@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Detail Pengambilan Barang</h1>
                <div>
                    <a href="{{ route('item-pickups.edit', $itemPickup) }}" class="btn btn-warning me-2">
                        <i class="fas fa-edit me-1"></i> Edit Pengambilan
                    </a>
                    <a href="{{ route('item-pickups.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card sticky-top" style="top: 85px; z-index: 2;">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Gambar Barang</h5>
                </div>
                <div class="card-body text-center">
                    @if($itemPickup->item->image)
                    <img src="{{ asset('storage/' . $itemPickup->item->image) }}" alt="{{ $itemPickup->item->name }}" class="img-fluid rounded">
                    @else
                    <div class="d-flex flex-column justify-content-center align-items-center bg-light rounded py-5">
                        <i class="fas fa-image fa-4x text-muted"></i>
                        <p class="text-muted mt-3 mb-0">Tidak ada gambar tersedia</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Informasi Pengambilan</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <th class="w-25">ID Pengambilan</th>
                                <td>{{ $itemPickup->id }}</td>
                            </tr>
                            <tr>
                                <th>Barang</th>
                                <td>{{ $itemPickup->item->name }}</td>
                            </tr>
                            <tr>
                                <th>Jumlah</th>
                                <td>
                                    <span class="badge bg-primary">
                                        {{ $itemPickup->quantity }} unit
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Tanggal Pengambilan</th>
                                <td>{{ $itemPickup->taken_date->format('d M Y') }}</td>
                            </tr>
                            <tr>
                                <th>Pengguna</th>
                                <td>
                                    <a href="{{ route('users.show', $itemPickup->user) }}" class="text-decoration-none">
                                        {{ $itemPickup->user->name }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <th>Divisi</th>
                                <td>{{ $itemPickup->user->jobDivision?->name ?? 'Tidak Ditugaskan' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Deskripsi Barang</h5>
                </div>
                <div class="card-body">
                    @if($itemPickup->item->description)
                    <p class="mb-0">{{ $itemPickup->item->description }}</p>
                    @else
                    <p class="text-muted mb-0">Tidak ada deskripsi tersedia</p>
                    @endif
                </div>
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            Dibuat: {{ $itemPickup->created_at->format('d M Y H:i') }}
                        </small>
                        <small class="text-muted">
                            Terakhir Diperbarui: {{ $itemPickup->updated_at->format('d M Y H:i') }}
                        </small>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                    <i class="fas fa-trash me-1"></i> Hapus Pengambilan
                </button>
            </div>
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
                <p>Apakah Anda yakin ingin menghapus pengambilan barang <strong>{{ $itemPickup->item->name }}</strong>?</p>
                <p class="text-danger">Tindakan ini akan mengembalikan stok sebanyak {{ $itemPickup->quantity }} unit.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('item-pickups.destroy', $itemPickup) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus Pengambilan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
