<?php

namespace App\Services\CustomPasswordBrokerManager;

use App\Models\Admin;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Auth\Passwords\PasswordBroker as PassBroker;
use Illuminate\Database\Eloquent\Model;

class PasswordBroker extends PassBroker
{
    /**
     * @param array $credentials
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getUser(array $credentials) : Model
    {
         return Admin::where('email', $credentials['email'])->first() ??
                Student::where('email', $credentials['email'])->first() ??
                Teacher::where('email', $credentials['email'])->first();
    }
}