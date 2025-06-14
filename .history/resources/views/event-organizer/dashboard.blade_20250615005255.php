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
                <a href="{{ route('event_organizer.dashboard.download-report') }}" class="btn btn-sm btn-primary">
                    📥 Download Report
                </a>
                
                <canvas id="incomePerEventChart" height="100"></canvas>
                <canvas id="monthlyIncomeChart" height="100"></canvas>
                <canvas id="topItemsChart" height="100"></canvas>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(document).ready(function() {
            const incomePerEventChart = new Chart(document.getElementById('incomePerEventChart'), {
                type: 'bar',
                data: {
                    labels: {!! json_encode($incomePerEvent->keys()) !!},
                    datasets: [{
                        label: 'Income per Event (LKR)',
                        data: {!! json_encode($incomePerEvent->values()) !!},
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    }]
                },
                options: {
                    responsive: true
                }
            });

            const monthlyIncomeChart = new Chart(document.getElementById('monthlyIncomeChart'), {
                type: 'line',
                data: {
                    labels: {!! json_encode($monthlyIncome->keys()) !!},
                    datasets: [{
                        label: 'Monthly Income (LKR)',
                        data: {!! json_encode($monthlyIncome->values()) !!},
                        borderColor: 'rgba(255, 99, 132, 1)',
                        fill: false,
                    }]
                },
                options: {
                    responsive: true
                }
            });

            const topItems = {!! json_encode($mostOrderedItems) !!};

            const topItemLabels = topItems.map(i => i.item_name);
            const topItemData = topItems.map(i => i.quantity);

            const topItemsChart = new Chart(document.getElementById('topItemsChart'), {
                type: 'bar',
                data: {
                    labels: topItemLabels,
                    datasets: [{
                        label: 'Most Ordered Items (Units)',
                        data: topItemData,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                afterLabel: function(context) {
                                    const index = context.dataIndex;
                                    const staff = topItems[index].staff;
                                    const paid = topItems[index].total_paid.toLocaleString('en-LK', {
                                        style: 'currency',
                                        currency: 'LKR'
                                    });
                                    return [
                                        'Staff: ' + staff,
                                        'Total Paid: ' + paid
                                    ];
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

        });
    </script>
@endsection
