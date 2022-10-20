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
        Route::post('/download', 'download');
        Route::get('/user', 'getCurrentUser');
        Route::post('/{role}/login', 'login')
            ->where('role', '^(student|admin|teacher)');
        Route::post('/logout', 'logout');
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
        Route::get('/getAll', 'getAll');//get all groups
        Route::post('/create', 'create');//create group
        Route::get('/get', 'get');//get group by id
        Route::patch('/edit', 'update');//edit group
        Route::delete('/delete', 'destroy');//delete group
    });

Route::controller(CourseController::class)
    ->prefix('/course')
    ->group(function () {
        Route::get('/getAll', 'getAll');//get all students
        Route::post('/create', 'create');//create students
        Route::get('/get', 'get');//get student
        Route::patch('/edit', 'update');//edit student
        Route::delete('/delete', 'destroy');//delete student
    });

Route::controller(DepartmentController::class)
    ->prefix('/department')
    ->group(function () {
        Route::get('/getAll', 'getAll');//get all students
        Route::post('/create', 'create');//create students
        Route::get('/get', 'get');//get student
        Route::patch('/edit', 'update');//edit student
        Route::delete('/delete', 'destroy');//delete student

    });

Route::controller(AdminController::class)
    ->middleware('auth.session')
    ->prefix('/admin')
    ->group(function () {
        Route::get('/getAll', 'getAll');//get all students
        Route::post('/create', 'create');//create students
        Route::get('/get', 'get');//get student
        Route::patch('/edit', 'update');//edit student
        Route::delete('/delete', 'destroy');//delete student
    });

Route::controller(StudentController::class)
    ->middleware('auth.session')
    ->prefix('/student')
    ->group(function () {
        Route::get('/getAll', 'getAll');//get all students
        Route::post('/create', 'create');//create students
        Route::get('/get', 'get');//get student
        Route::patch('/edit', 'update');//edit student
        Route::delete('/delete', 'destroy');//delete student
    });

Route::controller(TeacherController::class)
    ->middleware('auth.session')
    ->prefix('/teacher')
    ->group(function () {
        Route::get('/getAll', 'getAll');//get all students
        Route::post('/create', 'create');//create students
        Route::get('/get', 'get');//get student
        Route::patch('/edit', 'update');//edit student
        Route::delete('/delete', 'destroy');//delete student
    });
