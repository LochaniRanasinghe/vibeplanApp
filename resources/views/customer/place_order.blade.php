@extends('layouts.website.app-logged')

@section('title', 'Request ' . $eventType->name)

@section('content')
    <br>
    <h1 style="text-align:center; font-size: 40px; font-family: 'Dancing Script', cursive; font-weight: 600;" class="mb-4">
        Place Order</h1>

    <div class="container mt-5">
        <div class="row g-4 align-items-start">

            <!-- Left: Event Details -->
            <div class="col-md-6">
                <div class="card shadow-sm p-4 h-100" style="border-radius: 12px;">
                    <b>
                        <h6 style="text-transform: uppercase; font-weight: bold;" class="text-center mb-4 text-primary">{{ $eventType->name }}
                        </h6>
                    </b>
                    <img src="{{ asset('storage/' . $eventType->image_url) }}" alt="{{ $eventType->name }}"
                        class="img-fluid rounded mb-3" style="object-fit: cover; height: 250px; width: 100%;">

                    <p class="text-muted" style="font-size: 14px; font-style: italic;">{{ $eventType->description }}</p>

                    <p><strong>Starting Price:</strong> Rs. {{ number_format($eventType->starting_price) }}</p>

                    <div class="mt-2">
                        <strong>Available Locations:</strong><br>
                        @foreach (explode(',', $eventType->locations) as $location)
                            <span class="badge bg-secondary me-1">{{ trim($location) }}</span>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Right: Request Form -->
            <div class="col-md-6">
                <div class="card shadow-sm p-4 h-100" style="border-radius: 12px;">
                    <b>
                        <h6 style="text-transform: uppercase; font-weight: bold;" class="text-center mb-4">Request this Event
                        </h6>
                    </b>
                    <form method="POST" action="{{ route('customer.event-request.store') }}">
                        @csrf
                        <input type="hidden" name="event_type_id" value="{{ $eventType->id }}">

                        <div class="mb-3">
                            <label class="form-label">
                                Add a title for your {{ $eventType->name }}
                            </label>
                            <input type="text" name="title" class="form-control" placeholder="e.g. My Dream Wedding" required>
                        </div>                        

                        <div class="mb-3">
                            <label class="form-label">
                                Event Overview – describe the tone, theme, and anything special.
                            </label>
                            
                            <textarea name="description" rows="4" class="form-control" placeholder="Describe your event..." required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Event Date</label>
                            <input type="date" name="event_date" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Guest Count</label>
                            <input type="number" name="guest_count" class="form-control" min="1" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Select Location</label>
                            <select name="location" class="form-select" required>
                                @foreach ($locations as $location)
                                    <option value="{{ trim($location) }}">{{ trim($location) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="text-center mt-4">
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary me-3">Cancel</a>
                            <button type="submit" class="btn btn-success px-4">Submit Request</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
