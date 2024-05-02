<?php

use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ImagesManagerController;
use App\Http\Controllers\IconsController;
use App\Http\Controllers\HistoryManagerController;
use App\Http\Controllers\CategoryTypeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderStatusController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);

Route::group(['middleware' => 'auth'], function () {
    Route::resource('brands', BrandController::class);
    Route::resource('languages', LanguageController::class);
    Route::resource('images', ImagesManagerController::class);
    Route::resource('icons', IconsController::class);
    Route::resource('history', HistoryManagerController::class);
    Route::resource('category-type', CategoryTypeController::class);
    Route::resource('category', CategoryController::class);
    Route::get('category-lang/{language}', [CategoryController::class, 'index']);
    Route::get('products-lang/{language}', [ProductController::class, 'index']);
    Route::resource('products', ProductController::class);
    Route::resource('news', NewsController::class);
    Route::resource('slider', SliderController::class);
    Route::get('news/{$language}', [NewsController::class, 'index']);

    Route::post('makeOrder', [OrderStatusController::class, 'makeOrder']);

    Route::resource('/orders', OrderController::class);
    Route::patch('/orders-pending', [OrderStatusController::class, 'pendingOrder']);
    Route::patch('/orders-completed', [OrderStatusController::class, 'completedOrder']);
    Route::patch('/orders-hold', [OrderStatusController::class, 'holdOrder']);
    Route::get('/orders-total-week', [OrderStatusController::class, 'getTotalCompletedOrdersLastWeek']);
    Route::get('/orders-total-pending', [OrderStatusController::class, 'getTotalpendingOrdersLastWeek']);
    Route::get('/orders-total-hold', [OrderStatusController::class, 'getTotalHoldOrdersLastWeek']);

    Route::get('/dashboard-order',[DashboardController::class,'getOrderCountsAndLastTenOrders']);
    Route::get('/dashboard-history',[DashboardController::class,'getLastTenHistory']);
    Route::get('/dashboard-products',[DashboardController::class,'getProductsCount']);
    Route::get('/dashboard-brands',[DashboardController::class,'getBrandsCount']);
    Route::get('/dashboard-category',[DashboardController::class,'getCategoryCount']);
    Route::get('/dashboard-users',[DashboardController::class,'getUsersCount']);
});