@extends('layouts.event-organizer.master')

@section('css')
    <style>
        .readonly-field {
            background-color: #e0e1e3 !important;
        }
    </style>
@endsection

@section('title', 'VibePlan - My Profile')

@section('parent_heading', 'My Profile')
@section('parent_icon', 'mdi-account-multiple-outline')
@section('child_heading', 'My Profile')

@section('content')
    <div class="card" style="border-radius: 15px;">
        <div class="card-body">
            <div class="row mt-3 mb-5 mx-2">
                <h6 class="text-center text-uppercase fw-bold mb-4">My Profile</h6>

                <form action="{{ route('event_organizer.users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}"
                                required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Role</label>
                            <input type="text" class="form-control readonly-field"
                                value="{{ match ($user->role) {
                                    'inventory_staff' => 'Inventory Staff',
                                    'event_organizer' => 'Event Organizer',
                                    'admin' => 'Admin',
                                    default => ucfirst($user->role),
                                } }}"
                                readonly>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <input type="text" name="status" class="form-control readonly-field"
                                value="{{ $user->status == '1' ? 'Active' : 'Inactive' }}" readonly>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone_number" class="form-control"
                                value="{{ old('phone_number', $user->phone_number) }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" name="address" class="form-control"
                                value="{{ old('address', $user->address) }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control"
                                value="{{ old('email', $user->email) }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">New Password (optional)</label>
                            <input type="password" name="password" class="form-control"
                                placeholder="Leave blank to keep current password">
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary px-4">Update Profile</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
