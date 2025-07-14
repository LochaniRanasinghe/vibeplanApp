{{-- @extends('layouts.admin.master')

@section('css')
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> --}}
    <style>

    </style>
@endsection

@section('title', 'VibePlan-Dashboard')

@section('parent_heading', 'Dashboard')
@section('parent_icon', 'mdi-account-multiple-outline')
@section('child_heading', 'Dashboard')

@section('content')
    <div class="card" style="border-radius: 15px;">
        <div class="card-body">
            <div class="container-fluid mt-3">
                <div class="row">
                    <!-- Main Content -->
                    <div class="card mb-4">
                        <div class="card-header">Inventory Sales</div>
                        <div class="card-body">
                            <canvas id="salesChart" height="100"></canvas>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        $(document).ready(function() {
            const timeChart = new Chart(document.getElementById('salesOverTimeChart'), {
                type: 'line',
                data: {
                    labels: {!! json_encode($salesOverTime->pluck('date')) !!},
                    datasets: [{
                        label: 'Total Sales',
                        data: {!! json_encode($salesOverTime->pluck('total_quantity')) !!},
                        fill: false,
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

        });
    </script>
@endsection --}}
