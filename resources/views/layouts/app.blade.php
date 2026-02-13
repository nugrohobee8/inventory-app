<!DOCTYPE html>
<html>
<head>
    <title>Inventory App</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<nav class="navbar navbar-dark bg-dark navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="/home">Inventory</a>

        <div class="navbar-nav">
            <a class="nav-link" href="/goods-receipts">Goods Receipt</a>
            <a class="nav-link" href="/categories">Categories</a>
            <a class="nav-link" href="/products">Products</a>
            <a class="nav-link" href="/warehouses">Warehouses</a>
            <a class="nav-link" href="/suppliers">Suppliers</a>
        </div>
    </div>
</nav>

<div class="container mt-4">

    {{-- Flash message --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('content')

</div>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@yield('scripts')

</body>
</html>
