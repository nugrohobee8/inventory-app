@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h3>Suppliers</h3>

    <a href="{{ route('suppliers.create') }}" class="btn btn-primary">
        + Supplier
    </a>
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Address</th>
        </tr>
    </thead>

    <tbody>
        @forelse($suppliers as $s)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $s->name }}</td>
            <td>{{ $s->phone }}</td>
            <td>{{ $s->email }}</td>
            <td>{{ $s->address }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="text-center">No data</td>
        </tr>
        @endforelse
    </tbody>
</table>

{{ $suppliers->links() }}

@endsection
