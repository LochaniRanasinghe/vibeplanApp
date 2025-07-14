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
            margin-bottom: 30px;
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

        h4 {
            margin-top: 10px;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>📊 VibePlan Dashboard Report</h1>
        <p>Generated on {{ \Carbon\Carbon::now()->format('Y-m-d H:i') }}</p>
    </div>

    {{-- 1. Inventory Sales --}}
    <div class="section">
        <h3>1. Inventory Sales (Bar Chart)</h3>
        <img class="chart" src="{{ $charts['salesChart'] }}" alt="Inventory Sales">
        <table>
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Added By</th>
                    <th>Units Sold</th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($tableData['salesPerItem']) && is_iterable($tableData['salesPerItem']))
                    @foreach ($tableData['salesPerItem'] as $item)
                        <tr>
                            <td>{{ $item['item_name'] }}</td>
                            <td>{{ $item['staff']['name'] ?? 'Unknown' }}</td>
                            <td>{{ $item['total_sold'] ?? 0 }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="3">No data available.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    {{-- 2. Sales by Event --}}
    <div class="section">
        <h3>2. Inventory Sales by Event</h3>
        <img class="chart" src="{{ $charts['salesByEventChart'] }}" alt="Sales by Event">
        <table>
            <thead>
                <tr>
                    <th>Event</th>
                    <th>Items Sold</th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($tableData['salesByEvent']) && is_iterable($tableData['salesByEvent']))
                    @foreach ($tableData['salesByEvent'] as $entry)
                        <tr>
                            <td>{{ $entry['event'] }}</td>
                            <td>{{ $entry['quantity'] }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="2">No data available.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    {{-- 3. Monthly Revenue --}}
    <div class="section">
        <h3>3. Monthly Revenue by Inventory Item</h3>
        <img class="chart" src="{{ $charts['monthlyRevenueChart'] }}" alt="Monthly Revenue">
        @if (!empty($tableData['monthlyItemRevenue']) && is_iterable($tableData['monthlyItemRevenue']))
            @foreach ($tableData['monthlyItemRevenue'] as $month => $items)
                <h4>{{ $month }}</h4>
                <table>
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Revenue (LKR)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (is_iterable($items))
                            @foreach ($items as $entry)
                                <tr>
                                    <td>{{ $entry['item'] }}</td>
                                    <td>{{ number_format($entry['revenue'], 2) }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="2">No data available for this month.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            @endforeach
        @else
            <p>No monthly revenue data available.</p>
        @endif
    </div>

    {{-- 4. Revenue by Event Type --}}
    <div class="section">
        <h3>4. Revenue by Event Type (Based on Payments)</h3>
        <img class="chart" src="{{ $charts['eventTypeRevenueChart'] }}" alt="Revenue by Event Type">
        <table>
            <thead>
                <tr>
                    <th>Event Type</th>
                    <th>Revenue (LKR)</th>
                    <th>Event Titles</th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($tableData['eventRevenue']) && is_iterable($tableData['eventRevenue']))
                    @foreach ($tableData['eventRevenue'] as $type => $entry)
                        <tr>
                            <td>{{ $type }}</td>
                            <td>{{ number_format($entry['revenue'], 2) }}</td>
                            <td>
                                {{ is_iterable($entry['events']) ? implode(', ', $entry['events']->toArray()) : '—' }}
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="3">No payment-based revenue data available.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <div class="footer">
        &copy; {{ date('Y') }} VibePlan • Generated by Admin
    </div>

</body>

</html>
