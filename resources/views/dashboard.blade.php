@extends('layouts.admin.master')

@section('title', 'UI')

@section('content')
    <div class="row text-center">
        <div class="col-md-4">
            <i class="mdi mdi-calendar text-primary" style="font-size: 40px;"></i>
            <h5>Events</h5>
        </div>
        <div class="col-md-4">
            <i class="mdi mdi-chair-school text-success" style="font-size: 40px;"></i>
            <h5>Inventory</h5>
        </div>
        <div class="col-md-4">
            <i class="mdi mdi-account-multiple text-info" style="font-size: 40px;"></i>
            <h5>Users</h5>
        </div>
    </div>
    <div class="row">
        <h1>Ui UI UI</h1>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#events-table').DataTable();

            $('.select2').select2();

        });
    </script>
@endsection
