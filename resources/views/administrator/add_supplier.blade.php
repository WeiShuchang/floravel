@extends('administrator.base')

@section('page_title', 'Add Supplier')

@section('content')
    <div class="container vh-100 pt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Add New Supplier</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('suppliers.store') }}">
                            @csrf

                            <div class="form-group">
                                <label for="supplier_name">Supplier Name</label>
                                <input type="text" name="supplier_name" id="supplier_name" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="supplier_location">Location</label>
                                <textarea name="supplier_location" id="supplier_location" class="form-control" required></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary mt-3">Add Supplier</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
