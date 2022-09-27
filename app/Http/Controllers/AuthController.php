<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\FileManager\ExcelFileManager;
use App\Services\FileManager\FileManagerVisitor;
use App\Visitors\FileConverterVisitor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
        $token = Auth::attempt($credentials);

        if (!$token) {
            return new JsonResponse([
                'status'  => 'error',
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = Auth::user();

        return new JsonResponse([
            'status'        => 'success',
            'user'          => $user,
            'authorisation' => [
                'token' => $token,
                'type'  => 'bearer',
            ]
        ]);
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

//    public function register(Request $userData) : bool
//    {
//        $validator = Validator::make($userData, [
//            'firstName'  => 'required|string|max:255',
//            'lastName'   => 'required|string|max:255',
//            'fatherName' => 'required|string|max:255',
//            'role'       => 'required|string|max:255',
//            'email'      => 'required|string|email|max:255|unique:users',
//            'password'   => 'required|string|min:6',
//        ]);
//
//        if ($validator->fails()) {
//            return false;
//        }
//
//        $user = new User();
//        $user->firstName = $userData['firstName'];
//        $user->lastName = $userData['lastName'];
//        $user->fatherName = $userData['fatherName'];
//        $user->email = $userData['email'];
//        $user->password = Hash::make($userData['password']);
//        $user->assignRole($userData['role']);
//        $user->save();
//
//
//        return true;
//    }

    public function register(array $userData) : bool
    {
        $validator = Validator::make($userData, [
            'firstName'  => 'required|string|max:255',
            'lastName'   => 'required|string|max:255',
            'fatherName' => 'required|string|max:255',
            'role'       => 'required|string|max:255',
            'email'      => 'required|string|email|max:255|unique:users',
            'password'   => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return false;
        }

        $user = new User();
        $user->firstName = $userData['firstName'];
        $user->lastName = $userData['lastName'];
        $user->fatherName = $userData['fatherName'];
        $user->email = $userData['email'];
        $user->password = Hash::make($userData['password']);
        $user->assignRole($userData['role']);
        $user->save();

        return true;
    }

    public function logout() : JsonResponse
    {
        Auth::logout();

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
