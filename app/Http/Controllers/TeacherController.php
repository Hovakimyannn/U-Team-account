<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TeacherController
{
    public function index(Request $request) : JsonResponse
    {
        $teacher = $request->user('teacher');
        return new JsonResponse([
            'username' => $teacher->firstName,
            'email'    => $teacher->email
        ]);
    }
}
