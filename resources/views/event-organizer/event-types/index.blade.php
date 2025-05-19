@extends('layouts.event-organizer.master')

@section('css')
    <style>
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 20px;
        }
    </style>
@endsection

@section('title', 'VibePlan-Event Types')

@section('parent_heading', 'Event Types')
@section('parent_icon', 'mdi-account-multiple-outline')
@section('child_heading', 'Event Types')


@section('content')
    <div class="card" style="border-radius: 15px;">
        <div class="card-body">
            <div class="form-group row">
                <div class="d-flex justify-content-end">
                    <a href="{{ route('event_organizer.event-types.create') }}"
                        class="btn btnadd btn-success d-flex justify-content-center align-items-center fw-600 btn-responsive"
                        style="text-decoration: none; color: white; width: 20%;">
                        <i class="mdi mdi-account-plus me-1" style="font-size: 18px;"></i>
                        Add Event Types
                    </a>
                </div>
            </div>

            <div class="row mt-3 mb-5">
                <b>
                    <h6 style="text-transform: uppercase; font-weight: bold;" class="text-center">Manage Event Types</h6>
                </b>
                <table class="table align-middle" width="100%" id="event-types-table">
                    <thead class="table-primary">
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Locations</th>
                            <th>Starting Price</th>
                            <th>Added By</th>
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
            $('#event-types-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('event_organizer.event-types.get-event-types') }}',
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'locations',
                        name: 'locations'
                    },
                    {
                        data: 'starting_price',
                        name: 'starting_price',
                        render: function(data, type, row) {
                            return '$' + parseFloat(data).toFixed(2);
                        }
                    },
                    {
                        data: 'added_by',
                        name: 'added_by'
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
