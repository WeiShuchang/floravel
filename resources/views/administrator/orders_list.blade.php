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
                            <th>Name of User</th>
                            <th>Flower Image</th>
                            <th>Flower</th>
                            <th>Shipping Address</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total Amount</th>
                            <th>Ship</th>
                            <th>Cancel</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->user->name }}</td>
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
                                </form>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger cancel-order-btn" data-toggle="modal" data-target="#cancelModal" data-order-id="{{ $order->id }}">Cancel Order</button>
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

<!-- Cancel Order Modal -->
<div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelModalLabel">Cancel Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="cancelForm" method="POST" action="{{ route('orders.cancel', ['orderId' => ':orderId']) }}">
                @csrf
                @method('POST')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="cancelReason">Reason for Canceling:</label>
                        <textarea class="form-control" id="cancelReason" name="cancel_reason" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Cancel Order</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End of Cancel Order Modal -->

<script>
    $(document).ready(function(){
        $('.cancel-order-btn').click(function(){
            var orderId = $(this).data('order-id');
            var action = $('#cancelForm').attr('action').replace(':orderId', orderId);
            $('#cancelForm').attr('action', action);
        });

        $('.modal').on('shown.bs.modal', function() {
            $(this).find('[autofocus]').focus();
        });
    });
</script>

@endsection
