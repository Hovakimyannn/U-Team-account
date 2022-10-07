<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::controller(AuthController::class)->group(function () {
    Route::post('/login/{role}', 'login')->name('login')->where('role','^(student|admin|teacher)');
    Route::post('/logout', 'logout')->middleware('auth')->name('logout');
    Route::get('/index', 'index')->middleware('auth')->name('index');
    Route::post('/download', 'download')->middleware('auth');
});
