@extends('administrator.base')

@section('page_title', 'Categories')

@section('content')


<style>
.center-div{
    display:flex;
    justify-content: center;
    text-align: center;
}
</style>

<div class="center-div py-3">
    <h1 class="container">Categories</h1>
</div>


<div class="">
    <div class="container">
    <a href="{{ route('categories.create') }}" class="btn btn-primary mb-2 ">Add Category</a>
    </div>
</div>
<div class="container">
	<div class="row">
      <div class="col-md-12">
        <div class="table-responsive">
        <table id="mytable" class="table table-bordred table-striped">
              
              <thead>
              <th>Category Name</th>
              <th>Description</th>
              <th>Edit</th>
              <th>Delete</th>
              </thead>
              <tbody>
                        @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->category_name }}</td>
                            <td>{{ $category->category_description }}</td>
                            <td>
                                <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-primary btn-xs" data-toggle="tooltip" title="Edit">
                                    <span class="glyphicon glyphicon-pencil"></span>Edit
                                </a>
                            </td>
                            <td>
                                <!-- Assuming you have a delete route and method defined -->
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure you want to delete this category?')">
                                        <span class="glyphicon glyphicon-trash"></span>Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
        
</table>




@endsection