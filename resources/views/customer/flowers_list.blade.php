@extends('customer.base')

@section('page_title', 'Flowers For Sale')

@section('content')

<div class="container mt-3">
    <div class="row" style="margin-top: 150px;">
        @if(session('success'))
        <div class="alert alert-success" role="alert" id="alert-message">
            {{ session('success') }}
        </div>
        @endif
        <div class="center-div py-3">
            <h1 class="container">Flowers For Sale:</h1>
        </div>

        <!-- Search form -->
        <div class="col-md-12 mb-3">
            <form action="{{ route('flowers.search') }}" method="GET">
                <div class="input-group">
                    <input type="text" id="searchQuery" name="query" class="form-control" placeholder="Search flowers by name or category" aria-label="Search flowers" aria-describedby="button-addon2">
                    <button class="btn btn-primary" type="submit" id="button-addon2">Search</button>
                </div>
            </form>
        </div>

        @if(count($flowers) > 0)
            <div class="col-md-12 mb-3">
                <p>{{ $flowers->total() }} result(s) found.</p>
            </div>
            @foreach ($flowers as $flower)
                <div class="col-md-2 text-dark">
                    <div class="card mt-2">
                        <div class="image-container" style="height: 200px; overflow: hidden;">
                            <img src="{{ asset('storage/flower/' . $flower->picture) }}" class="card-img-top img-fluid" alt="{{ $flower->name }}" style="height: 100%; object-fit: cover;">
                        </div>
                        <div class="card-body ">
                            <h4 class="card-title  font-weight-bold">{{ $flower->name }}</h4>
                   
                            <p class="card-text">Price: ₱{{ $flower->price }}</p>
                            <p class="card-text">Stocks: {{ $flower->stocks }}</p>
                            <p class="card-text">Category: {{ $flower->category->category_name }}</p>
                            @if ($flower->stocks > 0)
                                <a href="{{ route('orders.create', ['flower' => $flower->id]) }}" class="btn btn-primary">Order</a>
                            @else
                                <button class="btn btn-secondary" disabled>Unavailable</button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="col-md-12 mt-3">
                {{ $flowers->appends(request()->input())->links('pagination::simple-bootstrap-4') }}
            </div>
        @else
            <div class="col-md-12 mb-3">
                <p>No results found.</p>
            </div>
        @endif
    </div>
</div>

<script>
    // Ensure the DOM is loaded before accessing elements
    document.addEventListener("DOMContentLoaded", function() {
        // Get the search query parameter from the URL
        const urlParams = new URLSearchParams(window.location.search);
        const searchQuery = urlParams.get('query');
        
        // Set the value of the search input field
        document.getElementById('searchQuery').value = searchQuery;
    });
</script>
@endsection
