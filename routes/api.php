<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;


//public routes

Route::post('register', [AuthController::class , 'register']);

Route::post('login', [AuthController::class, 'login']);

Route::resource('product', ProductController::class);



//protected routes

Route::group(['middleware' => 'auth:sanctum'],function(){
    Route::post('logout', [AuthController::class, 'logout']);
    Route::resource('order', OrderController::class);
});



