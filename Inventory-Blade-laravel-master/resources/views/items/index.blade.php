@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Inventory Management System</h2>
    <a href="{{ route('items.create') }}" class="btn btn-primary mb-3">Add Item</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total Price</th> <!-- New Column -->
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @php $totalCost = 0; @endphp
            @foreach($items as $item)
                @php 
                    $totalPrice = $item->quantity * $item->price;
                    $totalCost += $totalPrice;
                @endphp
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->price, 2) }}</td>
                    <td>{{ number_format($totalPrice, 2) }}</td> <!-- Display Total Price -->
                    <td>
                        <a href="{{ route('items.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>

                        <!-- Delete Button -->
                        <button type="button" class="btn btn-danger btn-sm" 
                            onclick="confirmDelete({{ $item->id }})">
                            Delete
                        </button>

                        <!-- Delete Form -->
                        <form id="delete-form-{{ $item->id }}" action="{{ route('items.destroy', $item->id) }}" 
                            method="POST" class="d-none">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="text-end fw-bold">Total Cost:</td>
                <td class="fw-bold">{{ number_format($totalCost, 2) }}</td> <!-- Display Total Cost -->
                <td></td>
            </tr>
        </tfoot>
    </table>
</div>

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
