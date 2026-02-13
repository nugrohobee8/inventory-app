@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h3>Products</h3>

    <a href="{{ route('products.create') }}" class="btn btn-primary">
        + Product
    </a>
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>SKU</th>
            <th>Name</th>
            <th>Category</th>
            <th>Unit</th>
            <th>Min Stock</th>
            <th>Status</th>
        </tr>
    </thead>

    <tbody>
        @forelse($products as $p)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $p->sku }}</td>
                <td>{{ $p->name }}</td>
                <td>{{ $p->category->name ?? '-' }}</td>
                <td>{{ $p->unit }}</td>
                <td>{{ $p->min_stock }}</td>
                <td>
                    @if($p->is_active)
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-secondary">Inactive</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center">No data</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{ $products->links() }}

@endsection
