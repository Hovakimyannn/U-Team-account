<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
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
    Route::get('/user','getCurrentUser')->name('getUser');
    Route::post('/{role}/login', 'login')->name('login')->where('role', '^(student|admin|teacher)');
    Route::post('/logout', 'logout')->name('logout');
});

Route::group(['middleware' => 'auth:admin', 'prefix' => '/admin'], function () {
    Route::post('/download', [AuthController::class, 'download'])->name('download');
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
});

Route::group(['middleware' => 'auth:student', 'prefix' => '/student'], function () {
    Route::get('/index', [StudentController::class, 'index'])->name('studentIndex');
});

Route::group(['middleware' => 'auth:teacher', 'prefix' => '/teacher'], function () {
    Route::get('/index', [TeacherController::class, 'index'])->name('teacherIndex');
});

