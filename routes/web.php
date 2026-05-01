<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('products', App\Http\Controllers\ProductController::class);

Route::resource('orders', App\Http\Controllers\OrderController::class);

Route::get('/product/displaygrid', [App\Http\Controllers\ProductController::class, 'displayGrid'])->name('products.displaygrid');

Route::get('/add-to-cart/{id}', [App\Http\Controllers\ProductController::class, 'addToCart']);