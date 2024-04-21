<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderProductController;

// Créer une nouvelle relation order-product
Route::post('/order-products', [OrderProductController::class, 'store']);

// Obtenir toutes les relations order-product
Route::get('/order-products', [OrderProductController::class, 'index']);

// Obtenir une relation order-product spécifique par order_id et product_id
Route::get('/order-products/{order_id}/{product_id}', [OrderProductController::class, 'show']);

// Mettre à jour une relation order-product spécifique par order_id et product_id
Route::put('/order-products/{order_id}/{product_id}', [OrderProductController::class, 'update']);

// Supprimer une relation order-product spécifique par order_id et product_id
Route::delete('/order-products/{order_id}/{product_id}', [OrderProductController::class, 'destroy']);

// Regroupe toutes les routes pour les commandes
Route::apiResource('/orders', OrderController::class);

// Routes pour les fournisseurs
Route::apiResource('/suppliers', SupplierController::class);

// Lister tous les produits
Route::get('/products', [ProductController::class, 'index']);

// Obtenir les détails d'un seul produit
Route::get('/products/{product}', [ProductController::class, 'show']);

// Créer un nouveau produit
Route::post('/products', [ProductController::class, 'store']);

// Mettre à jour un produit existant
Route::put('/products/{product}', [ProductController::class, 'update']);

// Supprimer un produit
Route::delete('/products/{product}', [ProductController::class, 'destroy']);

// Routes pour les clients
Route::apiResource('/customers', CustomerController::class);

