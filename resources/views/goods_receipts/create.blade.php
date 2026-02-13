@extends('layouts.app')

@section('content')

<div class="container">
    <h3>Goods Receipt</h3>

    <form method="POST" action="{{ route('goods-receipts.store') }}">
        @csrf

        <div class="row mb-3">
            <div class="col-md-3">
                <label>Tanggal</label>
                <input type="date" name="date" class="form-control" required>
            </div>

            <div class="col-md-4">
                <label>Supplier</label>
                <select name="suppliers_id" class="form-control">
                    <option value="">-- pilih --</option>
                    @foreach($suppliers as $s)
                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-5">
                <label>Notes</label>
                <input type="text" name="notes" class="form-control">
            </div>
        </div>

        <hr>

        <h5>Items</h5>

        <table class="table table-bordered" id="items-table">
            <thead>
                <tr>
                    <th width="40%">Product</th>
                    <th width="30%">Warehouse</th>
                    <th width="20%">Qty</th>
                    <th width="10%"></th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>

        <button type="button" class="btn btn-sm btn-primary" onclick="addRow()">
            + Tambah Item
        </button>

        <hr>

        <button class="btn btn-success">
            Simpan Goods Receipt
        </button>
    </form>
</div>

@endsection

@section('scripts')

<script>
let rowIndex = 0;

function addRow() {
    const products = @json($products);
    const warehouses = @json($warehouses);

    let productOptions = '';
    products.forEach(p => {
        productOptions += `<option value="${p.id}">${p.name}</option>`;
    });

    let warehouseOptions = '';
    warehouses.forEach(w => {
        warehouseOptions += `<option value="${w.id}">${w.name}</option>`;
    });

    const row = `
    <tr>
        <td>
            <select name="items[${rowIndex}][product_id]" class="form-control" required>
                ${productOptions}
            </select>
        </td>

        <td>
            <select name="items[${rowIndex}][warehouse_id]" class="form-control" required>
                ${warehouseOptions}
            </select>
        </td>

        <td>
            <input type="number" name="items[${rowIndex}][qty]" class="form-control" min="1" required>
        </td>

        <td>
            <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">
                X
            </button>
        </td>
    </tr>
    `;

    document.querySelector('#items-table tbody')
        .insertAdjacentHTML('beforeend', row);

    rowIndex++;
}

function removeRow(btn) {
    btn.closest('tr').remove();
}

addRow();
</script>

@endsection
