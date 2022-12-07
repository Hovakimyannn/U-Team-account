<?php

namespace App\Services\CustomPasswordBrokerManager;

use App\Models\Admin;
use App\Models\Student;
use App\Models\Teacher;
use App\Repositories\ResetPasswordRepository;
use App\Services\Auth\MultiUserProvider;
use Illuminate\Auth\Passwords\PasswordBrokerManager;
use InvalidArgumentException;

class CustomPasswordBrokerManager extends PasswordBrokerManager
{
    /**
     * @param $name
     *
     * @return \App\Services\CustomPasswordBrokerManager\PasswordBroker
     */
    protected function resolve($name) : PasswordBroker
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
            new ResetPasswordRepository(new Admin(), new Student(), new Teacher())
        );
    }
}
