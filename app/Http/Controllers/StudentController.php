<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StudentController
{
    public function index(Request $request) : JsonResponse
    {
        $student = $request->user('student');
        return new JsonResponse([
            'username' => $student->firstName,
            'email'    => $student->email
        ]);
    }
}
