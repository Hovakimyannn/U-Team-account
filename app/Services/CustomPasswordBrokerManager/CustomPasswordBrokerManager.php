<?php

namespace App\Services\CustomPasswordBrokerManager;


use Illuminate\Auth\Passwords\PasswordBrokerManager;
use InvalidArgumentException;

class CustomPasswordBrokerManager extends PasswordBrokerManager
{
    public function __construct(
        $app
    )
    {
        parent::__construct($app);
    }

    protected function resolve($name)
    {
        $config = $this->getConfig($name);

        if (is_null($config)) {
            throw new InvalidArgumentException("Password resetter [{$name}] is not defined.");
        }

        // The password broker uses a token repository to validate tokens and send user
        // password e-mails, as well as validating that password reset process as an
        // aggregate service of sorts providing a convenient interface for resets.

        return new PasswordBroker(
            $this->createTokenRepository($config),
            $this->app['auth']->createUserProvider($config['provider'] ?? null)
        );
    }
}