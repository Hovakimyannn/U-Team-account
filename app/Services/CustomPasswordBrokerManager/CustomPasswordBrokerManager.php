<?php

namespace App\Services\CustomPasswordBrokerManager;


use App\Services\Auth\MultiUserProvider;
use Illuminate\Auth\Passwords\PasswordBrokerManager;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use InvalidArgumentException;

class CustomPasswordBrokerManager extends PasswordBrokerManager
{
    /**
     * @param $app
     */
    public function __construct(
        $app,
    )
    {
        parent::__construct($app);
    }

    /**
     * @param $name
     *
     * @return \App\Services\CustomPasswordBrokerManager\PasswordBroker
     */
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
           new MultiUserProvider(app('hash')),
        );
    }
}