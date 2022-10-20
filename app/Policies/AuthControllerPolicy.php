<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AuthControllerPolicy
{
    use HandlesAuthorization;

    /**
     * @return \Illuminate\Auth\Access\Response
     */
    public function checkIfAuth() : Response
    {
        return !Auth::check()
            ? $this->allow()
            : $this->deny('');
    }
}
