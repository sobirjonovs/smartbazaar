<?php

use App\Http\Controllers\Api\Admin\AuthController as AdminAuthControllerAlias;
use App\Http\Controllers\Api\Merchant\AuthController as MerchantAuthController;
use App\Http\Controllers\Api\Merchant\ShopController;
use App\Http\Controllers\Api\User\AuthController;
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

Route::middleware('guest')->name('auth.')->group(function () {
    Route::prefix('user')->name('user.')->group(function () {
        Route::post('login', [AuthController::class, 'login'])->name('login');
        Route::post('register', [AuthController::class, 'register'])->name('register');
    });

    Route::prefix('merchant')->name('merchant.')->group(function () {
        Route::post('login', [MerchantAuthController::class, 'login'])->name('login');
        Route::post('register', [MerchantAuthController::class, 'register'])->name('register');
    });

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::post('login', [AdminAuthControllerAlias::class, 'login'])->name('login');
    });
});


Route::middleware('auth:api')->prefix('user')->name('user.')->group(function () {

});

Route::middleware('auth:api-merchant')->prefix('merchant')->name('merchant.')->group(function () {
    Route::get('shops', [ShopController::class, 'index'])->name('shops');
});

Route::middleware('auth:api-admin')->prefix('admin')->name('admin.')->group(function () {

});
