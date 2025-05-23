@extends('layouts.admin.master')

@section('css')
    <style>
        .dashboard-container {
            background: linear-gradient(135deg, #faf9fb, #f4f9ff);
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
        }
        .stat-card {
            background-color: #ffffff;
            border-left: 5px solid #693382;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
            text-align: center;
            margin-bottom: 20px;
        }
        .stat-card i {
            font-size: 30px;
            color: #693382;
            margin-bottom: 10px;
        }
        .graph-box {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(143, 50, 174, 0.05);
        }
        .admin-section-title {
            font-size: 18px;
            font-weight: 600;
            color: #c755f1;
            margin-bottom: 10px;
        }
    </style>
    <link href="https://cdn.materialdesignicons.com/7.2.96/css/materialdesignicons.min.css" rel="stylesheet">
@endsection

@section('title', 'VibePlan - Admin Dashboard')

@section('parent_heading', 'Admin Dashboard')
@section('parent_icon', 'mdi-shield-account')
@section('child_heading', 'System Overview')

@section('content')
    <div class="dashboard-container">
        <h4 class="mb-4 text-center">Admin Control Panel</h4>
        <p class="text-muted text-center">Manage customers, event organizers, inventory staff and monitor system metrics.</p>

        <div class="row">
            <div class="col-md-3">
                <div class="stat-card">
                    <i class="mdi mdi-account-multiple-outline"></i>
                    <h5>Total Customers</h5>
                    <h3>1,540</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <i class="mdi mdi-calendar-account"></i>
                    <h5>Event Organizers</h5>
                    <h3>212</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <i class="mdi mdi-warehouse"></i>
                    <h5>Inventory Staff</h5>
                    <h3>45</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <i class="mdi mdi-calendar-star"></i>
                    <h5>Active Events</h5>
                    <h3>98</h3>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-7">
                <div class="graph-box">
                    <h5 class="admin-section-title">User Registrations Over Time</h5>
                    <canvas id="adminLineChart" height="120"></canvas>
                </div>
            </div>
            <div class="col-md-5">
                <div class="graph-box">
                    <h5 class="admin-section-title">Revenue by Category</h5>
                    <canvas id="adminBarChart" height="120"></canvas>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-4">
                <div class="stat-card">
                    <i class="mdi mdi-lifebuoy"></i>
                    <h5>Support Tickets</h5>
                    <h3>32 Open</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <i class="mdi mdi-account-check"></i>
                    <h5>Pending Approvals</h5>
                    <h3>14</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <i class="mdi mdi-cash-multiple"></i>
                    <h5>Revenue This Month</h5>
                    <h3>LKR 1.2M</h3>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('adminLineChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'New Users',
                    data: [200, 300, 500, 450, 600, 700],
                    borderColor: '#9b30ff',
                    backgroundColor: 'rgba(155, 48, 255, 0.15)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 2
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

        const barCtx = document.getElementById('adminBarChart').getContext('2d');
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: ['Weddings', 'Corporate', 'Birthdays', 'Others'],
                datasets: [{
                    label: 'Revenue (LKR)',
                    data: [300000, 250000, 200000, 150000],
                    backgroundColor: ['#693382', '#c26be8', '#d998f4', '#f2d9fa'],
                    borderColor: '#693382',
                    borderWidth: 1
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