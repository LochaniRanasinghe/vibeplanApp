<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>VibePlan - @yield('title')</title>
    <link rel="shortcut icon" href="{{ URL::asset('images/vibe-plan-logo.ico') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Montserrat&display=swap"
        rel="stylesheet">

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Material Design Icons --}}
    <link href="https://cdn.materialdesignicons.com/7.2.96/css/materialdesignicons.min.css" rel="stylesheet">

    {{-- DataTables CSS --}}
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">

    {{-- Select2 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    {{-- Global Styles --}}
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #f7f8fc;
        }

        a {
            text-decoration: none;
            color: inherit;
        }
    </style>

    @yield('css')
</head>

<body>

    {{-- Navbar --}}
    @include('layouts.website.navbar')

    <main style="position: relative; min-height: 80vh; padding: 20px; overflow: hidden;">
        <!-- Blurred background image layer -->
        <div
            style="
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background-image: url('{{ asset('images/background-img-4.jpg') }}');
            background-size: repeat;
            background-position: center;
        ">
        </div>

        <!-- Content layer with transparency -->
        <div
            style="
            position: relative;
            z-index: 1;
            background-color: rgba(208, 194, 208, 0.436);
            padding: 30px;
            border-radius: 15px;
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            margin: auto;
            width: 90%;
        ">
            @yield('content')
        </div>
    </main>


    {{-- Footer --}}
    @include('layouts.website.footer')

    {{-- Scripts (placed at the end for faster page load) --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    @yield('scripts')

</body>

</html>
