<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
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
                <div class="col-md-6 mx-auto mt-5">
                    <div class="card radius-10">
                        <div class="card-body p-4">
                            <div class="text-center mt-4">
                                <h1 style="font-family: 'Dancing Script', cursive; font-size: 48px; color: #333;">
                                    VibePlan Login
                                </h1>
                                <p
                                    style="font-family: 'Montserrat', sans-serif; letter-spacing: 5px; font-size: 14px; color: #555;">
                                    EVENT ORGANIZERS & PLANNERS</p>
                            </div>
                            <hr>
                            <form class="form-body row g-3" action="/loginuser" method="POST">
                                @csrf
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <div class="alert alert-danger">{{ $error }}</div>
                                            @endforeach
                                        </ul>
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
                                <div class="form-group">
                                    <div class="col-md-10 mx-auto form-group">
                                        <label for="email">Email</label>
                                        <input type="text" id="email" name="email" placeholder="Enter email"
                                            class="form-control" value="{{ old('email') }}">
                                        <span class="text-danger">
                                            @error('email')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    <br>
                                    <div class="col-md-10 mx-auto form-group">
                                        <label for="password">Password</label>
                                        <div class="input-group">
                                            <input type="password" id="password" name="password"
                                                placeholder="Enter Password" class="form-control"
                                                value="{{ old('password') }}">
                                            <div class="input-group-append" id="togglePassword">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
                                                    <path
                                                        d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7" />
                                                </svg>
                                            </div>
                                        </div>
                                        <span class="text-danger">
                                            @error('password')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    <br>
                                    <div class="col-md-10 mx-auto form-group">
                                        <div class="d-grid">
                                            <button class="btn" type="submit"
                                                style="background-color:#e493db; padding: 5px 10px; border-radius: 5px; color: white; text-decoration: none;">Sign
                                                In</button>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="position-relative text-center border-bottom my-3">
                                            <span
                                                class="position-absolute top-50 start-50 translate-middle bg-white px-3">
                                                Login to
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-lg-12 text-center">
                                        <div style="display: flex; justify-content: center; align-items: center;">
                                            <a href="#">
                                                <img src="{{ asset('images/vibe-plan-logo.png') }}" alt="Vibe Plan Logo"
                                                    width="280" height="100">
                                            </a>
                                        </div>
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
    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            var passwordInput = document.getElementById('password');
            var type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
        });
    </script>
</body>

</html>
