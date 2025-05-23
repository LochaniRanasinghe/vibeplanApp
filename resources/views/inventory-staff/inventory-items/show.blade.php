@extends('layouts.inventory-staff.master')

@section('css')
    <style>
        .readonly-field {
            background-color: #e0e1e3 !important;
        }
    </style>
@endsection

@section('title', 'VibePlan-Edit Inventory Items')

@section('parent_heading', 'Inventory Items')
@section('parent_icon', 'mdi-account-multiple-outline')
@section('child_heading', 'Inventory Items')
@section('child_heading2', 'Edit Inventory Items')

@section('content')
    <div class="card" style="border-radius: 15px;">
        <div class="card-body">
            <div class="row mt-3 mb-5 mx-2">
                <b>
                    <h6 style="text-transform: uppercase; font-weight: bold;" class="text-center mb-4">Edit Inventory Items
                    </h6>
                </b>

                <form action="{{ route('inventory_staff.inventory-items.update', $inventoryItem->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="inventory_staff_id" class="form-label">Inventory Staff</label>
                            <input type="text" class="form-control readonly-field"
                                value="{{ $inventoryItem->staff?->name ?? 'N/A' }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="item_name" class="form-label">Item Name</label>
                            <input type="text" name="item_name" id="item_name" class="form-control"
                                value="{{ old('item_name', $inventoryItem->item_name) }}" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="price_per_unit" class="form-label">Price Per Unit</label>
                            <input type="text" name="price_per_unit" id="price_per_unit" class="form-control"
                                value="{{ old('price_per_unit', $inventoryItem->price_per_unit) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="quantity_available" class="form-label">Quantity Available</label>
                            <input type="number" name="quantity_available" id="quantity_available" class="form-control"
                                value="{{ old('quantity_available', $inventoryItem->quantity_available) }}" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" rows="3" class="form-control" required>{{ old('description', $inventoryItem->description) }}</textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Current Image</label><br>
                            @if ($inventoryItem->item_image)
                                <img src="{{ asset('storage/' . $inventoryItem->item_image) }}" alt="Item Image"
                                    width="120" class="mb-2 rounded">
                            @else
                                <p>No image available.</p>
                            @endif

                            <label for="item_image" class="form-label mt-2">Change Image</label>
                            <input type="file" name="item_image" id="item_image" class="form-control" accept="image/*">
                        </div>
                    </div>

                    <div class="text-end">
                        <a href="{{ route('inventory_staff.inventory-items.index') }}"
                            class="btn btn-outline-secondary me-2 px-4">Return
                            Back</a>
                        <button type="submit" class="btn btn-primary">Update Item</button>
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
