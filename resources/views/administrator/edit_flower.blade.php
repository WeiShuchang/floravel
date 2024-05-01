@extends('administrator.base')

@section('page_title', 'Edit Flower')

@section('content')

<style>
    .current-picture-container {
    max-width: 100%;
    height: auto;
    overflow: hidden;
}

.current-picture-container img {
    width: 100%;
    height: auto;
}

</style>
 
    <div class="container py-4">
        @if($errors->any())
            <div class="alert alert-danger  ">
                <ul>
                    @foreach ($errors->all() as $error)
                    {{ $error }}
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-md-8">
           
                <div class="card">
                    <div class="card-header">Edit Flower</div>

                    <div class="card-body">
                        <form method="post" action="{{ route('flowers.update', $flower->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group py-2">
                                <label for="name">Flower Name</label>
                                <input type="text" name="name" class="form-control" id="name" value="{{ $flower->name }}" required>
                            </div>

                            <div class="form-group py-2">
                                <label for="category_id">Category</label>
                                <select name="category_id" class="form-control" required>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $flower->category_id == $category->id ? 'selected' : '' }}>{{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group py-2">
                                <label for="description">Description</label>
                                <textarea name="description" class="form-control" rows="3" required>{{ $flower->description }}</textarea>
                            </div>

                            <div class="form-group py-2" style="max-width: 100px;">
                                <label for="current_picture">Current Picture</label>
                                <div class="current-picture-container">
                                    <img src="{{ asset('storage/flower/' . $flower->picture) }}" alt="{{ $flower->name }}" class="img-fluid">
                                </div>
                            </div>


                            <div class="form-group py-2">
                                <label for="new_picture">New Picture</label>
                                <input type="file" name="new_picture" class="form-control-file" id="new_picture">
                            </div>

                            <div class="form-group py-2">
                                <label for="price">Price</label>
                                <input type="text" name="price" class="form-control" id="price" value="{{ $flower->price }}" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
