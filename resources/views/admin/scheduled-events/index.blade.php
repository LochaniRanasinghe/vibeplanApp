@extends('layouts.admin.master')

@section('css')
    <style>
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 20px;
        }
    </style>
@endsection

@section('title', 'VibePlan-Scheduled Events')

@section('parent_heading', 'Scheduled Events')
@section('parent_icon', 'mdi-account-multiple-outline')
@section('child_heading', 'Scheduled Events')


@section('content')
    <div class="card" style="border-radius: 15px;">
        <div class="card-body">
        
            <div class="row mt-3 mb-5">
                <b>
                    <h6 style="text-transform: uppercase; font-weight: bold;" class="text-center">Manage Scheduled Events
                    </h6>
                </b>
                <table class="table align-middle" width="100%" id="custom-events-table">
                    <thead class="table-primary">
                        <tr>
                            <th>Event Title</th>
                            <th>Customer</th>
                            <th>Organizer</th>
                            <th>Finalized Date</th>
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
            $('#custom-events-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.custom-events.get-custom-events') }}',
                columns: [{
                        data: 'event_request',
                        name: 'request.title'
                    },
                    {
                        data: 'customer',
                        name: 'request.customer.name'
                    },
                    {
                        data: 'organizer',
                        name: 'organizer.name'
                    },
                    {
                        data: 'finalized_date',
                        name: 'finalized_date'
                    },
                    {
                        data: 'total_price',
                        name: 'total_price'
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
                    }
                ]
            });

            $('.select2').select2();
        });
    </script>
@endsection
