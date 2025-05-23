@extends('layouts.website.app-logged')

@section('css')
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital@1&display=swap" rel="stylesheet">
@endsection

@section('title', $eventType->name)

@section('content')
    <br>
    <h1 style="text-align:center; font-size: 40px; font-family: 'Dancing Script', cursive; font-weight: 600;" class="mb-4">
        Event Details</h1>

    <div class="container py-5">
        <div class="row g-5 align-items-center">
            <!-- Event Image -->
            <div class="col-md-6">
                <img src="{{ asset('storage/' . $eventType->image_url) }}" alt="{{ $eventType->name }}"
                    class="img-fluid rounded shadow">
            </div>

            <!-- Event Details -->
            <div class="col-md-6">
                <h2 class="fw-bold mb-3">{{ $eventType->name }}</h2>
                <p class="text-muted mb-3">{{ $eventType->description }}</p>

                <div class="mb-3">
                    <strong>Available Locations:</strong><br>
                    @foreach ($locations as $location)
                        <span class="badge bg-secondary me-1">{{ trim($location) }}</span>
                    @endforeach
                </div>

                <p class="fs-5 fw-bold text-primary">Starting Price: Rs. {{ number_format($eventType->starting_price) }}</p>

                <hr>

                <!-- Organizer Info -->
                <div class="mt-4">
                    <h5 class="fw-semibold mb-3">Organizer Details</h5>

                    @if ($eventType->addedBy)
                        <div class="d-flex align-items-start bg-white shadow rounded p-3" style="gap: 20px;">
                            <img src="{{ asset('images/profile-pic.png') }}" alt="Organizer"
                                style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 2px solid #6a1d61;">
                            <div>
                                <div
                                    style="font-family: 'Georgia', serif; font-style: italic; font-size: 0.95rem; color: #333;">
                                    <p class="mb-1">Name: {{ $eventType->addedBy->name }}</p>
                                    <p class="mb-1">Phone: {{ $eventType->addedBy->phone_number ?? 'N/A' }}</p>
                                    <p class="mb-1">Email: {{ $eventType->addedBy->email }}</p>
                                    <p class="mb-0">Address: {{ $eventType->addedBy->address ?? 'N/A' }}</p>
                                </div>

                                <div class="text-warning">
                                    <i class="mdi mdi-star"></i>
                                    <i class="mdi mdi-star"></i>
                                    <i class="mdi mdi-star"></i>
                                    <i class="mdi mdi-star-half-full"></i>
                                    <i class="mdi mdi-star-outline"></i>
                                    <small class="text-muted ms-2">(4.5/5 based on 18 reviews)</small>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning mt-2">Organizer information is not available.</div>
                    @endif
                </div>

                <!-- Action Buttons -->
                <div class="mt-4">
                    <a href="{{ route('customer.event-request.create', $eventType->id) }}" class="btn btn-success px-4 mt-3">
                        Proceed to Order
                    </a>
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary ms-2 mt-3">Back to Events</a>
                </div>
            </div>
        </div>
    </div>
@endsection
