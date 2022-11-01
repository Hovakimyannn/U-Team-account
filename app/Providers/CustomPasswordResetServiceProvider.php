<?php

namespace App\Providers;

use App\Services\CustomPasswordBrokerManager\CustomPasswordBrokerManager;
use Illuminate\Auth\Passwords\PasswordResetServiceProvider;

class CustomPasswordResetServiceProvider extends PasswordResetServiceProvider
{

    protected function registerPasswordBroker()
    {
        $this->app->singleton('auth.password', function ($app) {
            return new CustomPasswordBrokerManager($app);
        });

        $this->app->bind('auth.password.broker', function ($app) {
            return $app->make('auth.password')->broker();
        });
    }
}