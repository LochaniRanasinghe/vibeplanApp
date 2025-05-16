@extends('layouts.admin.master')

@section('css')
    <style>
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 20px;
        }
    </style>
@endsection

@section('title', 'VibePlan-Requested Events')

@section('parent_heading', 'Requested Events')
@section('parent_icon', 'mdi-account-multiple-outline')
@section('child_heading', 'Requested Events')


@section('content')
    <div class="card" style="border-radius: 15px;">
        <div class="card-body">
            <div class="row mt-3 mb-5">
                <b>
                    <h6 style="text-transform: uppercase; font-weight: bold;" class="text-center">Requested Events By
                        Customers</h6>
                </b>
                <table class="table align-middle" width="100%" id="event-requests-table">
                    <thead class="table-primary">
                        <tr>
                            <th>Customer</th>
                            <th>Event Type</th>
                            <th>Title</th>
                            <th>Location</th>
                            <th>Event Date</th>
                            <th>Status</th>
                            <th>Created At</th>
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
            $('#event-requests-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.event-requests.get-event-requests') }}',
                columns: [{
                        data: 'customer',
                        name: 'customer'
                    },
                    {
                        data: 'event_type',
                        name: 'event_type'
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'location',
                        name: 'location'
                    },
                    {
                        data: 'event_date',
                        name: 'event_date'
                    },
                    {
                        data: 'status',
                        name: 'status'
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
                    }
                ]
            });

            $('.select2').select2();
        });
    </script>
@endsection
