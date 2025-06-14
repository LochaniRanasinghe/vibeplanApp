@extends('layouts.admin.master')

@section('title', 'VibePlan-Dashboard')

@section('parent_heading', 'Dashboard')
@section('parent_icon', 'mdi-account-multiple-outline')
@section('child_heading', 'Dashboard')

@section('content')
    <div class="card" style="border-radius: 15px;">
        <div class="card-body">
            <div class="container-fluid mt-3">

                <div class="card mb-4">
                    <div class="card-header">Inventory Sales (Bar Chart)</div>
                    <div class="card-body">
                        <canvas id="salesChart" height="100"></canvas>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">Sales Over Time (Line Chart)</div>
                    <div class="card-body">
                        <canvas id="salesOverTimeChart" height="100"></canvas>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">Inventory Sales by Event</div>
                    <div class="card-body">
                        <canvas id="salesByEventChart" height="100"></canvas>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Bar Chart for Inventory Sales
            const salesChart = new Chart(document.getElementById('salesChart'), {
                type: 'bar',
                data: {
                    labels: {!! json_encode($salesPerItem->pluck('item_name')) !!},
                    datasets: [{
                        label: 'Units Sold',
                        data: {!! json_encode($salesPerItem->pluck('total_sold')) !!},
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });

            // Line Chart for Sales Over Time
            const timeChart = new Chart(document.getElementById('salesOverTimeChart'), {
                type: 'line',
                data: {
                    labels: {!! json_encode($salesOverTime->pluck('date')) !!},
                    datasets: [{
                        label: 'Total Sales Over Time',
                        data: {!! json_encode($salesOverTime->pluck('total_quantity')) !!},
                        borderColor: 'rgba(75, 192, 192, 1)',
                        fill: false,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        });
    </script>
@endsection
