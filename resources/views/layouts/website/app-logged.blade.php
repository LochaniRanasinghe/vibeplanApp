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

        .select2-container--default .select2-selection--single {
            height: auto;
            padding: 6px;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            background-color: #fff;
            font-size: 1rem;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 1.5;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: calc(100% - 1px);
            top: 50%;
            transform: translateY(-50%);
        }

        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 20px;
        }
    </style>

    @yield('css')
</head>

<body>

    {{-- Navbar --}}
    @include('layouts.website.navbar-logged')

    {{-- Page Content --}}
    <main style="min-height: 80vh; padding: 20px;">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('layouts.website.footer')

    {{-- Scripts (placed at the end for faster page load) --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    {{-- Custom Scripts --}}
    @yield('scripts')

</body>

</html>
