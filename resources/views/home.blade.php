@extends('layouts.website.app')

@section('title', 'Home')

@section('content')
    <br><h2 style="text-align:center;" class="mb-4">Explore Our Events</h2><br>

    <div class="container mt-3">
        <div class="row row-cols-1 row-cols-md-4 g-4 justify-content-center">
            @foreach ($eventTypes as $event)
                <div class="col">
                    <div class="card h-100 shadow-sm" style="border-radius: 10px;">
                        <img src="{{ asset('storage/' . $event->image_url) }}" class="card-img-top" alt="{{ $event->name }}"
                            style="height: 180px; object-fit: cover; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $event->name }}</h5>
                            <p class="card-text" style="font-size: 14px;">{{ Str::limit($event->description, 100) }}</p>
                            <div class="mb-2">
                                @foreach (explode(',', $event->locations) as $location)
                                    <span class="badge bg-secondary me-1">{{ trim($location) }}</span>
                                @endforeach
                            </div>
                            <p class="fw-bold text-primary mb-3">Starts From Rs. {{ number_format($event->starting_price) }}
                            </p>
                            <a href="#" class="btn btn-primary mt-auto">Order Now</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection
