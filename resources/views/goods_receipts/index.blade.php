@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h3>Goods Receipts</h3>

    <a href="{{ route('goods-receipts.create') }}" class="btn btn-primary">
        + Goods Receipt
    </a>
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Number</th>
            <th>Date</th>
            <th>Supplier</th>
            <th>Notes</th>
            <th width="120">Action</th>
        </tr>
    </thead>

    <tbody>
        @forelse($receipts as $r)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $r->number }}</td>
                <td>{{ $r->date }}</td>
                <td>{{ $r->supplier->name ?? '-' }}</td>
                <td>{{ $r->notes }}</td>
                <td>
                    <a href="{{ route('goods-receipts.show', $r->id) }}"
                       class="btn btn-sm btn-info">
                        View
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">
                    Belum ada data
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

{{ $receipts->links() }}

@endsection
