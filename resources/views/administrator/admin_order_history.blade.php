@extends('administrator.base')

@section('page_title', 'My Orders')

@section('content')

<div class="center-div" style=";">
    <h1 class="container">Order History</h1>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            @if(session('success'))
            <div class="alert alert-success" role="alert" id="alert-message">
                {{ session('success') }}
            </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger" id="alert-message">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered ">
                    <thead>
                        <tr>
                            <th>Customer Name</th>
                            <th>Flower</th>
                            <th>Shipping Address</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total Amount</th>
                            <th>Reason For Cancel</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->user->name }}</td>
                            <td>{{ $order->flower->name }}</td>
                            <td>{{ $order->shipping_address }}</td>
                            <td>₱{{ $order->flower->price }}</td>
                            <td>x{{ $order->quantity }}</td>
                            <td>₱{{ $order->total_amount }}</td>
                            @if($order->cancel_reason)
                            <td>{{ $order->cancel_reason }}</td>
                            @else
                            <td></td>
                            @endif
                            <td style="color: 
                                @if($order->is_cancelled)
                                    red
                                @elseif($order->is_confirmed)
                                    blue
                                @else
                                    grey
                                @endif
                            ">
                                @if($order->is_cancelled)
                                    Cancelled
                                @elseif($order->is_confirmed)
                                    Confirmed
                                @else
                                    Pending
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center">
                <div class="container py-4">
                    {{ $orders->links('pagination::simple-bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
