<!DOCTYPE html>
<html>
<head>
    <title>Inventory System</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-dark bg-dark navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand text-white" href="#">Inventory System</a>

        <div>
            <a href="{{ route('products.index') }}" class="btn btn-sm btn-light">Products</a>
            <a href="{{ route('sales.create') }}" class="btn btn-sm btn-warning">New Sale</a>
            <a href="{{ route('report.index') }}" class="btn btn-sm btn-info">Report</a>
        </div>
    </div>
</nav>

<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @yield('content')
</div>

</body>
</html>
