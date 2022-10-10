<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AdminController
{
    public function dashboard(Request $request) : JsonResponse
    {
       $admin = $request->user('admin');
        return new JsonResponse([
            'username' => $admin->firstName,
            'email'    => $admin->email
        ]);
    }
}
