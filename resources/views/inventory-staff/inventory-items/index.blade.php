@extends('layouts.inventory-staff.master')

@section('css')
    <style>
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 20px;
        }
    </style>
@endsection

@section('title', 'VibePlan-Inventory Items')

@section('parent_heading', 'Inventory Items')
@section('parent_icon', 'mdi-account-multiple-outline')
@section('child_heading', 'Inventory Items')


@section('content')
    <div class="card" style="border-radius: 15px;">
        <div class="card-body">
            <div class="form-group row">
                <div class="d-flex justify-content-end">
                    <a href="{{ route('inventory_staff.inventory-items.create') }}"
                        class="btn btnadd btn-success d-flex justify-content-center align-items-center fw-600 btn-responsive"
                        style="text-decoration: none; color: white; width: 20%;">
                        <i class="mdi mdi-account-plus me-1" style="font-size: 18px;"></i>
                        Add Inventory Items
                    </a>
                </div>
            </div>

            <div class="row mt-3 mb-5">
                <b>
                    <h6 style="text-transform: uppercase; font-weight: bold;" class="text-center">Manage Inventory Items
                    </h6>
                </b>
                <table class="table align-middle" width="100%" id="inventory-items-table">
                    <thead class="table-primary">
                        <tr>
                            <th>Item ID</th>
                            <th>Item</th>
                            <th>Quantity In Stock</th>
                            <th>Price Per Unit</th>
                            <th>Added At</th>
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
            $('#inventory-items-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('inventory_staff.inventory-items.get-inventory-items') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'item_name',
                        name: 'item_name'
                    },
                    {
                        data: 'quantity_available',
                        name: 'quantity_available'
                    },
                    {
                        data: 'price_per_unit',
                        name: 'price_per_unit',
                        render: function(data, type, row) {
                            return 'LKR ' + parseFloat(data).toLocaleString(undefined, {
                                minimumFractionDigits: 2
                            });
                        }
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $('.select2').select2();
        });
    </script>
@endsection
