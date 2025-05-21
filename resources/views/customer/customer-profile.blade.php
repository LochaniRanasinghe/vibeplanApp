@extends('layouts.website.app-logged')

@section('title', 'My Profile')

@section('content')
<br>
<h1 class="text-center mb-4" style="font-size: 40px; font-family: 'Dancing Script', cursive; font-weight: 600;">
    My Profile
</h1>

<div class="container mt-4">
    <form method="POST" action="{{ route('customer.profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-4">
            {{-- Right Side: Name, Phone, Address --}}
            <div class="col-md-7">
                <div class="card shadow-sm p-4 h-100">
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone_number" class="form-control" value="{{ old('phone_number', $user->phone_number) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <input type="text" name="address" class="form-control" value="{{ old('address', $user->address) }}">
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary px-4">Update Profile</button>
                    </div>
                </div>
            </div>

            {{-- Left Side: Image, Email, Password --}}
            <div class="col-md-5">
                <div class="card shadow-sm p-4 h-100">
                    <div class="text-center mb-3">
                        @if ($user->profile_image)
                            <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profile"
                                class="rounded-circle shadow" width="120" height="120"
                                style="object-fit: cover; border: 3px solid #6a1d61;">
                        @else
                            <img src="{{ asset('images/customer-img.jpg') }}" alt="Default"
                                class="rounded-circle shadow" width="120" height="120"
                                style="object-fit: cover; border: 3px solid #6a1d61;">
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Profile Photo</label>
                        <input type="file" name="profile_image" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input type="password" name="password" autocomplete="new-password" class="form-control" placeholder="Leave blank to keep current password">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" autocomplete="new-password" class="form-control" placeholder="Confirm new password">
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
