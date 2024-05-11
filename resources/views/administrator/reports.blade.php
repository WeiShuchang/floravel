@extends('administrator.base')

@section('page_title', 'Reports')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div class="center-div">
    <h1 class="container">Reports</h1>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12">
       
          
                <div class="">
                    <form action="{{ route('reports.search_admin') }}" method="GET" style="background:none;padding: 20px ;">
                        <div class="input-group">
                        
                            <select class="form-control" name="flower_name" style="background:none;padding:0px 5px;">

                                <option value="">Any</option>
                                @foreach($flowers as $flower)
                                    <option value="{{ $flower->name }}" {{ $flowerName === $flower->name ? 'selected' : '' }}>{{ $flower->name }}</option>
                                @endforeach
                            </select>

                            <select class="form-control" name="status" style="background:none;padding:0px 5px;">
                             
                                <option value="">Any</option>
                                <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="delivered" {{ $status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="shipped" {{ $status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                            </select>

                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                    </form>
                </div>
        <div class="mb-2">
            <form action="{{ route('orders.export_pdf') }}" method="GET" style="display: inline;background:none;padding:0;margin:0;">
                <input type="hidden" name="status" value="{{ $status }}">
                <input type="hidden" name="flower_name" value="{{ $flowerName }}">
                <button type="submit" class="btn btn-primary">Export to PDF</button>
            </form>
        </div>
                
        <div class="container mt-5">
                <canvas id="statusPieChart"></canvas>
            </div>

            <div class="table-responsive">
                @if ($orders->isEmpty())
                    <p>No records found.</p>
                @else
                    <p class="text-dark font-weight-bold">{{ $orders->total() }} result(s) found.</p>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>User Name</th>
                                <th>Flower Image</th>
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
                                    @elseif($order->is_delivered)
                                        <span class="text-success">Delivered</span>
                                    @else
                                        <span class="text-primary">Shipped</span>
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

<script>
    var ctx = document.getElementById('statusPieChart').getContext('2d');
    var statusPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: {!! json_encode($statusLabels) !!},
            datasets: [{
                label: 'Status of Orders for {{ $flowerName }}',
                data: {!! json_encode($statusData) !!},
                backgroundColor: [
                    'rgba(255, 99, 132, 0.7)', // Pending
                    'rgba(54, 162, 235, 0.7)', // Delivered
                    'rgba(255, 206, 86, 0.7)', // Shipped
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                position: 'right'
            }
        }
    });
</script>
</body>
</html>
@endsection
