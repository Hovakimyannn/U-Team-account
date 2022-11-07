<?php

namespace App\Providers;

use App\Services\Auth\MultiGuard;
use App\Services\Auth\MultiUserProvider;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

//use App\Policies\AuthControllerPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
//        AuthController::class => AuthControllerPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
      /*  Auth::provider('multiUser', function (Application $app, array $config) {
            return new MultiUserProvider($app['hash']);
        });*/

        Auth::extend('multi', function (Application $app, $name, array $config) {
            return new MultiGuard(
                $name,
                new MultiUserProvider($app['hash']),
                $this->app['session.store']
            );
        });
    }
}
