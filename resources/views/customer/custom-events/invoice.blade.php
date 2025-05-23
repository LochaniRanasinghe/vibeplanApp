@extends('layouts.website.app-logged')

@section('title', 'Invoice')

@section('content')
<div class="container py-5">
    <div class="row g-4">
        {{-- Left: Event Details --}}
        <div class="col-md-6">
            <div class="card shadow-sm p-4">
                <h5 class="mb-3">📅 Event Details</h5>
                <p><strong>Event Type:</strong> {{ $eventType->name }}</p>
                <p><strong>Title:</strong> {{ $eventRequest->title }}</p>
                <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($eventRequest->event_date)->format('Y-m-d') }}</p>
                <p><strong>Guest Count:</strong> {{ $eventRequest->guest_count }}</p>
                <p><strong>Location:</strong> {{ $eventRequest->location }}</p>
            </div>
        </div>

        {{-- Right: Invoice --}}
        <div class="col-md-6">
            <div class="card shadow-sm p-4">
                <h5 class="mb-3">🧾 Invoice</h5>
                <p><strong>Organizer:</strong> {{ $organizer->name }}</p>
                <p><strong>Finalized Date:</strong> {{ \Carbon\Carbon::parse($customEvent->finalized_date)->format('Y-m-d') }}</p>
                <p><strong>Total Amount:</strong> <span class="fw-bold text-success">Rs. {{ number_format($customEvent->total_price) }}</span></p>
                <p><strong>Status:</strong>
                    <span class="badge bg-{{ $customEvent->status === 'approved' ? 'success' : 'warning' }}">
                        {{ ucfirst($customEvent->status) }}
                    </span>
                </p>

                @if ($customEvent->payments && $customEvent->payments->count())
                    <hr>
                    <h6 class="mt-3">💰 Payment Details</h6>
                    @php $payment = $customEvent->payments->first(); @endphp
                    <p><strong>Paid At:</strong> {{ \Carbon\Carbon::parse($payment->paid_at)->format('Y-m-d') }}</p>
                    <p><strong>Payment Method:</strong> {{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</p>
                    <p><strong>Amount Paid:</strong> <span class="text-success">Rs. {{ number_format($payment->amount) }}</span></p>
                    @if ($payment->slip_path)
                        <p><strong>Payment Slip:</strong>
                            <a href="{{ asset('storage/' . $payment->slip_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">View Slip</a>
                        </p>
                    @endif
                @else
                    <hr>
                    <p class="text-danger mt-3"><i class="mdi mdi-alert-circle"></i> Payment not received yet.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
