@extends('layouts.website.app-logged')

@section('title', 'My Events')

@section('content')
    <br>
    <h1 style="text-align:center; font-size: 40px; font-family: 'Dancing Script', cursive; font-weight: 600;" class="mb-4">
        Confirmed Events</h1>

    <div class="container mt-3">
        <div class="row g-4 align-items-start">
            <b>
                <p style="text-align: justify; font-size: 16px;">
                    <i class="mdi mdi-note-text-outline text-danger me-1"></i>
                    These events have been confirmed and are now awaiting payment.
    You can upload your payment receipt and click <strong>"Submit Payment"</strong> once done.
                </p>
            </b>
            <table id="customerEventTable" class="table align-middle" width="100%" id="inventory-items-table">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Event Type</th>
                        <th>Title</th>
                        <th>Location</th>
                        <th>Finalized Date</th>
                        <th>Status</th>
                        <th>Payment Status</th>
                        <th>Total Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <br><br>
    <h1 style="text-align:center; font-size: 40px; font-family: 'Dancing Script', cursive; font-weight: 600;" class="mb-4">
        Requested Events</h1>


    <div class="container mt-3">
        <div class="row g-4 align-items-start">
            <b>
                <p style="text-align: justify; font-size: 16px;">
                    <i class="mdi mdi-note-text-outline text-danger me-1"></i>
                    These requests have been submitted by event organizers and are currently awaiting approval.
                    Please wait until the event appears under the confirmed events list.
                </p>
            </b>

            <table id="customerEventRequestsTable" class="table align-middle" width="100%" id="inventory-items-table">
                <thead class="table-primary">
                    <tr>
                        <th>Title</th>
                        <th>Title</th>
                        <th>Event Type</th>
                        <th>Event Date</th>
                        <th>Guest Count</th>
                        <th>Location</th>
                        <th>Status</th>
                        {{-- <th>Actions</th> --}}
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#customerEventRequestsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('customer.event-requests.get-event-requests') }}',
                columns: [{
                        data: 'event_id',
                        name: 'event_id',
                        render: function(data, type, row) {
                            return `<span class="badge rounded-pill bg-primary">${data}</span>`;
                        }
                    }, {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'event_type',
                        name: 'eventType.name'
                    },
                    {
                        data: 'date',
                        name: 'event_date'
                    },
                    {
                        data: 'guest_count',
                        name: 'guest_count'
                    },
                    {
                        data: 'location',
                        name: 'location'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(data, type, row) {
                            if (data === 'pending') {
                                return '<span class="badge bg-warning">Pending</span>';
                            } else if (data === 'approved') {
                                return '<span class="badge bg-success">Approved</span>';
                            } else if (data === 'rejected') {
                                return '<span class="badge bg-danger">Rejected</span>';
                            } else if (data === 'completed') {
                                return '<span class="badge bg-info">Completed</span>';
                            } else {
                                return '<span class="badge bg-secondary">Unknown</span>';
                            }
                            return data;
                        }
                    },
                    // {
                    //     data: 'actions',
                    //     name: 'actions',
                    //     orderable: false,
                    //     searchable: false
                    // },
                ]
            });

            $('#customerEventTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('customer.custom-events.get-custom-events') }}',
                columns: [{
                        data: 'custom_event_id',
                        name: 'id',
                        render: function(data) {
                            return `<span class="badge rounded-pill bg-primary">${data}</span>`;
                        }
                    },

                    {
                        data: 'event_type',
                        name: 'request.eventType.name'
                    },
                    {
                        data: 'title',
                        name: 'request.title'
                    },
                    {
                        data: 'location',
                        name: 'request.location'
                    },
                    {
                        data: 'finalized_date',
                        name: 'finalized_date'
                    },

                    {
                        data: 'status',
                        name: 'status',
                        render: function(data) {
                            let badge = 'secondary';
                            switch (data) {
                                case 'pending':
                                    badge = 'warning';
                                    break;
                                case 'confirmed':
                                    badge = 'success';
                                    break;
                                case 'rejected':
                                    badge = 'danger';
                                    break;
                                case 'inprogress':
                                    badge = 'primary';
                                    break;
                            }
                            return `<span class="badge bg-${badge}">${data.charAt(0).toUpperCase() + data.slice(1)}</span>`;
                        }
                    },
                    {
                        data: 'payment_status',
                        name: 'payment_status',
                        render: function(data) {
                            if (data === 'paid') {
                                return `<span class="badge bg-success">Paid</span>`;
                            } else {
                                return `<span class="badge bg-danger">Awaiting Payment</span>`;
                            }
                        }
                    },
                    {
                        data: 'total_price',
                        name: 'total_price'
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
