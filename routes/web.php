<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\InvitationController;
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

        Route::post('/accept/invitation', 'acceptInvitation');
    });

Route::post('/forgot-password', [PasswordController::class, 'send'])
    ->middleware(['guest'])
    ->name('password.forgot');

Route::post('/reset-password', [PasswordController::class, 'reset'])
    ->middleware(['guest'])
    ->name('password.reset');
