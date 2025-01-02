<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\V1\Auth\AdminAuthController;
use App\Http\Controllers\Api\V1\Auth\AgentAuthController;
use App\Http\Controllers\Api\V1\Admin\ProductController;
use App\Http\Controllers\Api\V1\Admin\AgentController;
use App\Http\Controllers\Api\V1\Admin\StockController;
use App\Http\Controllers\Api\V1\Agent\QuotationController;
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

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register'])->name('register');

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('user', [AuthController::class, 'user']);
    });
});

Route::group(['prefix' => 'auth'], function () {
    // Admin Auth Routes
    Route::post('admin/login', [AdminAuthController::class, 'login']);
    Route::post('admin/logout', [AdminAuthController::class, 'logout'])->middleware('auth:admin');

    // Agent Auth Routes
    Route::post('agent/login', [AgentAuthController::class, 'login']);
    Route::post('agent/logout', [AgentAuthController::class, 'logout'])->middleware('auth:agent');
});




// Admin Routes
Route::middleware(['auth:sanctum', 'type.admin'])->prefix('admin')->group(function () {
    Route::apiResource('products', ProductController::class);
    Route::apiResource('agents', AgentController::class);
    Route::apiResource('stocks', StockController::class);
});

// Agent Routes
Route::middleware(['auth:sanctum', 'type.agent'])->prefix('agent')->group(function () {
    Route::apiResource('quotations', QuotationController::class);
});




// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
