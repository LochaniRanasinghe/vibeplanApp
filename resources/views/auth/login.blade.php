@extends('layouts.website.app')

@section('title', 'Login')

@section('css')
    <style>
        .wrapper {
            display: flex;
            align-items: baseline;
            justify-content: center;
            height: 100vh;
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
                <div class="col-md-6 mx-auto mt-5">
                    <div class="card radius-10">
                        <div class="card-body p-4">
                            <div class="text-center mt-4">
                                <h1 style="font-family: 'Dancing Script', cursive; font-size: 48px; color: rgb(73, 50, 33);">
                                    VibePlan Login
                                </h1>
                                <p style="font-family: 'Montserrat', sans-serif; letter-spacing: 5px; font-size: 14px; color: #6b4324;">
                                    EVENT ORGANIZERS & PLANNERS
                                </p>
                            </div>
                            <hr>
                            <form class="form-body row g-3" action="/loginuser" method="POST">
                                @csrf

                                {{-- Flash and Validation Messages --}}
                                @if ($errors->any())
                                    @foreach ($errors->all() as $error)
                                        <div class="alert alert-danger">{{ $error }}</div>
                                    @endforeach
                                @endif

                                @if (Session::has('success'))
                                    <div class="alert alert-success">{{ Session::get('success') }}</div>
                                @endif

                                @if (Session::has('fail'))
                                    <div class="alert alert-danger">{{ Session::get('fail') }}</div>
                                @endif

                                {{-- Email --}}
                                <div class="col-md-10 mx-auto form-group">
                                    <label for="email" style="color: rgb(73, 50, 33);">Email</label>
                                    <input type="text" id="email" name="email" placeholder="Enter email"
                                        class="form-control" value="{{ old('email') }}">
                                    <span class="text-danger">@error('email') {{ $message }} @enderror</span>
                                </div>

                                {{-- Password --}}
                                <div class="col-md-10 mx-auto form-group">
                                    <label for="password" style="color: rgb(73, 50, 33);">Password</label>
                                    <div class="input-group">
                                        <input type="password" id="password" name="password" placeholder="Enter Password"
                                            class="form-control" value="{{ old('password') }}">
                                        <div class="input-group-append" id="togglePassword">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
                                                <path
                                                    d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7" />
                                            </svg>
                                        </div>
                                    </div>
                                    <span class="text-danger">@error('password') {{ $message }} @enderror</span>
                                </div>

                                {{-- Submit --}}
                                <div class="col-md-10 mx-auto form-group">
                                    <div class="d-grid">
                                        <button class="btn" type="submit"
                                            style="background-color:#824D74; padding: 5px 10px; border-radius: 5px; color: white;">
                                            Sign In
                                        </button>
                                    </div>
                                </div>

                                {{-- Register prompt --}}
                                <div class="col-md-12">
                                    <div class="position-relative text-center border-bottom my-3">
                                        <span class="position-absolute top-50 start-50 translate-middle bg-white px-3">
                                            Don't have an account?
                                            <a href="{{ route('register') }}"
                                                class="text-decoration-none fw-bold text-primary">Register</a>
                                        </span>
                                    </div>
                                </div>

                                {{-- Logo --}}
                                <div class="col-md-12 text-center">
                                    <a href="#">
                                        <img src="{{ asset('images/vibe-plan-logo.png') }}" alt="Vibe Plan Logo"
                                            width="280" height="100">
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
