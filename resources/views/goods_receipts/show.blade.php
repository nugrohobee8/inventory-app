@extends('layouts.app')

@section('content')

<h3>Goods Receipt Detail</h3>

<div class="mb-3">
    <strong>Number:</strong> {{ $goodsReceipt->number }} <br>
    <strong>Date:</strong> {{ $goodsReceipt->date }} <br>
    <strong>Supplier:</strong> {{ $goodsReceipt->supplier->name ?? '-' }} <br>
    <strong>Notes:</strong> {{ $goodsReceipt->notes }}
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Product</th>
            <th>Warehouse</th>
            <th>Qty</th>
        </tr>
    </thead>

    <tbody>
        @foreach($goodsReceipt->items as $item)
        <tr>
            <td>{{ $item->product->name }}</td>
            <td>{{ $item->warehouse->name }}</td>
            <td>{{ $item->qty }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
