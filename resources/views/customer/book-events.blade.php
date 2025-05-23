@extends('layouts.website.app-logged')

@section('title', 'Book Events')

@section('content')
    <br>
    <h1 style="text-align:center; font-size: 40px; font-family: 'Dancing Script', cursive; font-weight: 600;" class="mb-4">
        Book Events</h1>

    <div class="container mt-5">
        <div class="row row-cols-1 row-cols-md-4 g-4 justify-content-center">
            @foreach ($eventTypes as $event)
                <div class="col">
                    <div class="card h-100 shadow-sm" style="border-radius: 10px;">
                        <img src="{{ asset('storage/' . $event->image_url) }}" class="card-img-top" alt="{{ $event->name }}"
                            style="height: 180px; object-fit: cover; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold">{{ $event->name }}</h5>
                            <p class="card-text" style="font-size: 14px;">{{ Str::limit($event->description, 100) }}</p>
                            <div class="mb-2">
                                @foreach (explode(',', $event->locations) as $location)
                                    <span class="badge bg-secondary me-1">{{ trim($location) }}</span>
                                @endforeach
                            </div>
                            <p class="fw-bold text-primary mb-3">Starts From Rs. {{ number_format($event->starting_price) }}
                            </p>
                            <a href="{{ route('customer.event-request.show', $event->id) }}"
                                class="btn btn-primary mt-auto">Order Now</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection
