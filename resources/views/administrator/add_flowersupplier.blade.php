@extends('administrator.base')

@section('page_title', 'Add Flower Supplier')

@section('content')
<div class="container vh-100 pt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add New Flower Supplier</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('flowersuppliers.store') }}">
                        @csrf

                        <div class="form-group">
                            <label for="supplier_id">Supplier</label>
                            <select name="supplier_id" id="supplier_id" class="form-control" required>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->supplier_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="flower_id">Flower</label>
                            <select name="flower_id" id="flower_id" class="form-control" required>
                                @foreach ($flowers as $flower)
                                    <option value="{{ $flower->id }}">{{ $flower->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" name="price" id="price" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="stocks">Stocks</label>
                            <input type="number" name="stocks" id="stocks" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Add Flower Supplier</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
