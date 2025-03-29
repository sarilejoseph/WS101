@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h3 class="card-title">Welcome to Inventory Management System</h3>
                    <p class="card-text">Manage your inventory efficiently with our easy-to-use dashboard.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Summary Cards -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-primary">
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
            <div class="card h-100 border-success">
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
            <div class="card h-100 border-danger">
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
        <!-- Recent Items -->
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Recently Added Items</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
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
                                @foreach($recentItems as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>₱{{ number_format($item->price, 2) }}</td>
                                    <td>₱{{ number_format($item->quantity * $item->price, 2) }}</td>
                                    <td>
                                        <a href="{{ route('items.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    </td>
                                </tr>
                                @endforeach
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