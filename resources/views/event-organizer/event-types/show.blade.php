@extends('layouts.event-organizer.master')

@section('title', 'VibePlan-Edit Event Type')

@section('parent_heading', 'Event Types')
@section('parent_icon', 'mdi-account-multiple-outline')
@section('child_heading', 'Event Types')
@section('child_heading2', 'Edit Event Type')

@section('content')
    <div class="card" style="border-radius: 15px;">
        <div class="card-body">
            <div class="row mt-3 mb-5 mx-2">
                <b>
                    <h6 style="text-transform: uppercase; font-weight: bold;" class="text-center mb-4">Edit Event Type</h6>
                </b>

                <form action="{{ route('event_organizer.event-types.update', $eventType->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="added_by" value="{{ Auth::id() }}">

                    <div class="row">
                        <!-- Name -->
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Event Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ old('name', $eventType->name) }}" required>
                        </div>

                        <!-- Starting Price -->
                        <div class="col-md-6 mb-3">
                            <label for="starting_price" class="form-label">Starting Price</label>
                            <input type="text" class="form-control" id="starting_price" name="starting_price"
                                value="{{ old('starting_price', $eventType->starting_price) }}" required>
                        </div>

                        <!-- Description -->
                        <div class="col-md-6 mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description', $eventType->description) }}</textarea>
                        </div>

                        <!-- Locations -->
                        <div class="col-md-6 mb-3">
                            <label for="locations" class="form-label">Locations</label>
                            <textarea class="form-control" id="locations" name="locations" rows="3" required>{{ old('locations', $eventType->locations) }}</textarea>
                        </div>

                        <!-- Image Upload -->
                        <div class="col-md-6 mb-3">
                            <label for="image_url" class="form-label">Change Image (optional)</label>
                            <input type="file" name="image_url" class="form-control" accept="image/*"
                                onchange="validateSize(this)">

                            @if ($eventType->image_url)
                                <small class="text-muted d-block mt-2">Current Image:</small>
                                <img src="{{ asset('storage/' . $eventType->image_url) }}" alt="Current Image"
                                    width="120">
                            @endif
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <a href="{{ route('event_organizer.event-types.index') }}" class="btn btn-outline-secondary me-2 px-4">Return
                            Back</a>
                        <button type="submit" class="btn btn-primary px-4">Update Event Type</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        function validateSize(input) {
            const maxSizeMB = 5;
            if (input.files[0].size / 1024 / 1024 > maxSizeMB) {
                alert("File is too large. Maximum size is " + maxSizeMB + " MB.");
                input.value = "";
            }
        }

        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endsection
