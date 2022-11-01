<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PasswordController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function send(Request $request) : JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return new JsonResponse($validator->errors(), JsonResponse::HTTP_BAD_REQUEST);
        }

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === 'passwords.user') {
            $status = Password::RESET_LINK_SENT;
        }

        if ($status == Password::RESET_LINK_SENT) {
            return new JsonResponse(['message' => trans($status)], JsonResponse::HTTP_OK);
        }

        return new JsonResponse(['message' => trans($status)], JsonResponse::HTTP_UNAUTHORIZED);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function reset(Request $request) : JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'token'    => 'required',
            'email'    => 'required|exists:password_resets,email',
            'password' => 'required|confirmed',
        ]);

        if ($validator->fails()) {
            return new JsonResponse($validator->errors(), JsonResponse::HTTP_BAD_REQUEST);
        }

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
