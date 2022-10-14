<?php

namespace App\Services\SessionProvider;

use Illuminate\Support\Facades\Session;

class SessionProvider
{
    /**
     * return role || empty string
     *
     * @return string
     */
    public function getUserRole() : string
    {
        $sessionData = Session::all();

        foreach ($sessionData as $key => $sessionDatum) {
            if (preg_match("/(?<=_)student|teacher|admin(?=_)/", $key, $role)) {
                break;
            }
        }

        return $role[0] ?? '';
    }
}
