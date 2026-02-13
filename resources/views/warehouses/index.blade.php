@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h3>Warehouses</h3>

    <a href="{{ route('warehouses.create') }}" class="btn btn-primary">
        + Warehouse
    </a>
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Code</th>
            <th>Name</th>
            <th>Location</th>
            <th>Description</th>
        </tr>
    </thead>

    <tbody>
        @forelse($warehouses as $w)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $w->code }}</td>
            <td>{{ $w->name }}</td>
            <td>{{ $w->location }}</td>
            <td>{{ $w->description }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="text-center">No data</td>
        </tr>
        @endforelse
    </tbody>
</table>

{{ $warehouses->links() }}

@endsection
