@extends('layouts.admin.master')

@section('css')
    <style>
        .readonly-field {
            background-color: #e0e1e3 !important;
        }
    </style>
@endsection

@section('title', 'VibePlan-View Event Payment')

@section('parent_heading', 'Event Payments')
@section('parent_icon', 'mdi-account-multiple-outline')
@section('child_heading', 'Event Payments')
@section('child_heading2', 'Edit Event Payment')

@section('content')
    <div class="card" style="border-radius: 15px;">
        <div class="card-body">
            <div class="row mt-3 mb-5 mx-2">
                <b>
                    <h6 class="text-center mb-4 text-uppercase fw-bold">Edit Event Payment</h6>
                </b>

                <form action="{{ route('admin.payments.update', $payment->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Customer</label>
                            <input type="text" class="form-control readonly-field"
                                value="{{ $payment->customer?->name ?? 'N/A' }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Event Title</label>
                            <input type="text" class="form-control readonly-field"
                                value="{{ $payment->customEvent?->request?->title ?? 'N/A' }}" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Organizer</label>
                            <input type="text" class="form-control readonly-field"
                                value="{{ $payment->customEvent?->organizer?->name ?? 'N/A' }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Total Amount</label>
                            <input type="text" class="form-control readonly-field"
                                value="{{ number_format($payment->amount, 2) }}" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Payment Method</label>
                            <input type="text" class="form-control readonly-field"
                                value="{{ ucfirst($payment->payment_method) }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Paid At</label>
                            <input type="text" class="form-control readonly-field"
                                value="{{ $payment->paid_at ? \Carbon\Carbon::parse($payment->paid_at)->format('Y-m-d') : 'N/A' }}"
                                readonly>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Payment Status</label>
                            <select name="payment_status" class="form-select select2">
                                <option value="pending" {{ $payment->payment_status === 'pending' ? 'selected' : '' }}>
                                    Pending
                                </option>
                                <option value="paid" {{ $payment->payment_status === 'paid' ? 'selected' : '' }}>Paid
                                </option>
                                <option value="failed" {{ $payment->payment_status === 'failed' ? 'selected' : '' }}>Failed
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="text-end mt-4">
                        <a href="{{ route('admin.payments.index') }}" class="btn btn-outline-secondary me-2 px-4">Return
                            Back</a>
                        <button type="submit" class="btn btn-primary px-4">Update Status</button>
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
