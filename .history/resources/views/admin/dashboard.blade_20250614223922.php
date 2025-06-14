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

                <div class="card mb-4">
                    <div class="card-header">Monthly Revenue by Inventory Item</div>
                    <div class="card-body">
                        <canvas id="monthlyRevenueChart" height="100"></canvas>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">Revenue by Event Type (Based on Payments)</div>
                    <div class="card-body">
                        <canvas id="eventTypeRevenueChart" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
                        y: {
                            beginAtZero: true
                        }
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
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            const salesByEventChart = new Chart(document.getElementById('salesByEventChart'), {
                type: 'bar',
                data: {
                    labels: {!! json_encode($salesByEvent->pluck('event')) !!},
                    datasets: [{
                        label: 'Items Sold',
                        data: {!! json_encode($salesByEvent->pluck('quantity')) !!},
                        backgroundColor: 'rgba(153, 102, 255, 0.6)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1
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

            const monthlyRevenueData = @json($monthlyItemRevenue);

            const months = Object.keys(monthlyRevenueData);
            const allItems = [...new Set(
                months.flatMap(month => monthlyRevenueData[month].map(i => i.item))
            )];

            const datasets = allItems.map(item => ({
                label: item,
                data: months.map(month => {
                    const found = monthlyRevenueData[month].find(i => i.item === item);
                    return found ? found.revenue : 0;
                }),
                borderWidth: 1
            }));

            new Chart(document.getElementById('monthlyRevenueChart'), {
                type: 'bar',
                data: {
                    labels: months,
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Monthly Revenue by Inventory Item'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        },
                        x: {
                            stacked: true
                        },
                        y: {
                            stacked: true
                        }
                    }
                }
            });

            const eventRevenue = @json($eventRevenue);

            const eventLabels = Object.keys(eventRevenue);
            const revenueData = eventLabels.map(type => eventRevenue[type].revenue);
            const eventTitles = eventLabels.map(type =>
                eventRevenue[type].events.join(', ')
            );

            new Chart(document.getElementById('eventTypeRevenueChart'), {
                type: 'bar',
                data: {
                    labels: eventLabels,
                    datasets: [{
                        label: 'Revenue (LKR)',
                        data: revenueData,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    indexAxis: 'y',
                    plugins: {
                        tooltip: {
                            callbacks: {
                                afterLabel: function(context) {
                                    return 'Events: ' + eventTitles[context.dataIndex];
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
@endsection
