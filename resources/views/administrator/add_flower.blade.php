@extends('administrator.base')

@section('page_title', 'Add Flower')

@section('content')
    <div class="container vh-100 pt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Add New Flower</div>

                    @if ($errors->any())
                        <div class="alert alert-danger" id="alert-message">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="card-body">
                        <form method="post" action="{{ route('flowers.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group py-2">
                                <label for="name">Flower Name</label>
                                <input type="text" name="name" class="form-control" id="name" placeholder="Enter Flower Name" value="{{ old('name') }}" required>
                            </div>

                            <div class="form-group py-2">
                                <label for="category_id">Category</label>
                                <select name="category_id" class="form-control" required>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group py-2">
                                <label for="description">Description</label>
                                <textarea name="description" class="form-control" rows="3" placeholder="Enter Flower Description" required>{{ old('description') }}</textarea>
                            </div>

                            <div class="form-group py-2">
                                <label for="picture">Picture</label>
                                <input type="file" name="picture" class="form-control-file" id="picture" required>
                            </div>

                            <div class="form-group py-2">
                                <label for="price">Price</label>
                                <input type="number" name="price" class="form-control" id="price" placeholder="Enter Price" value="{{ old('price') }}" required>
                            </div>

                            <div class="form-group py-2">
                                <label for="stocks">Stocks</label>
                                <input type="number" name="stocks" class="form-control" id="stocks" placeholder="Enter Stocks" value="{{ old('stocks') }}" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
