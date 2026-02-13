@extends('layouts.app')

@section('content')

<h3>Create Supplier</h3>

<form method="POST" action="{{ route('suppliers.store') }}">
    @csrf

    <div class="mb-3">
        <label>Name</label>
        <input name="name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Phone</label>
        <input name="phone" class="form-control">
    </div>

    <div class="mb-3">
        <label>Email</label>
        <input name="email" class="form-control">
    </div>

    <div class="mb-3">
        <label>Address</label>
        <textarea name="address" class="form-control"></textarea>
    </div>

    <button class="btn btn-success">
        Save Supplier
    </button>

</form>

@endsection
