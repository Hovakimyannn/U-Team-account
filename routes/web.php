<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\InstituteController;
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

Route::controller(AuthController::class)
    ->group(function () {
        Route::post('/registration-file', 'downloadRegistrationFile')
            ->middleware('can:isAdmin,\App\Models\Admin');
        Route::get('/user', 'getCurrentUser');// no policy
        Route::post('/{role}/login', 'login')
            ->where('role', '^(student|admin|teacher)')
            ->middleware('guest');
        Route::post('/logout', 'logout'); // no policy
    });

Route::controller(InstituteController::class)
    ->prefix('/institute')
    ->middleware('can:isAdmin,\App\Models\Admin')
    ->group(function () {
        Route::get('/getAll', 'index');
        Route::post('/create', 'create');
        Route::get('/get', 'get');
        Route::patch('/edit', 'update');
        Route::delete('/delete', 'destroy');
    });

Route::controller(GroupController::class)
    ->prefix('/group')
    ->group(function () {
        Route::get('/get-all', 'getAll');// not student
        Route::post('/create', 'create');// admin
        Route::get('/get', 'get');// not student
        Route::patch('/edit', 'update');// admin
        Route::delete('/delete', 'destroy');//admin
    });

Route::controller(CourseController::class)
    ->prefix('/course')
    ->group(function () {
        Route::get('/getAll', 'getAll');// not student
        Route::post('/create', 'create');// admin
        Route::get('/get/{id}', 'show');// not student
        Route::patch('/edit/{id}', 'update');// admin
        Route::delete('/delete', 'destroy');//admin
    });

Route::controller(DepartmentController::class)
    ->prefix('/department')
    ->group(function () {
        Route::get('/getAll', 'index');// admin
        Route::post('/create', 'create');// admin
        Route::get('/get/{id}', 'show');// admin
        Route::patch('/edit/{id}', 'update');//admin
        Route::delete('/delete/{id}', 'destroy');//admin

    });

Route::controller(AdminController::class)
    ->middleware('auth.session')
    ->prefix('/admin')
    ->group(function () {
        Route::get('/get-all', 'getAll');//
        Route::post('/create', 'create');//
        Route::get('/get', 'get');//
        Route::patch('/edit', 'update');//
        Route::delete('/delete}', 'destroy');//
    });

Route::controller(StudentController::class)
    ->middleware('auth.session')
    ->prefix('/student')
    ->group(function () {
        Route::get('/getAll', 'getAll');//admin
        Route::post('/create', 'create');// admin
        Route::get('/get/{id}', 'show');// no policy
        Route::patch('/edit/{id}', 'update');// admin
        Route::delete('/delete/{id}', 'destroy');//admin
    });

Route::controller(TeacherController::class) // admin
->middleware('auth.session')
    ->prefix('/teacher')
    ->group(function () {
        Route::get('/getAll', 'getAll');
        Route::post('/create', 'create');
        Route::get('/get/{id}', 'show'); // no policy
        Route::patch('/edit/{id}', 'update');
        Route::delete('/delete/{id}', 'destroy');
    });
