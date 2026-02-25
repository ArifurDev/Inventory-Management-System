@extends('layouts.app')

@section('content')
<h4>New Sale</h4>

<form method="POST" action="{{ route('sales.store') }}">
    @csrf

    <div class="mb-3">
        <label>Product</label>
        <select name="product_id" class="form-control" required>
            @foreach($products as $product)
                <option value="{{ $product->id }}">
                    {{ $product->name }} (Stock: {{ $product->stock_quantity }})
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Quantity</label>
        <input type="number" name="quantity" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Discount</label>
        <input type="number" name="discount" value="0" class="form-control">
    </div>

    <div class="mb-3">
        <label>Paid Amount</label>
        <input type="number" name="paid_amount" value="0" class="form-control">
    </div>

    <button class="btn btn-success">Complete Sale</button>
</form>
@endsection
