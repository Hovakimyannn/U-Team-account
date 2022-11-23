<?php

namespace App\Providers;

use App\Models\Admin;
use App\Models\Student;
use App\Models\Teacher;
use App\Services\Auth\MultiGuard;
use App\Services\Auth\MultiUserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot() : void
    {
        $this->registerPolicies();

        Auth::extend('multi', function (Application $app, $name, array $config) {
            return new MultiGuard(
                $name,
                new MultiUserProvider($app['hash']),
                $this->app['session.store']
            );
        });

        Gate::define('is_admin', function (Authenticatable $user) {
            return $user::class === Admin::class;
        });

        Gate::define('is_student', function (Authenticatable $user) {
            return $user::class === Student::class;
        });

        Gate::define('is_teacher', function (Authenticatable $user) {
            return $user::class === Teacher::class;
        });
    }
}
