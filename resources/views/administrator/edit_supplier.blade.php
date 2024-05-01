@extends('administrator.base')

@section('page_title', 'Edit Supplier')

@section('content')
    <div class="container vh-100 pt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit Supplier</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('suppliers.update', $supplier->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="supplier_name">Supplier Name</label>
                                <input type="text" name="supplier_name" id="supplier_name" class="form-control" value="{{ $supplier->supplier_name }}" required>
                            </div>

                            <div class="form-group">
                                <label for="supplier_location">Location</label>
                                <textarea name="supplier_location" id="supplier_location" class="form-control" required>{{ $supplier->supplier_location }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-primary mt-3">Update Supplier</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
