@extends('layouts.website.app-logged')

@section('title', 'Upload Payment')

@section('content')
<div class="container py-5">
    <div class="row g-4">
        {{-- Left: Event Details --}}
        <div class="col-md-6">
            <div class="card shadow-sm p-4">
                <h5 class="mb-3">📅 Event Info</h5>
                <p><strong>Event Type:</strong> {{ $customEvent->request->eventType->name }}</p>
                <p><strong>Title:</strong> {{ $customEvent->request->title }}</p>
                <p><strong>Event Date:</strong> {{ \Carbon\Carbon::parse($customEvent->request->event_date)->format('Y-m-d') }}</p>
                <p><strong>Total Amount:</strong> <span class="fw-bold text-success">Rs. {{ number_format($totalAmount) }}</span></p>
            </div>
        </div>

        {{-- Right: Upload Form --}}
        <div class="col-md-6">
            <div class="card shadow-sm p-4">
                <h5 class="mb-3">💳 Upload Payment</h5>

                <form method="POST" action="{{ route('customer.customer.payment.store', $customEvent->id) }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Payment Method</label>
                        <select name="payment_method" class="form-select" required>
                            <option value="">Select Method</option>
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="card">Card Payment</option>
                            <option value="cash">Cash</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Upload Payment Slip (PDF/JPG/PNG)</label>
                        <input type="file" name="payment_slip" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Additional Notes (optional)</label>
                        <textarea name="notes" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="text-center mt-4">
                        <a href="{{ route('customer.event-requests.index') }}" class="btn btn-outline-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-success px-4">Submit Payment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
