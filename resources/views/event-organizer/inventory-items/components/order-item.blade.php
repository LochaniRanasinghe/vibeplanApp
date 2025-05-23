@extends('layouts.event-organizer.master')

@section('css')
    <style>
        .readonly-field {
            background-color: #e0e1e3 !important;
        }
    </style>
@endsection

@section('title', 'VibePlan-Order Inventory Items')

@section('parent_heading', 'Inventory Items')
@section('parent_icon', 'mdi-account-multiple-outline')
@section('child_heading', 'Inventory Items')
@section('child_heading2', 'Order Inventory Items')

@section('content')
    <div class="card" style="border-radius: 15px;">
        <div class="card-body">
            <div class="row mt-3 mb-5 mx-2">
                <b>
                    <h6 style="text-transform: uppercase; font-weight: bold;" class="text-center mb-4">Order Inventory Items
                    </h6>
                </b>

                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="card shadow-sm">
                            <div class="row g-0">
                                <!-- Left: Image -->
                                <div class="col-md-5">
                                    <img src="{{ $item->item_image ? asset('storage/' . $item->item_image) : asset('images/default-image.png') }}"
                                        class="img-fluid rounded-start w-100 h-100" style="object-fit: cover;"
                                        alt="{{ $item->item_name }}">
                                </div>

                                <!-- Right: Details and Form -->
                                {{-- <div class="col-md-7">
                                    <div class="card-body">
                                        <h4 class="card-title">{{ $item->item_name }}</h4>
                                        <p class="mb-1" style="background-color: #fff8c4; padding: 10px 15px; border-left: 5px solid #f1c40f; border-radius: 6px; font-size: 14px;">
                                            {{ $item->description }}
                                        </p>                                        
                                        <p class="mb-2"> LKR
                                            {{ number_format($item->price_per_unit, 2) }} (per unit)</p>
                                        <p class="mb-1 text-success">
                                            {{ $availableQty }} items currently available
                                            <span class="text-muted">(out of {{ $item->quantity_available }} total
                                                supplied)</span>
                                        </p>

                                        <p class="text-muted mb-3"><strong>Supplier Team:</strong>
                                            {{ $item->staff?->name ?? 'N/A' }}</p>

                                        @if (session('error'))
                                            <div class="alert alert-danger">
                                                {{ session('error') }}
                                            </div>
                                        @endif

                                        <form action="{{ route('event_organizer.inventory-items.place-order', $item->id) }}"
                                            method="POST">
                                            @csrf
                                            <!-- Event Dropdown -->
                                            <div class="mb-3">
                                                <label for="custom_event_id" class="form-label">Choose the Event to Link
                                                    This Order</label>

                                                @if ($customEvents->isEmpty())
                                                    <select class="form-select" disabled>
                                                        <option>No events available for ordering</option>
                                                    </select>
                                                @else
                                                    <select name="custom_event_id" class="form-select select2" required>
                                                        <option value="">Choose Your Event</option>
                                                        @foreach ($customEvents as $event)
                                                            <option value="{{ $event->id }}">
                                                                {{ $event->request?->title ?? 'Untitled Event' }} -
                                                                {{ \Carbon\Carbon::parse($event->finalized_date)->format('Y-m-d') }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                @endif
                                            </div>

                                            <!-- Quantity Input -->
                                            <div class="mb-3">
                                                <label for="quantity" class="form-label">Quantity</label>
                                                <input type="number" name="quantity" id="quantity" class="form-control"
                                                    min="1" max="{{ $item->quantity_available }}" required>
                                                <div id="quantity-error" class="text-danger mt-1" style="display: none;">
                                                </div>
                                            </div>

                                            <!-- Total Price Display -->
                                            <div class="mb-3">
                                                <label class="form-label">Total Price (LKR)</label>
                                                <input type="text" id="total_price" class="form-control readonly-field"
                                                    readonly>
                                            </div>

                                            <button type="submit" class="btn btn-primary w-100">
                                                Place Order
                                            </button>
                                        </form>
                                    </div>
                                </div> --}}
                                <div class="col-md-7">
                                    <div class="card-body"
                                        style="padding: 25px; border-radius: 12px; background-color: #fdfdfd; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">

                                        <!-- Item Name -->
                                        <h4 class="card-title"
                                            style="font-weight: bold; font-size: 24px; color: #2c3e50; margin-bottom: 15px;">
                                            {{ $item->item_name }}
                                        </h4>

                                        <!-- Description -->
                                        <p
                                            style="background-color: #fff8c4; padding: 15px; border-left: 6px solid #f1c40f; border-radius: 8px; font-size: 15px; color: #7a6000; box-shadow: 0 2px 5px rgba(0,0,0,0.03);">
                                            {{ $item->description }}
                                        </p>

                                        <!-- Price -->
                                        <p style="font-size: 16px; margin-top: 15px; font-weight: 500; color: #34495e;">
                                            <span style="color: #2980b9;">LKR
                                                {{ number_format($item->price_per_unit, 2) }}</span> (per unit)
                                        </p>

                                        <!-- Availability -->
                                        <p style="font-size: 15px; color: #27ae60; font-weight: 500;">
                                            {{ $availableQty }} items currently available
                                            <span style="color: #95a5a6;">(out of {{ $item->quantity_available }} total
                                                supplied)</span>
                                        </p>

                                        <!-- Supplier -->
                                        <p style="font-size: 14px; color: #7f8c8d;">
                                            <strong>Supplier Team:</strong> {{ $item->staff?->name ?? 'N/A' }}
                                        </p>

                                        <!-- Error Alert -->
                                        @if (session('error'))
                                            <div
                                                style="background-color: #f8d7da; color: #721c24; padding: 10px 15px; border-radius: 6px; border: 1px solid #f5c6cb; margin-bottom: 15px;">
                                                {{ session('error') }}
                                            </div>
                                        @endif

                                        <!-- Order Form -->
                                        <form action="{{ route('event_organizer.inventory-items.place-order', $item->id) }}"
                                            method="POST">
                                            @csrf

                                            <!-- Event Dropdown -->
                                            <div style="margin-bottom: 15px;">
                                                <label for="custom_event_id" style="font-weight: 500;">Choose the Event to
                                                    Link This Order</label>

                                                @if ($customEvents->isEmpty())
                                                    <select class="form-select" disabled>
                                                        <option>No events available for ordering</option>
                                                    </select>
                                                @else
                                                    <select name="custom_event_id" class="form-select select2" required>
                                                        <option value="">Choose Your Event</option>
                                                        @foreach ($customEvents as $event)
                                                            <option value="{{ $event->id }}">
                                                                {{ $event->request?->title ?? 'Untitled Event' }} –
                                                                {{ \Carbon\Carbon::parse($event->finalized_date)->format('Y-m-d') }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                @endif
                                            </div>

                                            <!-- Quantity -->
                                            <div style="margin-bottom: 15px;">
                                                <label for="quantity" style="font-weight: 500;">Quantity</label>
                                                <input type="number" name="quantity" id="quantity" class="form-control"
                                                    min="1" max="{{ $item->quantity_available }}" required>
                                                <div id="quantity-error" class="text-danger mt-1" style="display: none;">
                                                </div>
                                            </div>

                                            <!-- Total Price -->
                                            <div style="margin-bottom: 20px;">
                                                <label style="font-weight: 500;">Total Price (LKR)</label>
                                                <input type="text" id="total_price" class="form-control readonly-field"
                                                    readonly>
                                            </div>

                                            <!-- Submit -->
                                            <button type="submit" class="btn btn-primary w-100"
                                                style="padding: 10px 0; font-weight: 600; font-size: 16px;">
                                                Place Order
                                            </button>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2();

            const pricePerUnit = {{ $item->price_per_unit }};
            const maxQty = {{ $availableQty }};

            $('#quantity').on('input', function() {
                const qty = parseInt($(this).val()) || 0;

                // Validate against maximum allowed quantity
                if (qty > maxQty) {
                    $('#quantity-error')
                        .text(`You can't order more than ${maxQty} items currently available.`)
                        .show();
                } else if (qty <= 0) {
                    $('#quantity-error')
                        .text('Please enter a valid quantity greater than zero.')
                        .show();
                } else {
                    $('#quantity-error').hide();
                }

                // Calculate total price (even if qty is invalid, so it reflects instantly)
                const total = qty * pricePerUnit;

                $('#total_price').val(total.toLocaleString('en-LK', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }));
            });

        });
    </script>
@endsection
