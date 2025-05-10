@extends('layouts.admin.master')

@section('title', 'VibePlan-Dashboard')

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
        <table id="events-table" class="display">
            <thead>
                <tr>
                    <th>Event</th>
                    <th>Type</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Birthday Bash</td>
                    <td>Birthday</td>
                    <td>2025-05-06</td>
                </tr>
                <tr>
                    <td>Wedding Ceremony</td>
                    <td>Wedding</td>
                    <td>2025-06-01</td>
                </tr>
            </tbody>
        </table>

        <h1>Admin Dashboard</h1>

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
