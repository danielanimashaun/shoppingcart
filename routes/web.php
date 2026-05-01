<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/product/displaygrid', [App\Http\Controllers\ProductController::class, 'displayGrid'])->name('products.displaygrid');

Route::get('/add-to-cart/{id}', [App\Http\Controllers\ProductController::class, 'addToCart']);

Route::get('/product/emptycart', [App\Http\Controllers\ProductController::class, 'emptycart'])->name('product.emptycart');

Route::get('/orders/checkout', [App\Http\Controllers\OrderController::class, 'checkout'])->name('orders.checkout');

Route::post('/orders/placeorder', [App\Http\Controllers\OrderController::class, 'placeorder'])->name('orders.placeorder');

Route::resource('products', App\Http\Controllers\ProductController::class);

Route::resource('orders', App\Http\Controllers\OrderController::class);