<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PasswordController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function send(Request $request) : JsonResponse
    {
        $this->validate($request, [
            'email' => ['required', 'email'],
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status == Password::RESET_LINK_SENT) {
            return new JsonResponse(['message' => trans($status)], JsonResponse::HTTP_OK);
        }

        return new JsonResponse(['message' => trans($status)], JsonResponse::HTTP_UNAUTHORIZED);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function reset(Request $request) : JsonResponse
    {
        $this->validate($request, [
            'token'    => ['required'],
            'email'    => ['required', 'exists:password_resets,email'],
            'password' => ['required', 'confirmed'],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'token'),
            function ($user) use ($request) : void {
                $user->forceFill([
                    'password' => Hash::make($request->get('password'))
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return new JsonResponse(['message' => trans($status)], JsonResponse::HTTP_OK);
        }

        return new JsonResponse(['message' => trans($status)], JsonResponse::HTTP_UNAUTHORIZED);
    }
}
