<?php

namespace App\Http\Controllers;

use Faker\Provider\Image;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
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

        $avatar =  $request->file('avatar');

        $globalPath = "public/avatars";
       $fileName = Storage::put($globalPath, $avatar);
       $avatarName = basename($fileName);

        $user = Auth::user();

        if ($user->avatar) {
            Storage::delete($globalPath . '/' . $user->avatar);
        }

        $user->avatar = $avatarName;
        $user->save();

        $path = Storage::path($avatarName);
        return new JsonResponse($path,JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function show() : Response
    {
        $avatar = Auth::user()->avatar;
        $imagePath = storage_path('app/public/avatars/' . $avatar);
        $image = File::get($imagePath);
        $mimeType = File::mimeType($imagePath);
       return \response($image, 200)->header('Content-Type',$mimeType);
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
        $globalPath = "public/avatars/";
        $avatar = Auth::user()->avatar;
        if(Storage::exists($globalPath . $avatar)) {
            Storage::delete($globalPath . $avatar);
        }
        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
