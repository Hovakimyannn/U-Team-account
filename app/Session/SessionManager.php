<?php

namespace App\Session;

use Illuminate\Session\SessionManager as BaseSessionManager;
use Illuminate\Session\Store;

class SessionManager extends BaseSessionManager
{
    /**
     * Create an instance of the database session driver.
     *
     * @return \Illuminate\Session\Store
     */
    protected function createDatabaseDriver() : Store
    {
        $table = $this->config->get('session.table');

        $lifetime = $this->config->get('session.lifetime');

        return $this->buildSession(new DatabaseSessionHandler(
            $this->getDatabaseConnection(), $table, $lifetime, $this->container
        ));
    }
}
