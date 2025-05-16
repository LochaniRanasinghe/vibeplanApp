@extends('layouts.admin.master')

@section('css')
    <style>
        .readonly-field {
            background-color: #e0e1e3 !important;
        }
    </style>
@endsection

@section('title', 'VibePlan-Edit Requested Events')

@section('parent_heading', 'Requested Events')
@section('parent_icon', 'mdi-account-multiple-outline')
@section('child_heading', 'Requested Events')
@section('child_heading2', 'Edit Requested Events')

@section('content')
    <div class="card" style="border-radius: 15px;">
        <div class="card-body">
            <div class="row mt-3 mb-5 mx-2">
                <b>
                    <h6 style="text-transform: uppercase; font-weight: bold;" class="text-center mb-4">Edit Requested Events
                    </h6>
                </b>

                <form action="{{ route('admin.event-requests.update', $eventRequest->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="customer_name" class="form-label">Customer Name</label>
                            <input type="text" id="customer_name" class="form-control readonly-field"
                                value="{{ $eventRequest->customer?->name }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="event_type" class="form-label">Event Type</label>
                            <input type="text" id="event_type" class="form-control readonly-field"
                                value="{{ $eventRequest->eventType?->name }}" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" id="title" class="form-control readonly-field"
                                value="{{ $eventRequest->title }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="event_date" class="form-label">Event Date</label>
                            <input type="text" id="event_date" class="form-control readonly-field"
                                value="{{ $eventRequest->event_date ? \Carbon\Carbon::parse($eventRequest->event_date)->format('Y-m-d') : 'N/A' }}"
                                readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="guest_count" class="form-label">Guest Count</label>
                            <input type="text" id="guest_count" class="form-control readonly-field"
                                value="{{ $eventRequest->guest_count }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" id="location" class="form-control readonly-field"
                                value="{{ $eventRequest->location }}" readonly>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea id="description" class="form-control readonly-field" rows="4" readonly>{{ $eventRequest->description }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select select2">
                            <option value="pending" {{ $eventRequest->status == 'pending' ? 'selected' : '' }}>Pending
                            </option>
                            <option value="approved" {{ $eventRequest->status == 'approved' ? 'selected' : '' }}>Approved
                            </option>
                            <option value="completed" {{ $eventRequest->status == 'completed' ? 'selected' : '' }}>
                                Completed</option>
                            <option value="rejected" {{ $eventRequest->status == 'rejected' ? 'selected' : '' }}>Rejected
                            </option>
                        </select>
                    </div>

                    <div class="text-end">
                        <a href="{{ route('admin.event-requests.index') }}"
                            class="btn btn-outline-secondary me-2 px-4">Return
                            Back</a>
                        <button type="submit" class="btn btn-primary">Update Status</button>
                    </div>
                </form>

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
