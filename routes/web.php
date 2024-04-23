<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});


Route::get('/inventory', function () {
    return view('inventory');
});

Route::view('/inventory/products', 'products');
