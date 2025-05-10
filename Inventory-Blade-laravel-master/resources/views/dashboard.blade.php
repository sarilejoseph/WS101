@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card bg-primary text-white shadow-sm">
                <div class="card-body">
                    <h3 class="card-title mb-0">Welcome to Inventory Management System</h3>
                    <p class="card-text">Efficiently manage your inventory with our streamlined dashboard.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Advanced Query Form -->
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Advanced Inventory Search</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('dashboard.index') }}" method="GET">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="search_name" class="form-label fw-bold">Item Name</label>
                                <input type="text" name="search_name" id="search_name" class="form-control @error('search_name') is-invalid @enderror" value="{{ request('search_name') }}" placeholder="e.g., Laptop">
                                @error('search_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="max_quantity" class="form-label fw-bold">Max Quantity</label>
                                <input type="number" name="max_quantity" id="max_quantity" class="form-control @error('max_quantity') is-invalid @enderror" value="{{ request('max_quantity') }}" placeholder="e.g., 10" min="0">
                                @error('max_quantity')
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
                            <div class="col-md-4 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Summary Cards -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-primary shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Items</h5>
                    <h2 class="card-text text-primary">{{ $totalItems }}</h2>
                    <p class="text-muted">Items in inventory</p>
                </div>
                <div class="card-footer bg-white border-0">
                    <a href="{{ route('items.index') }}" class="btn btn-outline-primary btn-sm w-100">View All Items</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100 border-success shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Quantity</h5>
                    <h2 class="card-text text-success">{{ $totalQuantity }}</h2>
                    <p class="text-muted">Units in stock</p>
                </div>
                <div class="card-footer bg-white border-0">
                    <a href="{{ route('items.index') }}" class="btn btn-outline-success btn-sm w-100">Manage Stock</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100 border-danger shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title">Inventory Value</h5>
                    <h2 class="card-text text-danger">₱{{ number_format($totalValue, 2) }}</h2>
                    <p class="text-muted">Total inventory value</p>
                </div>
                <div class="card-footer bg-white border-0">
                    <a href="{{ route('inventory.print') }}" class="btn btn-outline-danger btn-sm w-100">Print Report</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Search Results or Recent Items -->
        <div class="col-md-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">{{ request()->has('search_name') || request()->has('max_quantity') || request()->has('min_price') || request()->has('max_price') ? 'Search Results' : 'Recently Added Items' }}</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentItems as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>₱{{ number_format($item->price, 2) }}</td>
                                    <td>₱{{ number_format($item->quantity * $item->price, 2) }}</td>
                                    <td>
                                        <a href="{{ route('items.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">No items found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white text-end">
                    <a href="{{ route('items.index') }}" class="btn btn-primary">View All Items</a>
                    <a href="{{ route('items.create') }}" class="btn btn-success">Add New Item</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection