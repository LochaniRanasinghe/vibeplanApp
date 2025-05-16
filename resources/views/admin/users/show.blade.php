@extends('layouts.admin.master')

@section('css')

@endsection

@section('title', 'VibePlan-Users')

@section('parent_heading', 'Users')
@section('parent_icon', 'mdi-account-multiple-outline')
@section('child_heading', 'Manage Users')
@section('child_heading2', 'Edit Users')


@section('content')

    <div class="card" style="border-radius: 15px;">
        <div class="card-body">
            <div class="row mt-3 mb-5 mx-2">
                <b>
                    <h6 style="text-transform: uppercase; font-weight: bold;" class="text-center mb-4">Edit Users</h6>
                </b>
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <!-- Name -->
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ old('name', $user->name) }}" required>
                        </div>

                        <!-- Role -->
                        <div class="col-md-6 mb-3">
                            <label for="role" class="form-label">User Type</label>
                            <select class="form-control select2" name="role" id="role" required>
                                <option value="">Select User Type</option>
                                <option value="customer" {{ $user->role === 'customer' ? 'selected' : '' }}>Customer
                                </option>
                                <option value="event_organizer" {{ $user->role === 'event_organizer' ? 'selected' : '' }}>
                                    Event Organizer</option>
                                <option value="inventory_staff" {{ $user->role === 'inventory_staff' ? 'selected' : '' }}>
                                    Inventory Staff</option>
                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </div>

                        <!-- Address -->
                        <div class="col-md-6 mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address"
                                value="{{ old('address', $user->address) }}" required>
                        </div>

                        <!-- Phone Number -->
                        <div class="col-md-6 mb-3">
                            <label for="phone_number" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="phone_number" name="phone_number"
                                value="{{ old('phone_number', $user->phone_number) }}" required pattern="\d{10}"
                                title="Phone number must be exactly 10 digits" maxlength="10"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);">
                        </div>

                        <!-- Email -->
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ old('email', $user->email) }}" required>
                        </div>

                        <!-- Password (Optional) -->
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">New Password (Optional)</label>
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Leave blank to keep existing password">
                        </div>

                        {{-- Active Status --}}
                        <div class="col-md-6 mb-3">
                            <label for="active_status" class="form-label">Active Status</label>
                            <select class="form-control select2" name="active_status" id="active_status" required>
                                <option value="">Select Active Status</option>
                                <option value="1" {{ $user->active_status === '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $user->active_status === '0' ? 'selected' : '' }}>Inactive
                                </option>
                            </select>
                        </div>

                        {{-- Registered At-created_at --}}
                        <div class="col-md-6 mb-3">
                            <label for="created_at" class="form-label">Registered At</label>
                            <input type="text" class="form-control" id="created_at" name="created_at"
                                value="{{ $user->created_at }}" disabled>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary px-4 me-2">Return
                            Back</a>
                        <button type="submit" class="btn btn-primary px-4">Update User</button>
                    </div>
                </form>
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
