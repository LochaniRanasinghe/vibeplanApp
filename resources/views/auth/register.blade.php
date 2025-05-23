@extends('layouts.website.app')

@section('title', 'Register')

@section('css')
    <style>
        .wrapper {
            display: flex;
            align-items: baseline;
            justify-content: center;
            min-height: 100vh;
        }

        #togglePassword {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            z-index: 2;
        }

        .form-control {
            padding-right: 30px;
            position: relative;
        }
    </style>
@endsection

@section('content')
    <div class="wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-11 mx-auto mt-5">
                    <div class="card radius-10">
                        <div class="card-body p-4">
                            <div class="text-center mt-4">
                                <h1 style="font-family: 'Dancing Script', cursive; font-size: 48px; color: rgb(98, 32, 4);">
                                    VibePlan Registration Form
                                </h1>
                                <p
                                    style="font-family: 'Montserrat', sans-serif; letter-spacing: 5px; font-size: 14px; color: #6b4324;">
                                    EVENT ORGANIZERS & PLANNERS
                                </p>
                            </div>
                            <hr>
                            <form class="form-body row g-3 m-4" action="{{ route('registeruser') }}" method="POST">
                                @csrf

                                {{-- Display Errors and Session Messages --}}
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        @foreach ($errors->all() as $error)
                                            <div>{{ $error }}</div>
                                        @endforeach
                                    </div>
                                @endif

                                @if (Session::has('success'))
                                    <div class="alert alert-success">{{ Session::get('success') }}</div>
                                @endif

                                @if (Session::has('fail'))
                                    <div class="alert alert-danger">{{ Session::get('fail') }}</div>
                                @endif

                                {{-- Full Name --}}
                                <div class="col-md-8 mx-auto form-group">
                                    <label for="name" style="color: rgb(73, 50, 33);">Full Name</label>
                                    <input type="text" id="name" name="name" placeholder="Enter full name"
                                        class="form-control" value="{{ old('name') }}" required>
                                </div>

                                {{-- Role --}}
                                <div class="col-md-4 mx-auto form-group">
                                    <label for="role" style="color: rgb(73, 50, 33);">Who Are You?</label>
                                    <select class="form-control" name="role" id="role" required>
                                        <option value="">Select User Type</option>
                                        <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>Customer
                                        </option>
                                        <option value="event_organizer"
                                            {{ old('role') == 'event_organizer' ? 'selected' : '' }}>Event Organizer
                                        </option>
                                        <option value="inventory_staff"
                                            {{ old('role') == 'inventory_staff' ? 'selected' : '' }}>Inventory Staff
                                        </option>
                                    </select>
                                </div>

                                {{-- Address --}}
                                <div class="col-md-6 mx-auto form-group">
                                    <label for="address" style="color: rgb(73, 50, 33);">Address</label>
                                    <input type="text" id="address" name="address" placeholder="Enter address"
                                        class="form-control" value="{{ old('address') }}" required>
                                </div>

                                {{-- Phone Number --}}
                                <div class="col-md-6 mx-auto form-group">
                                    <label for="phone_number" style="color: rgb(73, 50, 33);">Phone Number</label>
                                    <input type="text" id="phone_number" name="phone_number"
                                        placeholder="Enter phone number" class="form-control" pattern="\d{10}"
                                        maxlength="10" required
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);"
                                        value="{{ old('phone_number') }}">
                                </div>

                                {{-- Email --}}
                                <div class="col-md-4 mx-auto form-group">
                                    <label for="email" style="color: rgb(73, 50, 33);">Email Address</label>
                                    <input type="email" id="email" name="email" placeholder="Enter email"
                                        class="form-control" value="{{ old('email') }}" required>
                                </div>

                                {{-- Password --}}
                                <div class="col-md-4 mx-auto form-group">
                                    <label for="password" style="color: rgb(73, 50, 33);">Password</label>
                                    <input type="password" id="password" name="password" placeholder="Enter Password"
                                        class="form-control" required>
                                </div>

                                {{-- Confirm Password --}}
                                <div class="col-md-4 mx-auto form-group">
                                    <label for="password_confirmation" style="color: rgb(73, 50, 33);">Confirm
                                        Password</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                        placeholder="Confirm Password" class="form-control" required>
                                </div>

                                {{-- Submit Button --}}
                                <div class="col-md-6 mx-auto form-group">
                                    <div class="d-grid">
                                        <button class="btn" type="submit"
                                            style="background-color:#824D74; padding: 5px 10px; border-radius: 5px; color: white;">
                                            Register
                                        </button>
                                    </div>
                                </div>

                                {{-- Link to Login --}}
                                <div class="col-md-12">
                                    <div class="position-relative text-center border-bottom my-3">
                                        <span class="position-absolute top-50 start-50 translate-middle bg-white px-3">
                                            Already have an account?
                                            <a href="{{ route('login') }}"
                                                class="text-decoration-none fw-bold text-primary">Login</a>
                                        </span>
                                    </div>
                                </div>

                                {{-- Logo --}}
                                <div class="col-md-12 text-center">
                                    <a href="#">
                                        <img src="{{ asset('images/vibe-plan-logo3.png') }}" alt="Vibe Plan Logo"
                                            width="200" height="80">
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
