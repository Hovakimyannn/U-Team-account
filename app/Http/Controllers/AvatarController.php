<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AvatarController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request) : JsonResponse
    {
        $this->validate($request, [
            'avatar' => ['required', 'mimes:jpeg,png,jpg'],
        ]);

        $user = Auth::user();

        if (($avatar = $request->file('avatar')) != null && $user->avatar != null) {
            Storage::disk('avatar')->delete($user->avatar);
        }

        $avatarName = $avatar->store('/', 'avatar');

        $user->avatar = $avatarName;
        $user->save();

        $path = Storage::path('avatar' . '/'.$avatarName);

        return new JsonResponse($path,JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show() : JsonResponse
    {
        $avatar = Auth::user()->avatar;
        $path = Storage::path('avatar' . '/' . $avatar);

        return new JsonResponse($path, JsonResponse::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     *
     * @return JsonResponse
     */
    public function destroy() : JsonResponse
    {
        $avatar = Auth::user()->avatar;
        if(Storage::exists('avatar' . '/' . $avatar)) {
            Storage::disk('avatar')->delete($avatar);
        }
        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
