@extends('layouts.admin.master')

@section('css')
    <style>
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 20px;
        }
    </style>
@endsection

@section('title', 'VibePlan-Users')

@section('parent_heading', 'Users')
@section('parent_icon', 'mdi-account-multiple-outline')
@section('child_heading', 'Manage Users')


@section('content')
    <div class="card" style="border-radius: 15px;">
        <div class="card-body">
            <div class="form-group row">
                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.users.create') }}"
                        class="btn btnadd btn-success d-flex justify-content-center align-items-center fw-600 btn-responsive"
                        style="text-decoration: none; color: white; width: 20%;">
                        <i class="mdi mdi-account-plus me-1" style="font-size: 18px;"></i>
                        Register Users
                    </a>
                </div>
            </div>

            <div class="row mt-3 mb-5">
                <b>
                    <h6 style="text-transform: uppercase; font-weight: bold;" class="text-center">Manage Customers</h6>
                </b>
                <table class="table align-middle" width="100%" id="customers-table">
                    <thead class="table-primary">
                        <tr>
                            <th>Name</th>
                            <th>Phone Number</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Address</th>
                            <th>Registered At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="row mt-3 mb-5">
                <b>
                    <h6 style="text-transform: uppercase; font-weight: bold;" class="text-center">Manage Event Organizers
                    </h6>
                </b>
                <table class="table align-middle" width="100%" id="event-organizers-table">
                    <thead class="table-primary">
                        <tr>
                            <th>Name</th>
                            <th>Phone Number</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Address</th>
                            <th>Registered At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="row mt-3 mb-5">
                <b>
                    <h6 style="text-transform: uppercase; font-weight: bold;" class="text-center">Manage Inventory-Staff
                    </h6>
                </b>
                <table class="table align-middle" width="100%" id="inventory-staff-table">
                    <thead class="table-primary">
                        <tr>
                            <th>Name</th>
                            <th>Phone Number</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Address</th>
                            <th>Registered At</th>
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
            $('#customers-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.users.get-customers') }}',
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'phone_number',
                        name: 'phone_number'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'role',
                        name: 'role'
                    },
                    {
                        data: 'address',
                        name: 'address'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $('#event-organizers-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.users.get-event-organizers') }}',
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'phone_number',
                        name: 'phone_number'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'role',
                        name: 'role'
                    },
                    {
                        data: 'address',
                        name: 'address'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $('#inventory-staff-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.users.get-inventory-staff') }}',
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'phone_number',
                        name: 'phone_number'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'role',
                        name: 'role'
                    },
                    {
                        data: 'address',
                        name: 'address'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
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
