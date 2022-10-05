<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\FileManager\ExcelFileManager;
use App\Services\FileManager\FileManagerVisitor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function index(Request $request) : JsonResponse
    {
        $user = $request->user();
        return new JsonResponse([
            'username' => $user->firstName,
            'email'    => $user->email
        ]);
    }

    public function login(Request $request) : JsonResponse
    {
        $request->validate([
            'email'    => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            dd($request->session());
            $user = Auth::user();
            return new JsonResponse([
                'status'        => 'success',
                'user'          => $user,
                'authorisation' => [
                    'accessToken' => $request->session()->token(),
                    'type'        => 'bearer',
                ]
            ]);

        }

        return new JsonResponse([
            'status'  => 'error',
            'message' => 'Unauthorized'
        ], 401);
    }

    public function download(Request $request)
    {
        /**
         * @var \Illuminate\Http\UploadedFile $file
         */
        $file = $request->file;

        $path = Storage::path($file->getClientOriginalName());
        $file->storeAs(null, $file->getClientOriginalName());

        $fileManagerVisitor = new FileManagerVisitor(new ExcelFileManager($path));

        $fileManager = $fileManagerVisitor->visitor;
        $data = $fileManager->read();

        $fileManager->convertToJson($data);
    }

    public function register(mixed $userData)
    {
        $user = new User();
        $user->firstName = $userData->firstName;
        $user->lastName = $userData->lastName;
        $user->fatherName = $userData->fatherName;
        $user->email = $userData->email;
        $user->password = Hash::make($userData->password);
        $user->assignRole($userData->role);
        $user->assignDepartment($userData->department);
        $user->save();

        return $user;
    }

    public function logout(Request $request) : JsonResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return new JsonResponse([
            'status'  => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh() : JsonResponse
    {
        return new JsonResponse([
            'status'        => 'success',
            'user'          => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type'  => 'bearer',
            ]
        ]);
    }

}
