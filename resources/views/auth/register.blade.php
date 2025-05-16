<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registration Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="shortcut icon" href="{{ URL::asset('assets/images/logo4.ico') }}" width="100px" height="10px">

    <style>
        .wrapper {
            display: flex;
            align-items: baseline;
            justify-content: center;
            height: 100vh;
            background-image: url('images/login-background.webp');
            background-size: cover;
            background-position: center;
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
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Montserrat&display=swap"
        rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-11 mx-auto mt-5">
                    <div class="card radius-10">
                        <div class="card-body p-4">
                            <div class="text-center mt-4">
                                <h1 style="font-family: 'Dancing Script', cursive; font-size: 48px; color: #333;">
                                    VibePlan Registration Form
                                </h1>
                                <p
                                    style="font-family: 'Montserrat', sans-serif; letter-spacing: 5px; font-size: 14px; color: #555;">
                                    EVENT ORGANIZERS & PLANNERS</p>
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
                                    <div class="alert alert-success">
                                        {{ Session::get('success') }}
                                    </div>
                                @endif
                                @if (Session::has('fail'))
                                    <div class="alert alert-danger">
                                        {{ Session::get('fail') }}
                                    </div>
                                @endif
                            
                                {{-- Full Name --}}
                                <div class="col-md-8 mx-auto form-group">
                                    <label for="name">Full Name</label>
                                    <input type="text" id="name" name="name" placeholder="Enter full name" class="form-control" value="{{ old('name') }}" required>
                                </div>
                            
                                {{-- Role --}}
                                <div class="col-md-4 mx-auto form-group">
                                    <label for="role">Who Are You?</label>
                                    <select class="form-control" name="role" id="role" required>
                                        <option value="">Select User Type</option>
                                        <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>Customer</option>
                                        <option value="event_organizer" {{ old('role') == 'event_organizer' ? 'selected' : '' }}>Event Organizer</option>
                                        <option value="inventory_staff" {{ old('role') == 'inventory_staff' ? 'selected' : '' }}>Inventory Staff</option>
                                        {{-- <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option> --}}
                                    </select>
                                </div>
                            
                                {{-- Address --}}
                                <div class="col-md-6 mx-auto form-group">
                                    <label for="address">Address</label>
                                    <input type="text" id="address" name="address" placeholder="Enter address" class="form-control" value="{{ old('address') }}" required>
                                </div>
                            
                                {{-- Phone Number --}}
                                <div class="col-md-6 mx-auto form-group">
                                    <label for="phone_number">Phone Number</label>
                                    <input type="text" id="phone_number" name="phone_number" placeholder="Enter phone number" class="form-control"
                                           pattern="\d{10}" maxlength="10" required
                                           oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);"
                                           value="{{ old('phone_number') }}">
                                </div>
                            
                                {{-- Email --}}
                                <div class="col-md-4 mx-auto form-group">
                                    <label for="email">Email Address</label>
                                    <input type="email" id="email" name="email" placeholder="Enter email" class="form-control"
                                           value="{{ old('email') }}" required>
                                </div>
                            
                                {{-- Password --}}
                                <div class="col-md-4 mx-auto form-group">
                                    <label for="password">Password</label>
                                    <input type="password" id="password" name="password" placeholder="Enter Password" class="form-control" required>
                                </div>
                            
                                {{-- Confirm Password --}}
                                <div class="col-md-4 mx-auto form-group">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" class="form-control" required>
                                </div>
                            
                                {{-- Submit Button --}}
                                <div class="col-md-6 mx-auto form-group">
                                    <div class="d-grid">
                                        <button class="btn" type="submit"
                                                style="background-color:#de5ccf; padding: 5px 10px; border-radius: 5px; color: white;">
                                            Register
                                        </button>
                                    </div>
                                </div>
                            
                                {{-- Link to Login --}}
                                <div class="col-md-12">
                                    <div class="position-relative text-center border-bottom my-3">
                                        <span class="position-absolute top-50 start-50 translate-middle bg-white px-3">
                                            Already have an account?
                                            <a href="{{ route('login') }}" class="text-decoration-none fw-bold text-primary">Login</a>
                                        </span>
                                    </div>
                                </div>
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>
