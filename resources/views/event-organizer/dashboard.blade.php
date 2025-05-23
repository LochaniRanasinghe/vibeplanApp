@extends('layouts.event-organizer.master')

@section('css')
    <style>
        .dashboard-container {
            background: linear-gradient(135deg, #f9fafb, #e4e8ea);
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }
        .stat-card {
            background-color: #ffffff;
            border-left: 6px solid #007bff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.03);
            margin-bottom: 20px;
            text-align: center;
        }
        .graph-box {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
        }
    </style>
@endsection

@section('title', 'VibePlan - Event Organizer Dashboard')

@section('parent_heading', 'Event Organizer Dashboard')
@section('parent_icon', 'mdi-calendar-multiselect')
@section('child_heading', 'Event Overview & Analytics')

@section('content')
    <div class="dashboard-container">
        <h4 class="mb-4 text-center">Welcome to Your Event Organizer Dashboard</h4>
        <p class="text-muted text-center">Monitor your event performance, bookings, and audience engagement here.</p>

        <div class="row">
            <div class="col-md-3">
                <div class="stat-card">
                    <h5>Events Created</h5>
                    <h3>54</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <h5>Bookings</h5>
                    <h3>1,230</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <h5>Upcoming Events</h5>
                    <h3>12</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <h5>Revenue</h5>
                    <h3>LKR 980K</h3>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-8">
                <div class="graph-box">
                    <h5>Monthly Bookings Overview</h5>
                    <canvas id="bookingsChart"></canvas>
                </div>
            </div>
            <div class="col-md-4">
                <div class="graph-box">
                    <h5>Event Categories</h5>
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const bookingsCtx = document.getElementById('bookingsChart').getContext('2d');
        new Chart(bookingsCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Bookings',
                    data: [120, 190, 300, 500, 200, 350],
                    backgroundColor: 'rgba(0, 123, 255, 0.2)',
                    borderColor: '#007bff',
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

        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        new Chart(categoryCtx, {
            type: 'doughnut',
            data: {
                labels: ['Weddings', 'Corporate', 'Birthday', 'Others'],
                datasets: [{
                    label: 'Events',
                    data: [25, 20, 30, 25],
                    backgroundColor: ['#007bff', '#17a2b8', '#6610f2', '#6c757d'],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
@endsection