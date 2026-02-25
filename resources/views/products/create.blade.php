@extends('layouts.app')

@section('content')
<h4>Add Product</h4>

<form method="POST" action="{{ route('products.store') }}">
    @csrf

    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Purchase Price</label>
        <input type="number" name="purchase_price" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Sell Price</label>
        <input type="number" name="sell_price" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Opening Stock</label>
        <input type="number" name="stock_quantity" class="form-control" required>
    </div>

    <button class="btn btn-success">Save</button>
</form>
@endsection
