<?php

namespace App\Providers;

use Illuminate\Contracts\Cache\Factory as CacheFactory;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Session\SessionServiceProvider as BaseSessionServiceProvider;

class SessionServiceProvider extends BaseSessionServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

    }
}
