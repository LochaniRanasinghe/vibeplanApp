@extends('layouts.event-organizer.master')

@section('css')
    <style>
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 20px;
        }
    </style>
@endsection

@section('title', 'VibePlan-Event Payments')

@section('parent_heading', 'Event Payments')
@section('parent_icon', 'mdi-account-multiple-outline')
@section('child_heading', 'Event Payments')


@section('content')
    <div class="card" style="border-radius: 15px;">
        <div class="card-body">
            <div class="row mt-3 mb-5">
                <b>
                    <h6 style="text-transform: uppercase; font-weight: bold;" class="text-center">Event Payments
                    </h6>
                </b>
                <table class="table align-middle" width="100%" id="payments-table">
                    <thead class="table-primary">
                        <tr>
                            <th>Customer</th>
                            <th>Event</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Status</th>
                            <th>Paid At</th>
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
            $('#payments-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('event_organizer.payments.get-payment-details') }}',
                columns: [{
                        data: 'customer',
                        name: 'customer.name'
                    },
                    {
                        data: 'event',
                        name: 'customEvent.request.title'
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
