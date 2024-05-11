@extends('customer.base')

@section('page_title', 'Cancel Order')

@section('content')
<div class="container " style="margin-top:100px">
    <div class="row justify-content-center mt-5"> <!-- Center the content and add margin top -->
        <div class="col-md-6">
            <h1 class="text-center ">Cancel Order</h1> <!-- Center the heading -->
            <form action="{{ route('orders.cancel_user', $order->id) }}" method="POST" class="text-white">
                @csrf
                <table class="table text-white">
                    <tr>
                        <th>Flower</th>
                        <td>{{ $order->flower->name }}</td>
                    </tr>
                    <tr>
                        <th>Shipping Address</th>
                        <td>{{ $order->shipping_address }}</td>
                    </tr>
                    <tr>
                        <th>Price</th>
                        <td>₱{{ $order->flower->price }}</td>
                    </tr>
                    <tr>
                        <th>Quantity</th>
                        <td>{{ $order->quantity }}</td>
                    </tr>
                    <tr>
                        <th>Total Amount</th>
                        <td>₱{{ $order->total_amount }}</td>
                    </tr>
                    <tr>
                        <th>Cancel Reason</th>
                        <td>
                            <textarea class="form-control" name="cancel_reason" rows="3" required></textarea>
                        </td>
                    </tr>
                </table>
                <button type="submit" class="btn btn-danger btn-block">Cancel Order</button> <!-- Center the button -->
            </form>
        </div>
    </div>
</div>
@endsection
