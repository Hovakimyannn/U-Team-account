<?php

namespace App\Services\CustomPasswordBrokerManager;

use App\Models\Admin;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Auth\Passwords\PasswordBroker as PassBroker;
use Illuminate\Auth\Passwords\TokenRepositoryInterface;
use Illuminate\Contracts\Auth\UserProvider;

class PasswordBroker extends PassBroker
{

    public function __construct(
        TokenRepositoryInterface $tokens,
        UserProvider $users
    )
    {
        parent::__construct($tokens,$users);
    }

    public function getUser(array $credentials)
    {
         return Admin::where('email', $credentials['email'])->first() ??
                Student::where('email', $credentials['email'])->first() ??
                Teacher::where('email', $credentials['email'])->first();
    }
}