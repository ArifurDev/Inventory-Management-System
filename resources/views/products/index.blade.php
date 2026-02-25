@extends('layouts.app')

@section('content')
<h4>Product List</h4>

<a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Add Product</a>

<table class="table table-bordered">
    <tr>
        <th>Name</th>
        <th>Purchase Price</th>
        <th>Sell Price</th>
        <th>Stock</th>
    </tr>

    @foreach($products as $product)
    <tr>
        <td>{{ $product->name }}</td>
        <td>{{ $product->purchase_price }}</td>
        <td>{{ $product->sell_price }}</td>
        <td>{{ $product->stock_quantity }}</td>
    </tr>
    @endforeach
</table>
@endsection
