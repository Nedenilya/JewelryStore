<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('me', [AuthController::class, 'me']);
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::group(['middleware' => 'api'/*'jwt.auth'*/, 'prefix' => 'shop'], function ($router) {
    Route::get('/getCollectionName', [ShopController::class, 'getCollectionName']);
});

Route::group(['middleware' => 'api'/*'jwt.auth'*/, 'prefix' => 'products'], function ($router) {
    Route::get('/getProductById', [ProductController::class, 'getProductById']);
    Route::get('/getProducts', [ProductController::class, 'getProducts']);
    Route::get('/getByPrice', [ProductController::class, 'getByPrice']);
    Route::get('/getCategories', [ProductController::class, 'getCategories']);
    Route::get('/getBrands', [ProductController::class, 'getBrands']);
    Route::get('/getBestOffers', [ProductController::class, 'getBestOffers']);

    Route::post('/getProductsByPrice', [ProductController::class, 'getProductsByPrice']);
    Route::post('/likeProduct', [ProductController::class, 'likeProduct']);
    Route::post('/addToCart', [ProductController::class, 'addToCart']);
//    Route::post('/create', [ProductController::class, 'create']);
//    Route::post('/update', [ProductController::class, 'update']);
//    Route::post('/delete', [ProductController::class, 'delete']);
});

Route::group(['middleware' => 'api'/*'jwt.auth'*/, 'prefix' => 'blog'], function ($router) {
    Route::get('/getPosts', [BlogController::class, 'getPosts']);
    Route::get('/getResentPosts', [BlogController::class, 'getResentPosts']);
    Route::get('/getPostById', [BlogController::class, 'getPostById']);
    Route::get('/getCategories', [BlogController::class, 'getCategories']);
    Route::get('/getLastNews', [BlogController::class, 'getLastNews']);

    Route::post('/likePost', [BlogController::class, 'likePost']);
});

Route::group(['middleware' => 'api'/*'jwt.auth'*/, 'prefix' => 'cart'], function ($router) {
    Route::get('/getCart', [CartController::class, 'getCart']);
    Route::post('/deleteCartItem', [CartController::class, 'deleteCartItem']);
});


Route::group(['middleware' => 'api'/*'jwt.auth'*/, 'prefix' => 'admin'], function ($router) {
    Route::get('/users/get', [UserController::class, 'get']);
});
