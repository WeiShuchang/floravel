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
        /* Additional styles */
        .header-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .header-left
        {
     
            text-align: left;
        }
        .header-right {
            text-align: right;
        }
        .top-center {
            text-align: center;
            margin-top: 20px; /* Adjust as needed */
            margin-bottom: 10px; /* Adjust as needed */
            font-weight: bold; /* Adjust as needed */
            font-size: 18px; /* Adjust as needed */
        }
    </style>
</head>
<body>

<div class="top-center" style="margin-top:30px">
    Floravel Inc.<br>
    123 Main Street, Florafield City<br>
    2601, La Trinidad, Benguet<br>
    {{$currentDate}}
</div>


    <h1 >Orders Report</h1>
    <table>
        <thead>
            <tr>
                <th>User</th>
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
                <td>{{ $order->user->name }}</td>
                <td>{{ $order->flower->name }}</td>
                <td>{{ $order->shipping_address }}</td>
                <td>php. {{ $order->flower->price }}</td>
                <td>{{ (int) $order->quantity }}</td>
                <td>php. {{ $order->total_amount }}</td>
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
        <tfoot>
                <tr class="total-row">
                    <td colspan="5" style="text-align:right;">Total Price:</td>
                    <td colspan="2" style="font-weight:bold;">
                    php.@php
                            $totalPrice = 0;
                            foreach ($orders as $order) {
                                $totalPrice += $order->total_amount;
                            }
                            echo $totalPrice;
                        @endphp
                    </td>
                </tr>
            </tfoot>
    </table>
</body>
</html>
