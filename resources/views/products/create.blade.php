@extends('layouts.app')

@section('content')

<h3>Create Product</h3>

<form method="POST" action="{{ route('products.store') }}">
    @csrf

    <div class="row">

        <div class="col-md-4 mb-3">
            <label>SKU</label>
            <input name="sku" class="form-control" required>
        </div>

        <div class="col-md-8 mb-3">
            <label>Name</label>
            <input name="name" class="form-control" required>
        </div>

        <div class="col-md-4 mb-3">
            <label>Category</label>
            <select name="category_id" class="form-control" required>
                <option value="">-- pilih --</option>
                @foreach($categories as $c)
                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4 mb-3">
            <label>Unit</label>
            <input name="unit" class="form-control" placeholder="pcs, box, kg">
        </div>

        <div class="col-md-4 mb-3">
            <label>Min Stock</label>
            <input name="min_stock" type="number" value="0" class="form-control">
        </div>

        <div class="col-md-12 mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <div class="col-md-12 mb-3">
            <label>
                <input type="checkbox" name="is_active" value="1" checked>
                Active
            </label>
        </div>

    </div>

    <button class="btn btn-success">
        Save Product
    </button>

</form>

@endsection
