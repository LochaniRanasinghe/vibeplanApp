@extends('layouts.event-organizer.master')

@section('css')
    <style>
        .invoice-box {
            background: #ffffff;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 0;
            font-size: 16px;
            color: #333;
            overflow: hidden;
        }

        .invoice-header {
            background-color: #423b45;
            color: #fff;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .invoice-header div {
            flex: 1 1 50%;
        }

        .invoice-section {
            padding: 20px 30px;
        }

        .invoice-section h5 {
            font-weight: bold;
            margin-bottom: 15px;
        }

        .invoice-details {
            border-top: 1px solid #ccc;
            border-bottom: 1px solid #ccc;
            padding: 15px 0;
        }

        .invoice-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e9ecef;
        }

        .invoice-row:last-child {
            border-bottom: none;
        }

        .total-amount {
            background-color: #007bff;
            color: #fff;
            padding: 15px 30px;
            font-size: 18px;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
        }
    </style>
@endsection

@section('title', 'VibePlan - Inventory Order Summary')
@section('parent_heading', 'Inventory Orders')
@section('parent_icon', 'mdi-account-multiple-outline')
@section('child_heading', 'Inventory Orders')
@section('child_heading2', 'Order Details')

@section('content')
    <div class="card-body">
        <div class="row mt-3 mb-5 mx-4">
            <div class="invoice-box shadow">
                <!-- Header Bar -->
                <div class="invoice-header">
                    <div>
                        <strong>Item Name:</strong><br>
                        {{ $inventoryOrder->inventoryItem?->item_name }}
                    </div>
                    <div class="text-end">
                        <strong>Order Status:</strong><br>
                        {{ ucfirst($inventoryOrder->status) }}
                    </div>
                </div>

                <!-- Order Details -->
                <div class="invoice-section">
                    <h5>Order Details</h5>
                    <div class="invoice-details">
                        <div class="invoice-row">
                            <span>Inventory Staff</span>
                            <span>{{ $inventoryOrder->inventoryItem?->staff?->name ?? 'N/A' }}</span>
                        </div>
                        <div class="invoice-row">
                            <span>Event Title</span>
                            <span>{{ $inventoryOrder->customEvent?->request?->title ?? 'N/A' }}</span>
                        </div>
                        <div class="invoice-row">
                            <span>Event Type</span>
                            <span>{{ $inventoryOrder->customEvent?->request?->eventType?->name ?? 'N/A' }}</span>
                        </div>
                        <div class="invoice-row">
                            <span>Ordered By</span>
                            <span>{{ $inventoryOrder->customEvent?->organizer?->name ?? 'N/A' }}</span>
                        </div>
                        <div class="invoice-row">
                            <span>Unit Price</span>
                            <span>LKR
                                {{ number_format($inventoryOrder->inventoryItem?->price_per_unit ?? 0, 2) }}</span>
                        </div>
                        <div class="invoice-row">
                            <span>Quantity Ordered</span>
                            <span>{{ $inventoryOrder->quantity }}</span>
                        </div>
                    </div>
                </div>

                <!-- Total -->
                <div class="total-amount">
                    <span>Total Amount</span>
                    <span>
                        LKR
                        {{ number_format(($inventoryOrder->inventoryItem?->price_per_unit ?? 0) * $inventoryOrder->quantity, 2) }}
                    </span>
                </div>

                <!-- Back button -->
                <div class="text-end p-4">
                    <a href="{{ route('event_organizer.inventory-orders.index') }}" class="btn btn-outline-secondary px-4">
                        Back to Orders
                    </a>
                </div>
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
