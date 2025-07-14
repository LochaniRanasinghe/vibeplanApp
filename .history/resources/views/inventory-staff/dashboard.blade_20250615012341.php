@extends('layouts.inventory-staff.master')

@section('css')
    <style>
    </style>
@endsection

@section('title', 'VibePlan-Inventory Supplier Dashboard')

@section('parent_heading', 'Inventory Supplier Dashboard')
@section('parent_icon', 'mdi-account-multiple-outline')
@section('child_heading', 'Inventory Supplier Dashboard')

@section('content')
    <div class="card" style="border-radius: 15px;">
        <div class="card-body">
            <button id="download-report-btn" class="btn btn-primary mb-3">Download Report</button>

            <div class="container-fluid mt-3">
                <div class="row">
                    <div class="col-md-12 card mb-4">
                        <div class="card-header">Items Sold by Name</div>
                        <div class="card-body">
                            <canvas id="itemsSoldChart" height="100"></canvas>
                        </div>
                    </div>

                    <div class="col-md-12 card mb-4">
                        <div class="card-header">Monthly Revenue</div>
                        <div class="card-body">
                            <canvas id="monthlyRevenueChart" height="100"></canvas>
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
            const itemsData = {!! json_encode($itemsSold) !!};
            const monthlyData = {!! json_encode($monthlyRevenue) !!};

            const labels = itemsData.map(i => i.item_name);
            const revenue = itemsData.map(i => i.revenue);

            const itemsSoldChart = new Chart(document.getElementById('itemsSoldChart'), {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Total Revenue (LKR)',
                        data: revenue,
                        backgroundColor: 'rgba(255, 159, 64, 0.6)',
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                afterLabel: function(ctx) {
                                    const idx = ctx.dataIndex;
                                    const qty = itemsData[idx].quantity;
                                    const avail = itemsData[idx].available;
                                    return [
                                        `Units Sold: ${qty}`,
                                        `Available: ${avail}`
                                    ];
                                }
                            }
                        }
                    }
                }
            });

            const monthlyRevenueChart = new Chart(document.getElementById('monthlyRevenueChart'), {
                type: 'line',
                data: {
                    labels: Object.keys(monthlyData),
                    datasets: [{
                        label: 'Monthly Revenue (LKR)',
                        data: Object.values(monthlyData),
                        borderColor: 'rgba(54, 162, 235, 1)',
                        fill: false,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true
                }
            });

            document.getElementById('download-report-btn').addEventListener('click', function() {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = "{{ route('inventory_staff.dashboard.download-report') }}";
                form.style.display = 'none';

                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = '{{ csrf_token() }}';
                form.appendChild(csrf);

                const chart1 = document.createElement('input');
                chart1.type = 'hidden';
                chart1.name = 'chart1';
                chart1.value = document.getElementById('itemsSoldChart').toDataURL('image/png');
                form.appendChild(chart1);

                const chart2 = document.createElement('input');
                chart2.type = 'hidden';
                chart2.name = 'chart2';
                chart2.value = document.getElementById('monthlyRevenueChart').toDataURL('image/png');
                form.appendChild(chart2);

                document.body.appendChild(form);
                form.submit();
            });
        });
    </script>
@endsection
