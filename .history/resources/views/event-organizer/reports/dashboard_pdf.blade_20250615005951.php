<!DOCTYPE html>
<html>

<head>
    <title>Event Organizer Dashboard Report</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            color: #333;
            padding: 20px;
        }

        h1,
        h3 {
            color: #2d2d2d;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 6px;
            text-align: left;
        }

        th {
            background: #f2f2f2;
        }
    </style>
</head>

<body>
    <h1> Event Organizer Dashboard Report</h1>
    <p>Generated on: {{ now()->format('Y-m-d H:i') }}</p>

    <h3>1. Income Gained per Event</h3>
    <h3>0. Key Graphs</h3>
    @if ($chart1)
        <p><strong>1st Chart:</strong></p>
        <img src="{{ $chart1 }}" style="width: 100%; max-height: 300px;">
    @endif

    

    <table>
        <thead>
            <tr>
                <th>Event</th>
                <th>Income (LKR)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($eventIncome as $e)
                <tr>
                    <td>{{ $e['title'] }}</td>
                    <td>{{ number_format($e['income'], 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>2. Monthly Total Income</h3>
    <table>
        <thead>
            <tr>
                <th>Month</th>
                <th>Total Income (LKR)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($monthlyIncome as $month => $amount)
                <tr>
                    <td>{{ $month }}</td>
                    <td>{{ number_format($amount, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>3. Most Ordered Inventory Items</h3>
    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Staff</th>
                <th>Quantity Ordered</th>
                <th>Amount Paid (LKR)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($topItems as $item)
                <tr>
                    <td>{{ $item['item'] }}</td>
                    <td>{{ $item['staff'] }}</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>{{ number_format($item['amount'], 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
