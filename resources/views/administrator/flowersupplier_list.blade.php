@extends('administrator.base')

@section('page_title', 'Flower Suppliers')

@section('content')

<style>
.center-div{
    display:flex;
    justify-content: center;
    text-align: center;
}
</style>

<div class="center-div py-3">
    <h1 class="container">Flower & Supplier</h1>
</div>


<div class="">

    <div class="container">
        <a href="{{ route('flowersuppliers.create') }}" class="btn btn-primary mb-2">Add Flower Supplier</a>
    </div>
</div>

<div class="container">
    <div class="row">

        <div class="col-md-12">
            <div class="table-responsive">
                <table id="mytable" class="table table-bordered table-striped">
                    <thead>
                        <th>Supplier Name</th>
                        <th>Flower Name</th>
                        <th>Price</th>
                        <th>Stocks</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </thead>
                    <tbody>
                        @foreach ($flowerSuppliers as $flowersupplier)
                        <tr>
                            <td>{{ $flowersupplier->supplier->supplier_name }}</td>
                            <td>{{ $flowersupplier->flower->name }}</td>
                            <td>{{ $flowersupplier->price }}</td>
                            <td>{{ $flowersupplier->stocks }}</td>
                            <td>
                                <a href="{{ route('flowersuppliers.edit', $flowersupplier->id) }}" class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit">
                                    <span class="glyphicon glyphicon-pencil"></span>Edit
                                </a>
                            </td>
                            <td>
                                <form action="{{ route('flowersuppliers.destroy', $flowersupplier->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete">
                                        <span class="glyphicon glyphicon-trash"></span>Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
