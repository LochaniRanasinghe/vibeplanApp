@extends('layouts.event-organizer.master')

@section('css')
    <style>
        .readonly-field {
            background-color: #e0e1e3 !important;
        }
    </style>
@endsection

@section('title', 'VibePlan-Edit Scheduled Events')

@section('parent_heading', 'Scheduled Events')
@section('parent_icon', 'mdi-account-multiple-outline')
@section('child_heading', 'Scheduled Events')
@section('child_heading2', 'Edit Scheduled Events')

@section('content')
    <ul class="nav nav-tabs mb-4" id="customTabs">
        <li class="nav-item">
            <a class="nav-link active" id="inventory-tab" data-bs-toggle="tab" href="#inventory" role="tab">View Details</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="payments-tab" data-bs-toggle="tab" href="#payments" role="tab">Customer Payments</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="details-tab" data-bs-toggle="tab" href="#details" role="tab">Inventory Items</a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="inventory" role="tabpanel">
            {{-- Put your inventory form or display here --}}
            <div class="card">
                <div class="card-body">
                    @include('event-organizer.scheduled-events.components.view-details', [
                        'customEvent' => $customEvent,
                    ])
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="payments" role="tabpanel">
            {{-- Add your Customer Payments content here --}}
            <div class="card">
                <div class="card-body">
                    @include('event-organizer.scheduled-events.components.payments', ['customEvent' => $customEvent])
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="details" role="tabpanel">
            {{-- Add your View Details content here --}}
            <div class="card">
                <div class="card-body">
                    @include('event-organizer.scheduled-events.components.inventory', [
                        'customEvent' => $customEvent,
                    ])
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2();

            $('#event-inventory-orders').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('event_organizer.inventory-orders.by-custom-event', $customEvent->id) }}",
                columns: [{
                        data: 'item_name',
                        name: 'inventoryItem.item_name'
                    },
                    {
                        data: 'ordered_from',
                        name: 'inventoryItem.staff.name'
                    },
                    {
                        data: 'quantity',
                        name: 'quantity'
                    },
                    {
                        data: 'unit_price',
                        name: 'inventoryItem.price_per_unit'
                    },
                    {
                        data: 'total_price',
                        name: 'total_price'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    }
                ]
            });

            $('#payments-by-event').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('event_organizer.payments.by-custom-event', $customEvent->id) }}",
                columns: [{
                        data: 'customer',
                        name: 'customer.name'
                    },
                    {
                        data: 'amount',
                        name: 'amount'
                    },
                    {
                        data: 'payment_method',
                        name: 'payment_method'
                    },
                    {
                        data: 'payment_status',
                        name: 'payment_status'
                    },
                    {
                        data: 'paid_at',
                        name: 'paid_at'
                    }
                ]
            });
        });
    </script>
@endsection
