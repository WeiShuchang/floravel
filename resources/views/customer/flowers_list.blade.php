@extends('customer.base')

@section('page_title', 'Flowers For Sale')

@section('content')

<div class="container mt-3" >
    <div class="row" style="margin-top: 150px;">
    @if(session('success'))
    <div class="alert alert-success" role="alert" id="alert-message">
        {{ session('success') }}
    </div>
    @endif
    <div class="center-div py-3">
        <h1 class="container">Flowers For Sale:</h1>
    </div>
    

        @foreach ($flowers as $flower)
        <div class="col-md-2 " >
            <div class="card mt-2">
                <div class="image-container" style="height: 200px; overflow: hidden;">
                    <img src="{{ asset('storage/flower/' . $flower->picture) }}" class="card-img-top img-fluid" alt="{{ $flower->name }}" style="height: 100%; object-fit: cover;">
                </div>
                <div class="card-body ">
                    <h4 class="card-title  font-weight-bold">{{ $flower->name }}</h4>
                    <p class="card-text">{{ $flower->description }}</p>
                    <p class="card-text">Price: ₱{{ $flower->price }}</p>
                    <p class="card-text">Category: {{ $flower->category->category_name }}</p>
                    <a href="{{ route('orders.create', ['flower' => $flower->id]) }}" class="btn btn-primary">Order</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
<script>
    // Ensure the DOM is loaded before accessing elements
    document.addEventListener("DOMContentLoaded", function() {
        // Get the alert message element
        let alertMessage = document.getElementById("alert-message");
        
        // Set timeout to hide the alert after 5000 milliseconds (5 seconds)
        setTimeout(function() {
            // Hide the alert by changing its display style to "none"
            alertMessage.style.display = "none";
        }, 4000); 
    });
    

</script>
@endsection
