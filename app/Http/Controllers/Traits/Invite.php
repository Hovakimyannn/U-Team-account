<?php

namespace App\Http\Controllers\Traits;

use App\Notifications\Invite as BaseInvite;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Notification;

trait Invite
{
    /**
     * @param string $email
     *
     * @return string
     */
    protected function createToken(string $email) : string
    {
        return encrypt(json_encode([
            'expires' => Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60))->timestamp,
            'email'   => $email
        ]));
    }

    /**
     * @param $token
     *
     * @return string
     */
    protected function createUrl($token) : string
    {
        return env('CLIENT_URL')."/accept/invitation?token=$token";
    }

    /**
     * If expire return true
     *
     * @param int $unixTime
     *
     * @return bool
     */
    protected function checkInvitationIsExpire(int $unixTime) : bool
    {
        return Carbon::now()->timestamp > $unixTime;
    }

    /**
     * @param $email
     * @param $url
     *
     * @return void
     */
    protected function sendMail($email, $url)
    {
        Notification::route('mail', $email)
            ->notify(new BaseInvite($url));
    }
}
