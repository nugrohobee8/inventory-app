<?php

namespace App\Http\Controllers;

use App\Models\GoodsReceipt;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Warehouse;
use App\Services\StockService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class GoodsReceiptController extends Controller
{

    public function index()
    {
        $receipts = GoodsReceipt::latest()->get();

        return view('goods_receipts.index', compact('receipts'));
    }

    public function show($id)
    {
        $goodsReceipt = GoodsReceipt::with([
            'items.product',
            'items.warehouse',
            'supplier'
        ])->findOrFail($id);

        return view('goods_receipts.show', compact('goodsReceipt'));
    }



    public function create()
    {
        return view('goods_receipts.create', [
            'products' => Product::all(),
            'suppliers' => Supplier::all(),
            'warehouses' => Warehouse::all(),
        ]);
    }


    public function store(Request $request, StockService $stockService)
    {
        $request->validate([
            'date' => 'required|date',
            'items.*.product_id' => 'required',
            'items.*.warehouse_id' => 'required',
            'items.*.qty' => 'required|numeric|min:1',
        ]);

        DB::transaction(function () use ($request, $stockService) {

            $receipt = GoodsReceipt::create([
                'number' => 'GR-' . now()->format('YmdHis'),
                'supplier_id' => $request->supplier_id,
                'date' => $request->date,
                'notes' => $request->notes,
                'created_by' => Auth::id(),
            ]);

            foreach ($request->items as $item) {

                $detail = $receipt->items()->create($item);

                $stockService->addStock(
                    productId: $detail->product_id,
                    warehouseId: $detail->warehouse_id,
                    qty: $detail->qty,
                    referenceType: 'goods_receipts',
                    referenceId: $receipt->id,
                    notes: 'Goods Receipt ' . $receipt->number,
                    userId: Auth::id(),
                );
            }
        });

        return redirect()->route('goods-receipts.index')
            ->with('success', 'Goods receipt saved');
    }
}
