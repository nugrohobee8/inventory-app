<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GoodsReceiptController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', function () {
    return view('layouts.app');
});

Route::resource('categories', CategoryController::class)
    ->only(['index', 'create', 'store']);

Route::resource('products', ProductController::class)
    ->only(['index', 'create', 'store']);

Route::resource('goods-receipts', GoodsReceiptController::class);
