<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//测试模块
Route::prefix('test')->middleware([])->group(function () {
    Route::get('/basic', [\App\Http\Controllers\Test\TestController::class, 'basic']);
    Route::get('/exception', [\App\Http\Controllers\Test\TestController::class, 'exception']);
    Route::get('/verify', [\App\Http\Controllers\Test\TestController::class, 'verify']);
    Route::match(['get', 'post'],'/db', [\App\Http\Controllers\Test\TestController::class, 'db']);
});


//管理后台
Route::prefix('admin')->middleware([])->group(function () {
    Route::match(['get', 'post'],'/login', [\App\Http\Controllers\Admin\AuthController::class, 'login']);
    Route::match(['get', 'post'],'/logout', [\App\Http\Controllers\Admin\AuthController::class, 'logout']);
});
