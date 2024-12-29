<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('me', [AuthController::class, 'me']);
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::group(['middleware' => 'jwt.auth', 'prefix' => 'products'], function ($router) {
    Route::get('/getProducts', [ProductController::class, 'getProducts']);
    Route::get('/getByPrice', [ProductController::class, 'getByPrice']);
    Route::get('/getCategories', [ProductController::class, 'getCategories']);
    Route::get('/getBrands', [ProductController::class, 'getBrands']);

    Route::post('/getProductsByPrice', [ProductController::class, 'getProductsByPrice']);
    Route::post('/likeProduct', [ProductController::class, 'likeProduct']);
//    Route::post('/create', [ProductController::class, 'create']);
//    Route::post('/update', [ProductController::class, 'update']);
//    Route::post('/delete', [ProductController::class, 'delete']);
});

Route::group(['middleware' => 'jwt.auth', 'prefix' => 'blog'], function ($router) {
    Route::get('/getPosts', [BlogController::class, 'getPosts']);
    Route::get('/getCategories', [BlogController::class, 'getCategories']);

    Route::post('/likePost', [BlogController::class, 'likePost']);
});

Route::group(['middleware' => 'jwt.auth', 'prefix' => 'cart'], function ($router) {
//    Route::get('/get', [CartController::class, 'get']);
});


Route::group(['middleware' => 'api'/*'jwt.auth'*/, 'prefix' => 'admin'], function ($router) {
    Route::get('/users/get', [UserController::class, 'get']);
});
