<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/products/type/{type_id}', [ProductController::class, 'getByType']);

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/products', [ProductController::class, 'store'])->middleware('admin'); // Admin-only route



// ==============
Route::middleware('auth:sanctum')->get('/products', [ProductController::class, 'index']); // View all products (accessible by all users)
Route::middleware('auth:sanctum')->get('/products/{id}', [ProductController::class, 'show']); // View single product (accessible by all users)

Route::middleware('auth:sanctum', 'admin')->post('/products', [ProductController::class, 'store']); // Add new product (admin only)
Route::middleware('auth:sanctum', 'admin')->put('/products/{id}', [ProductController::class, 'update']); // Edit product (admin only)
Route::middleware('auth:sanctum', 'admin')->delete('/products/{id}', [ProductController::class, 'destroy']); // Delete product (admin only)

use App\Http\Controllers\CategoryController;

Route::middleware('auth:sanctum', 'admin')->get('/categories', [CategoryController::class, 'index']); // Get all categories (admin only)
Route::middleware('auth:sanctum', 'admin')->post('/categories', [CategoryController::class, 'store']); // Create category (admin only)
Route::middleware('auth:sanctum', 'admin')->put('/categories/{id}', [CategoryController::class, 'update']); // Update category (admin only)
Route::middleware('auth:sanctum', 'admin')->delete('/categories/{id}', [CategoryController::class, 'destroy']); // Delete category (admin only)
