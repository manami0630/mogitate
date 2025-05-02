<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;



Route::get('/products/register', [ProductController::class, 'register'])->name('products.register');

Route::post('/products/register', [ProductController::class, 'store'])->name('products.store');

Route::get('/products', [ProductController::class, 'list'])->name('products.list');

Route::get('/products/search', [ProductController::class, 'search']);

Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.details');

Route::delete('/products/{id}/delete', [ProductController::class, 'destroy'])->name('products.destroy');

Route::patch('/products/{id}/update', [ProductController::class, 'update'])->name('products.update');

