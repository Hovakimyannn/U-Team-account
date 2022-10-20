<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Repositories\StudentRepository;
use App\Services\FileManager\ExcelFileManager;
use App\Services\FileManager\FileManagerVisitor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    protected StudentRepository $studentRepository;

    public function __construct(StudentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    public function getCurrentUser(Request $request) : JsonResponse
    {
        if ($user = $request->user()) {
            return new JsonResponse([
                'status' => 'success',
                'user'   => [
                    'data' => [
                        array_merge(
                            $user->toArray(),
//                            $this->studentRepository->getCourseNumber($user->id),
//                            $this->studentRepository->getGroupName($user->id)
                        )
                    ],
                ],
            ], Response::HTTP_OK);
        }

        return new JsonResponse([
            'status'  => 'error',
            'message' => 'Unauthorized'
        ], Response::HTTP_UNAUTHORIZED);
    }


    public function login(Request $request) : JsonResponse
    {
        if (Auth::check())
        {
            $this->authorize('check-if-auth',[self::class]);
        }

        $request->validate([
            'email'    => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            return new JsonResponse([
                'status' => 'success',
                'user'   => [
                    'data' => [
                        array_merge(
                            $user->toArray(),
//                            $this->studentRepository->getCourseNumber($user->id),
//                            $this->studentRepository->getGroupName($user->id)
                        )
                    ],
                ],
            ], Response::HTTP_OK);
        }


        return new JsonResponse([
            'status'  => 'error',
            'message' => 'Unauthorized'
        ], Response::HTTP_UNAUTHORIZED);
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

    public function register(mixed $userData) : Admin
    {
        $user = new Admin();
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
}
