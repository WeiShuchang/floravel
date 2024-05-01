@extends('administrator.base')

@section('page_title', 'Edit Category')

@section('content')
    <div class="container vh-100 pt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit Category</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('categories.update', $category->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="category_name">Category Name</label>
                                <input type="text" name="category_name" id="category_name" class="form-control" value="{{ $category->category_name }}" required>
                            </div>

                            <div class="form-group">
                                <label for="category_description">Description</label>
                                <textarea name="category_description" id="category_description" class="form-control" required>{{ $category->category_description }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-primary mt-3">Update Category</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
