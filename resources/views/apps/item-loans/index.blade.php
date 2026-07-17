@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Item Loans Management</h1>
        <a href="{{ route('item-loans.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Create New Loan
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

    <div class="card">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">All Item Loans</h5>
            <form action="{{ route('item-loans.index') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control me-2" placeholder="Search..." value="{{ request('search') }}">
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
                            <th>Item</th>
                            <th>User</th>
                            <th>Quantity</th>
                            <th>Loan Date</th>
                            <th>Return Date</th>
                            <th>Status</th>
                            @if(Auth::user()->role == 'admin')
                                <th class="text-center">Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($itemLoans as $loan)
                        <tr>
                            <td>{{ $loan->item?->name ?? 'N/A' }}</td>
                            <td>{{ $loan->user?->name ?? 'N/A' }}</td>
                            <td>{{ $loan->quantity }}</td>
                            <td>{{ $loan->loan_date->format('d M Y') }}</td>
                            <td>{{ $loan->return_date ? $loan->return_date->format('d M Y') : 'Not set' }}</td>
                            <td>
                                <span class="badge-status {{
                                    $loan->status === 'returned' ? 'bg-success text-white' :
                                    ($loan->status === 'loaned' ? 'bg-primary text-white' :
                                    ($loan->status === 'overdue' ? 'bg-danger text-white' : 'bg-secondary text-white'))
                                }}">
                                    {{ ucfirst($loan->status) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    @if(Auth::user()->role == 'admin')
                                        <a href="{{ route('item-loans.edit', $loan) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $loan->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @endif
                                </div>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal{{ $loan->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $loan->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel{{ $loan->id }}">Confirm Delete</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to delete this loan record?</p>
                                                <div class="alert alert-warning">
                                                    <p class="mb-0"><strong>Item:</strong> {{ $loan->item?->name ?? 'N/A' }}</p>
                                                    <p class="mb-0"><strong>User:</strong> {{ $loan->user?->name ?? 'N/A' }}</p>
                                                    <p class="mb-0"><strong>Loan Date:</strong> {{ $loan->loan_date->format('d M Y') }}</p>
                                                </div>
                                                <p class="text-danger">This action cannot be undone.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <form action="{{ route('item-loans.destroy', $loan) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="fas fa-exchange-alt fa-3x mb-3 text-muted"></i>
                                    <h5>No item loans found</h5>
                                    @if(request('search'))
                                    <p class="mb-0">Try clearing your search or create a new loan</p>
                                    <div class="mt-3">
                                        <a href="{{ route('item-loans.index') }}" class="btn btn-outline-primary me-2">Clear Search</a>
                                        <a href="{{ route('item-loans.create') }}" class="btn btn-primary">Create New Loan</a>
                                    </div>
                                    @else
                                    <p class="mb-0">Get started by creating your first item loan</p>
                                    <div class="mt-3">
                                        <a href="{{ route('item-loans.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus me-1"></i> Create New Loan
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
                    Showing {{ $itemLoans->firstItem() ?? 0 }} to {{ $itemLoans->lastItem() ?? 0 }} of {{ $itemLoans->total() }} entries
                </div>
                <div>
                    {{ $itemLoans->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
