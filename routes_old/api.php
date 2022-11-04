<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SubCategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('api', function () {
    return 'workign';
});

Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['jwt.verify']], function () {
    Route::get('/product', [ProductController::class, 'index']);
    Route::resource('order', OrderController::class);
  	Route::get('orders/{id}', [OrderController::class, 'userOrders']);
    Route::get('/category', [CategoryController::class, 'index']);
    Route::get('/sub-category', [SubCategoryController::class, 'index']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
