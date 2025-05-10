@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Inventory Management System</h2>

    <!-- Advanced Query Form -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0">Advanced Inventory Search</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('items.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="search_name" class="form-label fw-bold">Item Name</label>
                        <input type="text" name="search_name" id="search_name" class="form-control @error('search_name') is-invalid @enderror" value="{{ request('search_name') }}" placeholder="e.g., Laptop">
                        @error('search_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="min_price" class="form-label fw-bold">Min Price (₱)</label>
                        <input type="number" step="0.01" name="min_price" id="min_price" class="form-control @error('min_price') is-invalid @enderror" value="{{ request('min_price') }}" placeholder="e.g., 100" min="0">
                        @error('min_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="max_price" class="form-label fw-bold">Max Price (₱)</label>
                        <input type="number" step="0.01" name="max_price" id="max_price" class="form-control @error('max_price') is-invalid @enderror" value="{{ request('max_price') }}" placeholder="e.g., 1000" min="0">
                        @error('max_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="min_quantity" class="form-label fw-bold">Min Quantity</label>
                        <input type="number" name="min_quantity" id="min_quantity" class="form-control @error('min_quantity') is-invalid @enderror" value="{{ request('min_quantity') }}" placeholder="e.g., 5" min="0">
                        @error('min_quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="max_quantity" class="form-label fw-bold">Max Quantity</label>
                        <input type="number" name="max_quantity" id="max_quantity" class="form-control @error('max_quantity') is-invalid @enderror" value="{{ request('max_quantity') }}" placeholder="e.g., 50" min="0">
                        @error('max_quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="min_total" class="form-label fw-bold">Min Total Value (₱)</label>
                        <input type="number" step="0.01" name="min_total" id="min_total" class="form-control @error('min_total') is-invalid @enderror" value="{{ request('min_total') }}" placeholder="e.g., 500" min="0">
                        @error('min_total')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="max_total" class="form-label fw-bold">Max Total Value (₱)</label>
                        <input type="number" step="0.01" name="max_total" id="max_total" class="form-control @error('max_total') is-invalid @enderror" value="{{ request('max_total') }}" placeholder="e.g., 5000" min="0">
                        @error('max_total')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <div class="form-check mt-4">
                            <input class="form-check-input" type="checkbox" name="recently_added" id="recently_added" value="1" {{ request('recently_added') ? 'checked' : '' }}>
                            <label class="form-check-label" for="recently_added">Recently Added (Last 7 Days)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="low_stock" id="low_stock" value="1" {{ request('low_stock') ? 'checked' : '' }}>
                            <label class="form-check-label" for="low_stock">Low Stock (≤ 5 Units)</label>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-50 me-2">Search</button>
                        <a href="{{ route('items.index') }}" class="btn btn-secondary w-50">Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th>Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @php $totalCost = 0; @endphp
            @forelse($items as $item)
                @php 
                    $totalPrice = $item->quantity * $item->price;
                    $totalCost += $totalPrice;
                @endphp
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>₱{{ number_format($item->price, 2) }}</td>
                    <td>₱{{ number_format($totalPrice, 2) }}</td>
                    <td>
                        <a href="{{ route('items.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <button type="button" class="btn btn-danger btn-sm" 
                            onclick="confirmDelete({{ $item->id }})">
                            Delete
                        </button>
                        <form id="delete-form-{{ $item->id }}" action="{{ route('items.destroy', $item->id) }}" 
                            method="POST" class="d-none">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">No items found.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="text-end fw-bold">Total Cost:</td>
                <td class="fw-bold">₱{{ number_format($totalCost, 2) }}</td>
                <td></td>
            </tr>
        </tfoot>
    </table>

    <!-- Footer -->
    <footer class="bg-primary text-white text-center py-3 mt-4">
        Group of JM Giducos, J Sarile, DA Arafol
    </footer>

    <!-- Bootstrap Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this record?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let deleteFormId = '';

    function confirmDelete(itemId) {
        deleteFormId = `delete-form-${itemId}`;
        let deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        deleteModal.show();
    }

    document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
        document.getElementById(deleteFormId).submit();
    });
</script>
@endsection