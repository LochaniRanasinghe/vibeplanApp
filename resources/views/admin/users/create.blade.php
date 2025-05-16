@extends('layouts.admin.master')

@section('css')

@endsection

@section('title', 'VibePlan-Users')

@section('parent_heading', 'Users')
@section('parent_icon', 'mdi-account-multiple-outline')
@section('child_heading', 'Manage Users')
@section('child_heading2', 'Register Users')


@section('content')

    <div class="card" style="border-radius: 15px;">
        <div class="card-body">
            <div class="row mt-3 mb-5 mx-2">
                <b>
                    <h6 style="text-transform: uppercase; font-weight: bold;" class="text-center mb-4">Register Users</h6>
                </b>
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <!-- Name -->
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Enter full name" required>
                        </div>

                        <!-- Role -->
                        <div class="col-md-6 mb-3">
                            <label for="role" class="form-label">User Type</label>
                            <select class="form-control select2" name="role" id="role" required>
                                <option value="">Select User Type</option>
                                <option value="customer">Customer</option>
                                <option value="event_organizer">Event Organizer</option>
                                <option value="inventory_staff">Inventory Staff</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>

                        <!-- Address -->
                        <div class="col-md-6 mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address"
                                placeholder="Enter address" required>
                        </div>

                        <!-- Phone Number -->
                        <div class="col-md-3 mb-3">
                            <label for="phone_number" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="phone_number" name="phone_number"
                                placeholder="Enter phone number" required pattern="\d{10}"
                                title="Phone number must be exactly 10 digits" maxlength="10"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);">
                        </div>

                        <!-- active_status -->
                        <div class="col-md-3 mb-3">
                            <label for="active_status" class="form-label">Status</label>
                            <select class="form-control select2" name="active_status" id="active_status" required>
                                <option value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="Enter email" required>
                        </div>

                        <!-- Password -->
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Enter password" required>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary px-4 me-2">Return Back</a>
                        <button type="submit" class="btn btn-primary px-4">Register User</button>
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
