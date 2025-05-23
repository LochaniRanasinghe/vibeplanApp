<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="{{ URL::asset('images/vibe-plan-logo.ico') }}">
    <title>@yield('title', 'VibePlan')</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Icons CSS -->
    <link href="https://cdn.materialdesignicons.com/7.2.96/css/materialdesignicons.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- FilePond CSS -->
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <style>
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
    </style>
    @yield('css')
</head>

<body style="margin: 0;">

    <div class="d-flex" style="height: 100vh; overflow: hidden;">

        {{-- Sidebar fixed on the left, full height --}}
        <div
            style="width: 280px; height: 100vh; background-color: #fff; position: fixed; left: 0; top: 0; overflow-y: auto;">
            @include('layouts.inventory-staff.sidebar')
        </div>

        {{-- Right section: navbar at top, content below --}}
        <div style="margin-left: 280px; flex-grow: 1; display: flex; flex-direction: column; height: 100vh;">

            {{-- Navbar (top of content area) --}}
            <div style="flex-shrink: 0; box-shadow: -4px 0 8px -2px rgba(0,0,0,0.2); z-index: 10;">
                @include('layouts.inventory-staff.navbar')
            </div>


            {{-- Content below navbar --}}
            {{-- <div style="flex-grow: 1; overflow-y: auto; padding: 20px; background-color: #e5e7e7;">
                <div style="flex-grow: 1; overflow-y: auto; padding: 20px; background-color: #fff; border-radius: 5px;">

                    @include('layouts.inventory-staff.breadcrumb')
                    
                    @yield('content')

                </div>
            </div> --}}
            <div
                style="
                    flex-grow: 1;
                    overflow-y: auto;
                    padding: 20px;
                    background-image: url('{{ asset('images/background-img-6.jpg') }}');
                    background-size: repeat;
                ">
                <div
                    style="
                        flex-grow: 1;
                        overflow-y: auto;
                        padding: 20px;
                        background-color: rgba(255, 255, 255, 0.3); /* lighter for better blur */
                        border-radius: 12px;
                        backdrop-filter: blur(10px);
                        -webkit-backdrop-filter: blur(10px);
                        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
                        border: 1px solid rgba(255, 255, 255, 0.3);
                    ">
                    @include('layouts.inventory-staff.breadcrumb')

                    @yield('content')
                </div>
            </div>
        </div>

    </div>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
    @yield('scripts')

</body>




</html>
