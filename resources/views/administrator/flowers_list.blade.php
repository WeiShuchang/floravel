@extends('administrator.base')

@section('page_title', 'Flowers')

@section('content')


<style>
.center-div{
    display:flex;
    justify-content: center;
    text-align: center;
}
</style>

<div class="center-div py-3">
    <h1 class="container">Flowers</h1>
</div>

    <div class="container">
    <a href="{{ route('flowers.create') }}" class="btn btn-primary mb-2 ">Add Flower</a>
    </div>

<div class="container mt-3">
    <div class="row">
    @if(session('success'))
    <div class="alert alert-success" role="alert" id="alert-message">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif


@foreach ($flowers as $flower)
    <div class="col-md-2 mb-3">
        <div class="card">
            <img src="{{ asset('storage/flower/' . $flower->picture) }}" class="card-img-top" alt="{{ $flower->name }}" height="200">
            <div class="card-body">
                <h4 class="card-title font-weight-bold">{{ $flower->name }}</h4>
                <p class="card-text">{{ $flower->description }}</p>
                <p class="card-text">Price: {{ $flower->price }}</p>
                <p class="card-text">Category: {{ $flower->category->category_name }}</p>
                <a href="{{ route('flowers.edit', $flower->id) }}" class="btn btn-primary">Edit</a>
                <form action="{{ route('flowers.destroy', $flower->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this flower?')">Delete</button>
                </form>
            </div>
        </div>
    </div>
@endforeach



        

    </div>
@endsection