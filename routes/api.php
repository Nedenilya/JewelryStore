<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::group(['middleware' => 'jwt.auth', 'prefix' => 'products'], function ($router) {
    Route::get('/get', [ProductController::class, 'get']);
    Route::post('/create', [ProductController::class, 'create']);
    Route::post('/update', [ProductController::class, 'update']);
    Route::post('/delete', [ProductController::class, 'delete']);
});

Route::group(['middleware' => 'jwt.auth', 'prefix' => 'cart'], function ($router) {
//    Route::get('/get', [CartController::class, 'get']);
});


Route::group(['middleware' => 'api'/*'jwt.auth'*/, 'prefix' => 'admin'], function ($router) {
    Route::get('/users/get', [UserController::class, 'get']);
});
