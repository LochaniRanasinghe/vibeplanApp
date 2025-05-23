@extends('layouts.website.app')

@section('title', 'Home')

@section('content')
    <br>
    <div style="text-align: center;">
        <h1 style="
            font-size: 40px;
            font-family: 'Dancing Script', cursive;
            font-weight: 600;
            color:#300628;
            background-color: #fff; /* or try rgba(130, 77, 116, 0.3) */
            padding: 10px 20px;
            border-radius: 12px;
            display: inline-block;
        "
            class="mb-4">
            Explore Our Events
        </h1>
    </div>
    <br>

    <div class="container mt-3">
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
                            <p class="fw-bold mb-3" style="color: rgb(23, 119, 216);">Starts From Rs.
                                {{ number_format($event->starting_price) }}
                            </p>
                            <a href="{{ route('customer.event-request.show', $event->id) }}" class="btn mt-auto"
                                style="background-color: #903b98; color: #fff; border: none;">
                                Order Now
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection
