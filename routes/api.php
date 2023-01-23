<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AvatarController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\InstituteController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
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

Route::controller(InstituteController::class)
    ->middleware('auth:web')
    ->prefix('/institute')
    ->group(function () {
        Route::get('/get', 'index');
        Route::post('/create', 'create');
        Route::get('/get/{id}', 'show');
        Route::get('/get/{id}/departments', 'getDepartments');
        Route::patch('/edit/{id}', 'update');
        Route::delete('/delete/{id}', 'destroy');
    });

Route::controller(GroupController::class)
    ->middleware('auth:web')
    ->prefix('/group')
    ->group(function () {
        Route::get('/get', 'index');
        Route::get('/get-course', 'getCourse');
        Route::post('/create', 'create');// admin
        Route::get('/get/{id}', 'show');// not student
        Route::get('/get/{id}/students', 'getStudents');
        Route::get('/get/{id}/teachers', 'getTeachers');
        Route::patch('/edit/{id}', 'update');// admin
        Route::delete('/delete/{id}', 'destroy');//admin
    });

Route::controller(CourseController::class)
    ->middleware('auth:web')
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
    ->middleware('auth:web')
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
        Route::get('/get/{id}', 'show');//
        Route::patch('/edit/{id}', 'update');//
        Route::delete('/delete/{id}', 'destroy');//
        Route::post('/avatar', 'storeAvatar');
    });

Route::controller(StudentController::class)
    ->middleware('auth:web')
    ->prefix('/student')
    ->group(function () {
        Route::get('/get', 'index');//admin
        Route::get('/department', 'department');
        Route::get('/course', 'course');
        Route::get('/get/{id}', 'show');// no policy
        Route::patch('/edit/{id}', 'update');// admin
        Route::delete('/delete/{id}', 'destroy');//admin
    });

Route::controller(TeacherController::class) // admin
->middleware('auth:web')
    ->prefix('/teacher')
    ->group(function () {
        Route::get('/get', 'index');
        Route::get('/department', 'department');
        Route::get('/courses', 'courses');
        Route::get('/get/{id}', 'show'); // no policy
        Route::patch('/edit/{id}', 'update');
        Route::delete('/delete/{id}', 'destroy');
    });

Route::controller(AvatarController::class)
    ->middleware('auth:web')
    ->prefix('/avatar')
    ->group(function () {
        Route::post('/store', 'store');
        Route::get('/get', 'show');
        Route::delete('/delete', 'destroy');
    });

Route::controller(ScheduleController::class)
    ->middleware('auth:web')
    ->prefix('/schedule')
    ->group(function () {
        Route::post('/store', 'store');
        Route::get('/get/{courseId}/{groupId}', 'show');
        Route::get('/get', 'index');
        Route::delete('/delete/{courseId}/{groupId}', 'destroy');
    });