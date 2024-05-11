@extends('customer.base')

@section('page_title', 'My Orders')

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div class="center-div" style="margin-top: 150px;">
    <h1 class="container">My Orders</h1>
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
          
                <div class="">
                    <form action="{{ route('completed.reservations.search') }}" method="GET" style="background:none;padding: 20px ;">
                        <div class="input-group">
                            <select class="form-control" name="status" style="background:none;padding:0px 5px;">
                                <option value="">Select Status</option>
                                <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="delivered" {{ $status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="shipped" {{ $status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                            </select>

                            <select class="form-control" name="flower_name" style="background:none;padding:0px 5px;">
                                <option value="" style="background:none;padding: 100px 10px;">Select Flower</option>
                                @foreach($flowers as $flower)
                                    <option value="{{ $flower->name }}" {{ $flowerName === $flower->name ? 'selected' : '' }}>{{ $flower->name }}</option>
                                @endforeach
                            </select>

                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                    </form>
                </div>
    
                
            <div class="table-responsive">
                @if ($orders->isEmpty())
                    <p>No records found.</p>
                @else
                    <p class="text-dark font-weight-bold">{{ $orders->total() }} result(s) found.</p>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Flower Image</th>
                                <th>Flower</th>
                                <th>Shipping Address</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td style="max-width: 100px;">
                                    <img src="{{ asset('storage/flower/' . $order->flower->picture) }}" alt="{{ $order->flower->name }}" style="max-height: 80px;">
                                </td>
                                <td>{{ $order->flower->name }}</td>
                                <td>{{ $order->shipping_address }}</td>
                                <td>₱{{ $order->flower->price }}</td>
                                <td>x{{ (int) $order->quantity }}</td>
                                <td>₱{{ $order->total_amount }}</td>
                                <td>
                                    @if($order->pending)
                                    <span class="text-warning">Pending</span>
                                    <!-- Add cancel button for pending orders -->
                                    <td>
                                        <a href="{{ route('orders.cancel_user_view', $order->id) }}" class="btn btn-danger btn-sm">Cancel Order</a>
                                    </td>
                                    @elseif($order->is_delivered)
                                    <span class="text-success">Delivered</span>
                                        <td>
                                            <form method="POST" action="{{ route('orders.confirm_delivery', $order->id) }}" style="background:none;padding:0; margin:0;">
                                                @csrf
                                                <button type="submit" style="padding:5; margin:0;" class="btn btn-success btn-sm">Confirm Delivery</button>
                                            </form>
                                        </td>
                                    @else
                                        <span class="text-primary">Shipped</span>
                                        <td></td>
                                    @endif
                                </td>
                            </tr>
                        @endforeach                       
                        </tbody>
                    </table>
                @endif
            </div>

            <div class="d-flex justify-content-center">
                <div class="container py-4">
                    {{ $orders->links('pagination::simple-bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>


</script>

@endsection
