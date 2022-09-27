<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
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

Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login')->name('login');
    Route::post('/invitation', 'register')->name('invitation');
    Route::post('/logout', 'logout')->middleware('auth:api')->name('logout');
    Route::post('/refresh', 'refresh')->middleware('auth:api')->name('refresh');
    Route::get('/index', 'index')->middleware('auth:api')->name('index');
});

Route::controller(RoleController::class)->group(function () {

});