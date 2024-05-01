<!DOCTYPE html>
<html>
<head>
    <title>My Orders</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
            margin-top: 20px;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #dddddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .pending {
            color: orange;
        }
        .delivered {
            color: green;
        }
        .shipped {
            color: blue;
        }
    </style>
</head>
<body>
    <h1>My Orders</h1>
    <table>
        <thead>
            <tr>
                <th>Flower</th>
                <th>Shipping Address</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total Amount</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->flower->name }}</td>
                <td>{{ $order->shipping_address }}</td>
                <td>php {{ $order->flower->price }}</td>
                <td>{{ (int) $order->quantity }}</td>
                <td>php {{ $order->total_amount }}</td>
                <td class="@if($order->pending) pending @elseif($order->is_delivered) delivered @else shipped @endif">
                    @if($order->pending)
                        Pending
                    @elseif($order->is_delivered)
                        Delivered
                    @else
                        Shipped
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
