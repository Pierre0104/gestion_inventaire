<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});


Route::get('/inventory', function () {
    return view('inventory');
});

Route::view('/inventory/products', 'products');

Route::view('/inventory/order', 'order');

Route::view('/inventory/customers', 'customers');

Route::view('/inventory/suppliers', 'suppliers');
