@extends('layouts.admin.master')

@section('title', 'VibePlan-Dashboard')

@section('parent_heading', 'Dashboard')
@section('parent_icon', 'mdi-account-multiple-outline')
@section('child_heading', 'Dashboard')

@section('content')
    <div class="card" style="border-radius: 15px;">
        <div class="card-body">
            <div class="container-fluid mt-3">
                <form id="reportForm" method="POST" action="{{ route(name: 'admin.dashboard.report') }}">
                    @csrf
                    <input type="hidden" name="salesChart" id="salesChartInput">
                    <input type="hidden" name="salesByEventChart" id="salesByEventChartInput">
                    <input type="hidden" name="monthlyRevenueChart" id="monthlyRevenueChartInput">
                    <input type="hidden" name="eventTypeRevenueChart" id="eventTypeRevenueChartInput">
                    <button type="submit" class="btn btn-primary mb-3">📄 Download Report</button>
                </form>

                <div class="row">
                    <div class="col-md-6 card mb-4">
                        <div class="card-header">Inventory Sales (Bar Chart)</div>
                        <div class="card-body">
                            <canvas id="salesChart" height="100"></canvas>
                        </div>
                    </div>

                    <div class="col-md-6 card mb-4">
                        <div class="card-header">Inventory Sales by Event</div>
                        <div class="card-body">
                            <canvas id="salesByEventChart" height="100"></canvas>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 card mb-4">
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
                    labels: {!! json_encode(
                        $salesPerItem->map(function ($item) {
                            return $item->item_name . ' (' . ($item->staff->name ?? 'Unknown') . ')';
                        }),
                    ) !!},
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


            document.getElementById('reportForm').addEventListener('submit', function(e) {
                // Prevent default for now
                e.preventDefault();

                // Convert each canvas to base64
                document.getElementById('salesChartInput').value = document.getElementById('salesChart')
                    .toDataURL();
                document.getElementById('salesByEventChartInput').value = document.getElementById(
                    'salesByEventChart').toDataURL();
                document.getElementById('monthlyRevenueChartInput').value = document.getElementById(
                    'monthlyRevenueChart').toDataURL();
                document.getElementById('eventTypeRevenueChartInput').value = document.getElementById(
                    'eventTypeRevenueChart').toDataURL();

                // Submit now that inputs are filled
                e.target.submit();
            });

        });
    </script>
@endsection
