@extends('layouts.event-organizer.master')

@section('css')
    <style>
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 20px;
        }
    </style>
@endsection

@section('title', 'VibePlan-Inventory Orders')

@section('parent_heading', 'Inventory Orders')
@section('parent_icon', 'mdi-account-multiple-outline')
@section('child_heading', 'Inventory Orders')


@section('content')
    <div class="card" style="border-radius: 15px;">
        <div class="card-body">
            <div class="row mt-3 mb-5">
                <b>
                    <h6 style="text-transform: uppercase; font-weight: bold;" class="text-center">Manage Inventory Items
                    </h6>
                </b>
                <table class="table align-middle" width="100%" id="inventory-orders-table"">
                    <thead class="table-primary">
                        <tr>
                            <th>Item</th>
                            <th>Inventory Company</th>
                            <th>Event</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Total Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#inventory-orders-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('event_organizer.inventory-orders.get-inventory-orders') }}',
                columns: [{
                        data: 'item_name',
                        name: 'inventoryItem.item_name'
                    },
                    {
                        data: 'ordered_from',
                        name: 'ordered_from'
                    },
                    {
                        data: 'event_title',
                        name: 'event_title'
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
                        name: 'total_price',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $('.select2').select2();
        });
    </script>
@endsection
