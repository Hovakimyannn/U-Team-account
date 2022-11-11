<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\InstituteController;
use App\Http\Controllers\PasswordController;
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
            ->middleware('can:is_admin');

        Route::get('/user', 'getCurrentUser')
            ->middleware('auth:web');

        Route::post('/{role}/login', 'login')
            ->where('role', '^(student|admin|teacher)')
            ->middleware('guest');

        Route::post('/logout', 'logout');
    });

Route::controller(InstituteController::class)
    ->prefix('/institute')
    ->middleware('auth:web')
    ->group(function () {
        Route::get('/get', 'index');
        Route::post('/create', 'create');
        Route::get('/get/{id}', 'show');
        Route::get('/get/{id}/departments', 'getDepartments');
        Route::patch('/edit/{id}', 'update');
        Route::delete('/delete/{id}', 'destroy');
    });

Route::controller(GroupController::class)
    ->prefix('/group')
    ->group(function () {
        Route::get('/get', 'index');
        Route::post('/create', 'create');// admin
        Route::get('/get/{id}', 'show');// not student
        Route::get('/get/{id}/students', 'getStudents');
        Route::get('/get/{id}/teachers', 'getTeachers');
        Route::patch('/edit/{id}', 'update');// admin
        Route::delete('/delete/{id}', 'destroy');//admin
    });

Route::controller(CourseController::class)
    ->prefix('/course')
    ->group(function () {
        Route::get('/get', 'index');// not student
        Route::post('/create', 'create');// admin
        Route::get('/get/{id}', 'show');// not student
        Route::get('/get/{id}/groups', 'getGroups');
        Route::get('/get/{id}/students', 'getStudents');
        Route::get('/get/{id}/teachers', 'getTeachers');
        Route::patch('/edit/{id}', 'update');// admin
        Route::delete('/delete/{id}', 'destroy');//admin
    });

Route::controller(DepartmentController::class)
    ->prefix('/department')
    ->group(function () {
        Route::get('/get', 'index');// admin
        Route::post('/create', 'create');// admin
        Route::get('/get/{id}', 'show');// admin
        Route::get('/get/{id}/courses', 'getCourses');
        Route::get('/get/{id}/teachers', 'getTeachers');
        Route::patch('/edit/{id}', 'update');//admin
        Route::delete('/delete/{id}', 'destroy');//admin

    });

Route::controller(AdminController::class)
    ->middleware('auth:web')
    ->prefix('/admin')
    ->group(function () {
        Route::get('/get', 'index');//
        Route::post('/create', 'create');//
        Route::get('/get/{id}', 'show');//
        Route::patch('/edit/{id}', 'update');//
        Route::delete('/delete/{id}', 'destroy');//
    });

Route::controller(StudentController::class)
    ->middleware('auth:web')
    ->prefix('/student')
    ->group(function () {
        Route::get('/get', 'index');//admin
        Route::post('/create', 'create');// admin
        Route::get('/get/{id}', 'show');// no policy
        Route::patch('/edit/{id}', 'update');// admin
        Route::delete('/delete/{id}', 'destroy');//admin
    });

Route::controller(TeacherController::class) // admin
->middleware('auth:web')
    ->prefix('/teacher')
    ->group(function () {
        Route::get('/get', 'index');
        Route::post('/create', 'create');
        Route::get('/get/{id}', 'show'); // no policy
        Route::patch('/edit/{id}', 'update');
        Route::delete('/delete/{id}', 'destroy');
    });

Route::post('/forgot-password', [PasswordController::class, 'send'])
    ->middleware(['guest'])
    ->name('password.forgot');

Route::post('/reset-password', [PasswordController::class, 'reset'])
    ->middleware(['guest'])
    ->name('password.reset');


