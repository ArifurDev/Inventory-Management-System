@extends('layouts.app')

@section('content')
<h4>Date-wise Financial Report</h4>

<form method="GET" action="{{ route('report.index') }}">
    <div class="row mb-3">
        <div class="col">
            <input type="date" name="from" class="form-control" required>
        </div>
        <div class="col">
            <input type="date" name="to" class="form-control" required>
        </div>
        <div class="col">
            <button class="btn btn-primary">Filter</button>
        </div>
    </div>
</form>

@if(isset($totalSales))
<div class="card p-3">
    <h5>Total Sales: {{ $totalSales }} TK</h5>
    <h5>Total Expense (COGS): {{ $totalExpense }} TK</h5>
</div>
@endif

@endsection
