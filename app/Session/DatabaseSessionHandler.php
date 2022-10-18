<?php

namespace App\Session;

use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Session\DatabaseSessionHandler as BaseDatabaseSessionHandler;

class DatabaseSessionHandler extends BaseDatabaseSessionHandler
{
    /**
     * Add the user information to the session payload.
     *
     * @param array $payload
     *
     * @return \Illuminate\Session\DatabaseSessionHandler
     */
    protected function addUserInformation(&$payload) : BaseDatabaseSessionHandler
    {
        /** @var AuthManager $authManager */
        $authManager = $this->container->get(AuthManager::class);
        if ($this->container->bound(Guard::class)) {
            $payload['role'] = $authManager->getDefaultDriver();
            $payload['user_id'] = $this->userId();
        }

        return $this;
    }
}
