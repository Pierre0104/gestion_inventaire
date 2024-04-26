<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;


Route::get('/', function () {
    return view('welcome');
});


Route::get('/inventory', function () {
    return view('inventory');
});

Route::view('/inventory/products', 'products');

Route::view('/inventory/orders', 'order');

Route::view('/inventory/customers', 'customers');

Route::view('/inventory', 'inventory');

// Si vous utilisez une méthode de contrôleur nommée 'index' pour afficher la page des commandes
// Route::get('/inventory/orders', [OrderController::class, 'index']);

Route::view('/inventory/suppliers', 'suppliers');
