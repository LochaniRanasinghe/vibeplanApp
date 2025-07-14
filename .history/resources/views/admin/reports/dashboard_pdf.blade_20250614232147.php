<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>VibePlan | Dashboard Report</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            font-size: 12px;
            padding: 20px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        .header h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }

        .header p {
            font-size: 14px;
            color: #666;
        }

        .section {
            margin-bottom: 50px;
            page-break-inside: avoid;
        }

        .section h3 {
            font-size: 16px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
            margin-bottom: 15px;
            color: #222;
        }

        .chart {
            width: 100%;
            max-height: 400px;
            object-fit: contain;
            border: 1px solid #ccc;
            padding: 10px;
            background: #f8f8f8;
        }

        .table {
            margin-top: 15px;
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            border: 1px solid #ccc;
            padding: 5px 8px;
            text-align: left;
        }

        .table th {
            background-color: #efefef;
        }

        .footer {
            position: fixed;
            bottom: 15px;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #999;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>VibePlan Dashboard Report</h1>
        <p>Generated on {{ \Carbon\Carbon::now()->format('Y-m-d H:i') }}</p>
    </div>

    {{-- 1. Inventory Sales --}}
    <div class="section">
        <h3>1. Inventory Sales (Bar Chart)</h3>
        <img class="chart" src="{{ $charts['salesChart'] }}" alt="Inventory Sales">

        <table class="table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Added By</th>
                    <th>Units Sold</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($salesPerItem as $item)
                    <tr>
                        <td>{{ $item->item_name }}</td>
                        <td>{{ $item->staff->name ?? 'Unknown' }}</td>
                        <td>{{ $item->total_sold ?? 0 }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- 2. Inventory Sales by Event --}}
    <div class="section">
        <h3>2. Inventory Sales by Event</h3>
        <img class="chart" src="{{ $charts['salesByEventChart'] }}" alt="Sales by Event">

        <table class="table">
            <thead>
                <tr>
                    <th>Event Title</th>
                    <th>Total Items Sold</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($salesByEvent as $row)
                    <tr>
                        <td>{{ $row['event'] }}</td>
                        <td>{{ $row['quantity'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- 3. Monthly Revenue --}}
    <div class="section">
        <h3>3. Monthly Revenue by Inventory Item</h3>
        <img class="chart" src="{{ $charts['monthlyRevenueChart'] }}" alt="Monthly Revenue">

        <table class="table">
            <thead>
                <tr>
                    <th>Month</th>
                    <th>Item</th>
                    <th>Revenue (LKR)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($monthlyItemRevenue as $month => $items)
                    @foreach ($items as $data)
                        <tr>
                            <td>{{ $month }}</td>
                            <td>{{ $data['item'] }}</td>
                            <td>{{ number_format($data['revenue'], 2) }}</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- 4. Revenue by Event Type --}}
    <div class="section">
        <h3>4. Revenue by Event Type (Based on Payments)</h3>
        <img class="chart" src="{{ $charts['eventTypeRevenueChart'] }}" alt="Revenue by Event Type">

        <table class="table">
            <thead>
                <tr>
                    <th>Event Type</th>
                    <th>Total Revenue (LKR)</th>
                    <th>Events</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($eventRevenue as $type => $data)
                    <tr>
                        <td>{{ $type }}</td>
                        <td>{{ number_format($data['revenue'], 2) }}</td>
                        <td>{{ implode(', ', $data['events']->toArray()) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        &copy; {{ date('Y') }} VibePlan • Report generated by Admin
    </div>

</body>

</html>
