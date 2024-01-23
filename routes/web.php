<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource("products", ProductController::class);
Route::post("products/isActive/{product}", [ProductController::class, 'isActive'])->name('products.isActive');