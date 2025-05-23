@extends('layouts.event-organizer.master')

@section('css')
    <style>
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 20px;
        }
    </style>
@endsection

@section('title', 'VibePlan-Inventory Items')

@section('parent_heading', 'Inventory Items')
@section('parent_icon', 'mdi-account-multiple-outline')
@section('child_heading', 'Inventory Items')


@section('content')
    <div class="card-body">
        <div class="mt-2 mx-4">
            <b>
                <h6 style="text-transform: uppercase; font-weight: bold;" class="text-center">Order Inventory Items
                </h6>
            </b><br>
            <div class="row mt-3 mb-3">
                @forelse ($items as $item)
                    <div class="col-md-3 mb-4">
                        <div class="card h-100 shadow-sm">
                            {{-- <img src="{{ $item->item_image ?? asset('images/default-image.png') }}" class="card-img-top"
                                alt="{{ $item->item_name }}" style="height: 200px; object-fit: cover;"> --}}
                            <img src="{{ $item->item_image ? asset('storage/' . $item->item_image) : asset('images/default-image.png') }}"
                                class="card-img-top" alt="{{ $item->item_name }}" style="height: 200px; object-fit: cover;">


                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $item->item_name }}</h5>
                                <p class="card-text mb-1"><strong>Price:</strong> LKR
                                    {{ number_format($item->price_per_unit, 2) }} (per unit)</p>
                                <p class="card-text text-muted mb-2">Supplier: {{ $item->staff?->name ?? 'N/A' }}</p>

                                <a href="{{ route('event_organizer.inventory-items.order', $item->id) }}"
                                    class="btn btn-primary mt-auto">
                                    Order Now
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center text-muted">No inventory items available at the moment.</p>
                    </div>
                @endforelse
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
