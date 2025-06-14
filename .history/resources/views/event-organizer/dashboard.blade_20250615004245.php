@extends('layouts.event-organizer.master')

@section('css')
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> --}}
    <style>

    </style>
@endsection

@section('title', 'VibePlan-Event Organizer Dashboard')

@section('parent_heading', 'Event Organizer Dashboard')
@section('parent_icon', 'mdi-account-multiple-outline')
@section('child_heading', 'Event Organizer Dashboard')

@section('content')
    <div class="card" style="border-radius: 15px;">
        <div class="card-body">
            <div class="container-fluid mt-3">
                <canvas id="incomePerEventChart" height="100"></canvas>
                <canvas id="monthlyIncomeChart" height="100"></canvas>
                <canvas id="topItemsChart" height="100"></canvas>

            </div>
        </div>
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
