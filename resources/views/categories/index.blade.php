@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h3>Categories</h3>

    <a href="{{ route('categories.create') }}" class="btn btn-primary">
        + Category
    </a>
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th width="60">#</th>
            <th>Name</th>
            <th>Description</th>
        </tr>
    </thead>

    <tbody>
        @forelse($categories as $c)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $c->name }}</td>
                <td>{{ $c->description }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="3" class="text-center">No data</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{ $categories->links() }}

@endsection
