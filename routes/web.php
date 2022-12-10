<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordController;
<<<<<<< HEAD
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentInvitationController;
use App\Http\Controllers\TeacherController;
=======
use App\Http\Controllers\InvitationController;
>>>>>>> 4d7e6f0282267cec8528a3a34e161a258a46e0d0
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

        Route::post('/logout', 'logout')
            ->middleware('auth:web');
    });

Route::controller(InvitationController::class)
    ->group(function () {
        Route::get('/get-invitations', 'get')
            ->middleware('can:is_admin');

        Route::post('/{role}/send-invitation', 'sendInvitation')
            ->middleware('can:is_admin');

        Route::get('/resend-invitation/{id}', 'resendInvitation')
            ->middleware('can:is_admin');

        Route::get('/accept/invitation', 'getUserByInvitation')
            ->middleware('guest');

        Route::post('/accept/invitation', 'acceptInvitation')
            ->middleware('guest');
    });

Route::controller(StudentInvitationController::class)
    ->prefix('/invitation')
    ->group(function () {
        Route::get('/get', 'index');
        Route::post('/create', 'create');// admin
    });

Route::post('/forgot-password', [PasswordController::class, 'send'])
    ->middleware(['guest'])
    ->name('password.forgot');

Route::post('/reset-password', [PasswordController::class, 'reset'])
    ->middleware(['guest'])
    ->name('password.reset');
