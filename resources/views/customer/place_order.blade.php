@extends('customer.base')

@section('page_title', 'Create Order')

@section('content')

<div class="container" style="margin-top:150px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create Order</div>   
                @if ($errors->any())
                    <div class="alert alert-danger" id="alert-message">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card-body bg-light">
                    @if($flower)
                    <div class="text-center mb-4">
                        <div class="image-container mb-2">
                            <h1>{{$flower->name}}</h1>
                        </div>
                        <div class="image-container" style="height: 200px; width: auto;">
                            <img src="{{ asset('storage/flower/' . $flower->picture) }}" class="img-fluid" alt="{{ $flower->name }}" style="height: 100%; object-fit: cover;">
                            <div class="image-container mt-2">
                                <p>Price: ₱{{$flower->price}}</p>
                            </div>
                            <div class="image-container mt-2">
                                <p>Description: {{$flower->description}}</p>
                            </div>
                            <div class="image-container mt-2">
                                <p class="font-weight-bold text-dark">Stocks Left: {{$flower->stocks}}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                   
                    <form method="post" action="{{ route('orders.store') }}" class="bg-light" id="order-form">
                        @csrf
                        <!-- Hidden field to pass flower ID -->
                        <input type="hidden" name="flower_id" value="{{ $flower->id }}">

                        <div class="form-group py-2">
                            <label for="quantity">Quantity</label>
                            <input type="number" name="quantity" class="form-control" id="quantity" value="{{ $errors->has('quantity') ? old('quantity') : 1 }}" required>
                            <!-- If error occurred, display old value, otherwise default to 1 -->
                        </div>

                        <div class="form-group py-2">
                            <label for="shipping_address">Shipping Address</label>
                            <textarea name="shipping_address" class="form-control" rows="3" id="shipping_address" required>{{ old('shipping_address') }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Place Order</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Get the form fields
    var quantityInput = document.getElementById('quantity');
    var shippingAddressInput = document.getElementById('shipping_address');
    
    // Get the previously inputted values from localStorage if they exist
    var savedQuantity = localStorage.getItem('savedQuantity');
    var savedShippingAddress = localStorage.getItem('savedShippingAddress');
    
    // Set the input values if they exist
    if(savedQuantity) {
        quantityInput.value = savedQuantity;
    }
    if(savedShippingAddress) {
        shippingAddressInput.value = savedShippingAddress;
    }
    
    // Add event listeners to save the input values when the input changes
    quantityInput.addEventListener('input', function() {
        localStorage.setItem('savedQuantity', this.value);
    });
    shippingAddressInput.addEventListener('input', function() {
        localStorage.setItem('savedShippingAddress', this.value);
    });
    
    // Clear the saved input values when the form is submitted successfully
    var form = document.getElementById('order-form');
    form.addEventListener('submit', function() {
        localStorage.removeItem('savedQuantity');
        localStorage.removeItem('savedShippingAddress');
    });
});

</script>

@endsection
