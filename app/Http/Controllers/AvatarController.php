<?php

namespace App\Http\Controllers;

use App\Services\ThumbnailGenerator\ImageThumbnailGenerator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AvatarController extends Controller
{
    protected ImageThumbnailGenerator $imageThumbnailGenerator;

    /**
     * @param \App\Services\ThumbnailGenerator\ImageThumbnailGenerator $imageThumbnailGenerator\
     */
    public function __construct(ImageThumbnailGenerator $imageThumbnailGenerator) {
        $this->imageThumbnailGenerator = $imageThumbnailGenerator;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $this->validate($request, [
            'avatar' => ['required', 'mimes:jpeg,png,jpg'],
        ]);

        $user = Auth::user();

        if (!Storage::disk('avatar')->exists('thumbnail')){
            Storage::disk('avatar')->makeDirectory('thumbnail');
        }

        if (($avatar = $request->file('avatar')) != null && $user->avatar != null) {
            Storage::disk('avatar')->delete($user->avatar);
            Storage::disk('avatar')->delete('thumbnail/' . $user->thumbnail);
        }

        //Store Avatar picture
        $avatarFile = $avatar->store('/', 'avatar');

        //generate avatars thumbnail
        $thumbnail = $this->imageThumbnailGenerator->makeImage($avatar);
        $this->imageThumbnailGenerator->imageResizer(50, 50, $thumbnail);

        $filename = hash('sha256', $thumbnail->filename).'.'.$avatar->extension();
        $thumbnail->save(storage_path('app/avatar/thumbnail/'.$filename));

        $user->avatar = $avatarFile;
        $user->thumbnail = $filename;
        $user->save();

        $path = Storage::url('avatar/'.$avatarFile);

        return new JsonResponse(asset($path), JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show() : JsonResponse
    {
        $avatar = Auth::user()->avatar;
        $path = Storage::url('avatar/'.$avatar);

        return new JsonResponse(asset($path), JsonResponse::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return JsonResponse
     */
    public function destroy() : JsonResponse
    {
        $avatar = Auth::user()->avatar;
        if (Storage::exists('avatar'.'/'.$avatar)) {
            Storage::disk('avatar')->delete($avatar);
        }
        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
