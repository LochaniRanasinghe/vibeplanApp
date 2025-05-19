@extends('layouts.event-organizer.master')

@section('css')

@endsection

@section('title', 'VibePlan-Inventory Items ')

@section('parent_heading', 'Inventory Items ')
@section('parent_icon', 'mdi-account-multiple-outline')
@section('child_heading', 'Inventory Items')
@section('child_heading2', 'Add Inventory Items')


@section('content')

    <div class="card" style="border-radius: 15px;">
        <div class="card-body">
            <div class="row mt-3 mb-5 mx-2">
                <b>
                    <h6 style="text-transform: uppercase; font-weight: bold;" class="text-center mb-4">Add Inventory Items
                    </h6>
                </b>
                <form action="{{ route('event_organizer.inventory-items.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <!-- Inventory Staff Dropdown -->
                        <div class="col-md-6 mb-3">
                            <label for="inventory_staff_id" class="form-label">Inventory Staff</label>
                            <select name="inventory_staff_id" id="inventory_staff_id" class="form-select select2" required>
                                <option value="">Select Staff</option>
                                @foreach ($staffList as $staff)
                                    <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Item Name -->
                        <div class="col-md-6 mb-3">
                            <label for="item_name" class="form-label">Item Name</label>
                            <input type="text" class="form-control" name="item_name" id="item_name"
                                placeholder="Enter item name" required>
                        </div>

                        <!-- Quantity Available -->
                        <div class="col-md-6 mb-3">
                            <label for="quantity_available" class="form-label">Quantity Available</label>
                            <input type="number" class="form-control" name="quantity_available" id="quantity_available"
                                placeholder="Enter quantity" required>
                        </div>

                        <!-- Price Per Unit -->
                        <div class="col-md-6 mb-3">
                            <label for="price_per_unit" class="form-label">Price Per Unit</label>
                            <input type="text" class="form-control" name="price_per_unit" id="price_per_unit"
                                placeholder="Enter unit price" required>
                        </div>

                        <!-- Description -->
                        <div class="col-md-10 mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" name="description" id="description" rows="3" placeholder="Enter description"
                                required></textarea>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <a href="{{ route('admin.inventory-items.index') }}"
                            class="btn btn-outline-secondary me-2 px-4">Return
                            Back</a>
                        <button type="submit" class="btn btn-primary px-4">Create Inventory Item</button>
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
