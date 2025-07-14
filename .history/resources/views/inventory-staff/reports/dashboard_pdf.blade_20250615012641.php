<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Inventory Staff Report</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            font-size: 12px;
            padding: 20px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 22px;
            margin-bottom: 5px;
        }

        .header p {
            font-size: 13px;
            color: #666;
        }

        .section {
            margin-bottom: 40px;
            page-break-inside: avoid;
        }

        .section h3 {
            font-size: 16px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
            margin-bottom: 10px;
            color: #222;
        }

        .chart {
            width: 100%;
            max-height: 400px;
            object-fit: contain;
            border: 1px solid #ccc;
            padding: 10px;
            background: #f8f8f8;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }

        table,
        th,
        td {
            border: 1px solid #ccc;
        }

        th {
            background-color: #f2f2f2;
        }

        th,
        td {
            padding: 6px 8px;
            text-align: left;
        }

        .footer {
            text-align: center;
            font-size: 10px;
            color: #999;
            margin-top: 40px;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>Inventory Staff Report</h1>
        <p>Generated on {{ \Carbon\Carbon::now()->format('Y-m-d H:i') }}</p>
    </div>

    {{-- 1. Items Summary --}}
    <div class="section">
        <h3>1. Items Summary (Revenue & Stock)</h3>
        <img class="chart" src="{{ $chart1 }}" alt="Items Summary Chart">

        @if ($itemsSummary && count($itemsSummary) > 0)
            <table>
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Quantity Sold</th>
                        <th>Revenue (LKR)</th>
                        <th>Quantity Available</th>
                        <th>Events Ordered In</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($itemsSummary as $item)
                        <tr>
                            <td>{{ $item['item_name'] }}</td>
                            <td>{{ $item['quantity_sold'] }}</td>
                            <td>{{ number_format($item['revenue'], 2) }}</td>
                            <td>{{ $item['quantity_available'] }}</td>
                            <td>{{ implode(', ', $item['events']->toArray()) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No item data available.</p>
        @endif
    </div>

    {{-- 2. Monthly Revenue --}}
    <div class="section">
        <h3>2. Monthly Revenue</h3>
        <img class="chart" src="{{ $chart2 }}" alt="Monthly Revenue Chart">

        @if ($monthlyRevenue && count($monthlyRevenue) > 0)
            <table>
                <thead>
                    <tr>
                        <th>Month</th>
                        <th>Revenue (LKR)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($monthlyRevenue as $month => $revenue)
                        <tr>
                            <td>{{ $month }}</td>
                            <td>{{ number_format($revenue, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No monthly revenue data available.</p>
        @endif
    </div>

    <div class="footer">
        &copy; {{ date('Y') }} VibePlan • Inventory Staff Portal
    </div>

</body>

</html>
