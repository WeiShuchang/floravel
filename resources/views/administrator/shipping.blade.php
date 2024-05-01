@extends('administrator.base')

@section('page_title', 'My Orders')

@section('content')

<div class="center-div " >
    <h1 class="container">Shipping Orders</h1>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12">
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
                            <th>Complete Delivery</th>
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
                                <form action="{{ route('orders.deliver', ['orderId' => $order->id]) }}" method="POST">
                                    @csrf
                                    @method('POST')

                                    <button type="submit" class="btn btn-primary">Mark as Delivered</button>
                                </form>
                            </td>

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
