<?php

namespace App\Http\Controllers\Traits;

use App\Mail\Invitation;
use App\Notifications\Invite as BaseInvite;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
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
//
//    /**
//     * @param $email
//     * @param $url
//     * @param $name
//     *
//     * @return void
//     */
//    protected function sendMail($email, $url, $name)
//    {
//        Notification::route('mail', $email)
//            ->notify(new BaseInvite($url));
//    }
    /**
     * @param $email
     * @param $name
     * @param $invitationLink
     *
     * @return void
     */
    public function sendUserInvitation($email, $name, $invitationLink): void {
        Mail::to($email)->send(new Invitation($name, $invitationLink));
    }
}
