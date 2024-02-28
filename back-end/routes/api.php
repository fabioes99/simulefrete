<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);

    // por colocar resource nao preciso especificar qual a funcao que este endpoint esta passando
    // como delete, show, edit , etc..
    Route::resource('/product', ProductController::class);
    Route::resource('/supplier', SupplierController::class);

    Route::get('/dashboard', [DashboardController::class, 'index']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
