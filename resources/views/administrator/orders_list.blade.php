@extends('administrator.base')

@section('page_title', 'My Orders')

@section('content')

<div class="center-div " >
    <h1 class="container">Pending Orders</h1>
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
                            <th>Flower Image</th>
                            <th>Flower</th>
                            <th>Shipping Address</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total Amount</th>
                            <th>Ship</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>
                                <img src="{{ asset('storage/flower/' . $order->flower->picture) }}" alt="{{ $order->flower->name }}" style="max-height: 100px;">
                            </td>
                            <td>{{ $order->flower->name }}</td>
                            <td>{{ $order->shipping_address }}</td>
                            <td>{{ $order->flower->price }}</td>
                            <td>{{ $order->quantity }}</td>
                            <td>{{ $order->total_amount }}</td>
                            <td>  
                                <form method="POST" action="{{ route('orders.ship', ['orderId' => $order->id]) }}">
                                    @csrf
                                    @method('POST')

                                    <button type="submit" class="btn btn-dark">Ship Order</button>
                                </form></td>
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
