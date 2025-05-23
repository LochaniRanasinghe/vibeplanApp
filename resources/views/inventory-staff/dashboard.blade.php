@extends('layouts.inventory-staff.master')

@section('css')
    <style>
        .dashboard-card {
            background: linear-gradient(135deg, #f6f8fc, #e1e6e6);
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            padding: 20px;
            color: #2c3e50;
        }
        .dashboard-header {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
            text-align: center;
        }
        .stat-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
            padding: 20px;
            text-align: center;
        }
        .stat-icon {
            font-size: 30px;
            color: #20c997;
            margin-bottom: 10px;
        }
        .graph-box {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
        }
    </style>
@endsection

@section('title', 'VibePlan - Inventory Supplier Dashboard')

@section('parent_heading', 'Inventory Supplier Dashboard')
@section('parent_icon', 'mdi-truck')
@section('child_heading', 'Your Supply Performance')

@section('content')
    <div class="dashboard-card">
        <div class="dashboard-header">Welcome to Your Inventory Dashboard</div>
        <p class="text-center">Track your inventory performance, stock trends, and order statistics in one place.</p>

        <div class="row my-4">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon"><i class="mdi mdi-package-variant"></i></div>
                    <h5>Items Supplied</h5>
                    <p>1,200</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon"><i class="mdi mdi-truck-delivery"></i></div>
                    <h5>Pending Orders</h5>
                    <p>87</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon"><i class="mdi mdi-chart-bar"></i></div>
                    <h5>Monthly Revenue</h5>
                    <p>LKR 540,000</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon"><i class="mdi mdi-cash-refund"></i></div>
                    <h5>Returns</h5>
                    <p>12</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="graph-box">
                    <h5>Inventory Trends</h5>
                    <canvas id="inventoryChart" height="150"></canvas>
                </div>
            </div>
            <div class="col-md-4">
                <div class="graph-box">
                    <h5>Top-Selling Items</h5>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">Chairs <span class="badge bg-success">320</span></li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">Tables <span class="badge bg-success">290</span></li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">Lights <span class="badge bg-success">260</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('inventoryChart').getContext('2d');
        const inventoryChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Items Supplied',
                    data: [120, 190, 300, 500, 200, 300],
                    backgroundColor: 'rgba(32, 201, 151, 0.2)',
                    borderColor: '#20c997',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
