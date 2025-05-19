@extends('layouts.event-organizer.master')

@section('css')

@endsection

@section('title', 'VibePlan-Event Types ')

@section('parent_heading', 'Event Types ')
@section('parent_icon', 'mdi-account-multiple-outline')
@section('child_heading', 'Event Types')
@section('child_heading2', 'Add Eevent Types')


@section('content')

    <div class="card" style="border-radius: 15px;">
        <div class="card-body">
            <div class="row mt-3 mb-5 mx-2">
                <b>
                    <h6 style="text-transform: uppercase; font-weight: bold;" class="text-center mb-4">Add Event Types</h6>
                </b>
                {{-- form here --}}
                <form action="{{ route('event_organizer.event-types.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="added_by" value="{{ Auth::id() }}">

                    <div class="row">
                        <!-- Name -->
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Event Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Enter event name" required>
                        </div>

                        <!-- Starting Price -->
                        <div class="col-md-6 mb-3">
                            <label for="starting_price" class="form-label">Starting Price</label>
                            <input type="text" class="form-control" id="starting_price" name="starting_price"
                                placeholder="Enter starting price" required>
                        </div>

                        <!-- Description -->
                        <div class="col-md-6 mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter Description"
                                required></textarea>
                        </div>

                        <!-- Locations (textarea) -->
                        <div class="col-md-6 mb-3">
                            <label for="locations" class="form-label">Locations</label>
                            <textarea class="form-control" id="locations" name="locations" rows="3" placeholder="Enter available locations"
                                required></textarea>
                        </div>

                        <!-- Image Upload -->
                        <div class="col-md-6 mb-3">
                            <label for="image_url" class="form-label">Image</label>
                            <input type="file" name="image_url" class="form-control" accept="image/*"
                                onchange="validateSize(this)">
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <a href="{{ route('event_organizer.event-types.index') }}"
                            class="btn btn-outline-secondary me-2 px-4">Return
                            Back</a>
                        <button type="submit" class="btn btn-primary px-4">Create Event Type</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            function validateSize(input) {
                const maxSizeMB = 5;
                if (input.files[0].size / 1024 / 1024 > maxSizeMB) {
                    alert("File is too large. Maximum size is " + maxSizeMB + " MB.");
                    input.value = "";
                }
            }

            $('.select2').select2();
        });
    </script>
@endsection
