<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GoodsReceiptController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\WarehouseController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('layouts.app');
});
Route::get('/home', function () {
    return view('layouts.app');
});

Route::resource('categories', CategoryController::class)
    ->only(['index', 'create', 'store']);

Route::resource('products', ProductController::class)
    ->only(['index', 'create', 'store']);

Route::resource('warehouses', WarehouseController::class)
    ->only(['index', 'create', 'store']);

Route::resource('suppliers', SupplierController::class)
    ->only(['index', 'create', 'store']);

Route::resource('goods-receipts', GoodsReceiptController::class);

Route::get('/debug-stock', function () {
    return new \App\Services\StockService();
});
