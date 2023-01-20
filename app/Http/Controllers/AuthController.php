<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Student;
use App\Models\Teacher;
use App\Services\FileManager\ExcelFileManager;
use App\Services\FileManager\FileManagerVisitor;
use App\Traits\RecordMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    use RecordMessage;

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCurrentUser(Request $request) : JsonResponse
    {
        if ($user = $request->user()) {
            $user->role = $this->getCurrentUserRole($user->email);

            return new JsonResponse($user, JsonResponse::HTTP_OK);
        }

        return new JsonResponse([
            'status'  => 'error',
            'message' => 'Unauthorized'
        ], JsonResponse::HTTP_UNAUTHORIZED);
    }

    /**
     * Get current users role
     *
     * @param string $email
     *
     * @return string|null
     */
    private function getCurrentUserRole(string $email) : ?string
    {
        $users = [Student::class, Admin::class, Teacher::class];

        foreach ($users as $user) {
            $model = $user::where('email', $email)->first();
            if ($model != null) {
                return strtolower(last(explode('\\', $user)));
            }
        }
        return null;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param string                   $role
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request, string $role) : JsonResponse
    {
        $this->validate($request, [
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $credentials = array_merge($request->only('email', 'password'), ['role' => $role]);

        if (Auth::attempt($credentials, $request->get('remember'))) {
            $request->session()->regenerate();
            $user = Auth::user();

            return new JsonResponse($user, JsonResponse::HTTP_OK);
        }

        return new JsonResponse([
            'message' => 'Invalid credentials'
        ], JsonResponse::HTTP_UNAUTHORIZED);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function downloadRegistrationFile(Request $request) : JsonResponse
    {
        $this->validate($request, [
            'file' => ['max:500', 'mimes:ods,xls,xlsx,xltx,xlsm,xltm,xlam,xlsb'],
        ]);

        /** @var \Illuminate\Http\UploadedFile $file */
        $file = $request->file;

        $path = Storage::path($file->getClientOriginalName());
        $file->storeAs(null, $file->getClientOriginalName());

        $fileManagerVisitor = new FileManagerVisitor(new ExcelFileManager($path));

        $fileManager = $fileManagerVisitor->visit;
        $data = $fileManager->read();
        $path = $fileManager->getPath();

        $fileManager->convertToJson($data);

        $this->recordMessage($path);

        return new JsonResponse([
            'status' => 'downloaded'
        ], JsonResponse::HTTP_OK);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request) : JsonResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return new JsonResponse('', JsonResponse::HTTP_NO_CONTENT);
    }
}
