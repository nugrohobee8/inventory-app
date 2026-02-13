@extends('layouts.app')

@section('content')

<h3>Create Warehouse</h3>

<form method="POST" action="{{ route('warehouses.store') }}">
    @csrf

    <div class="mb-3">
        <label>Code</label>
        <input name="code" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Name</label>
        <input name="name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Location</label>
        <input name="location" class="form-control">
    </div>

    <div class="mb-3">
        <label>Description</label>
        <textarea name="description" class="form-control"></textarea>
    </div>

    <button class="btn btn-success">
        Save Warehouse
    </button>

</form>

@endsection
