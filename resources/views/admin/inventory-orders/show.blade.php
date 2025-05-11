@extends('layouts.admin.master')

@section('css')
    <style>
        .readonly-field {
            background-color: #e0e1e3 !important;
        }
    </style>
@endsection

@section('title', 'VibePlan-Edit Inventory Orders')

@section('parent_heading', 'Inventory Orders')
@section('parent_icon', 'mdi-account-multiple-outline')
@section('child_heading', 'Inventory Orders')
@section('child_heading2', 'Edit Inventory Orders')

@section('content')
    <div class="card" style="border-radius: 15px;">
        <div class="card-body">
            <div class="row mt-3 mb-5 mx-2">
                <b>
                    <h6 class="text-center mb-4 text-uppercase fw-bold">Edit Inventory Orders</h6>
                </b>

                <form action="{{ route('admin.inventory-orders.update', $inventoryOrder->id) }}" method="POST">

                    @csrf
                    @method('PUT')

                    {{-- Read-only fields --}}
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Item Name</label>
                            <input type="text" class="form-control readonly-field"
                                value="{{ $inventoryOrder->inventoryItem?->item_name }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Inventory Staff</label>
                            <input type="text" class="form-control readonly-field"
                                value="{{ $inventoryOrder->inventoryItem?->staff?->name ?? 'N/A' }}" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Event Title</label>
                            <input type="text" class="form-control readonly-field"
                                value="{{ $inventoryOrder->customEvent?->request?->title ?? 'N/A' }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Event Type</label>
                            <input type="text" class="form-control readonly-field"
                                value="{{ $inventoryOrder->customEvent?->request?->eventType?->name ?? 'N/A' }}" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Ordered By (Organizer)</label>
                            <input type="text" class="form-control readonly-field"
                                value="{{ $inventoryOrder->customEvent?->organizer?->name ?? 'N/A' }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Quantity Available</label>
                            <input type="text" class="form-control readonly-field"
                                value="{{ $inventoryOrder->inventoryItem?->quantity_available }}" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Unit Price</label>
                            <input type="text" class="form-control readonly-field"
                                value="{{ number_format($inventoryOrder->inventoryItem?->price_per_unit ?? 0, 2) }}"
                                readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Total Price</label>
                            <input type="text" class="form-control readonly-field"
                                value="{{ number_format(($inventoryOrder->inventoryItem?->price_per_unit ?? 0) * $inventoryOrder->quantity, 2) }}"
                                readonly>
                        </div>
                    </div>

                    {{-- Editable field --}}
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Quantity</label>
                            <input type="text" name="quantity" class="form-control"
                                value="{{ $inventoryOrder->quantity }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select select2">
                                <option value="pending" {{ $inventoryOrder->status === 'pending' ? 'selected' : '' }}>
                                    Pending</option>
                                <option value="approved" {{ $inventoryOrder->status === 'approved' ? 'selected' : '' }}>
                                    Approved</option>
                                <option value="rejected" {{ $inventoryOrder->status === 'rejected' ? 'selected' : '' }}>
                                    Rejected</option>
                            </select>
                        </div>
                    </div>

                    <div class="text-end">
                        <a href="{{ route('admin.inventory-orders.index') }}"
                            class="btn btn-outline-secondary me-2 px-4">Return
                            Back</a>
                        <button type="submit" class="btn btn-primary">Update Order</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endsection
