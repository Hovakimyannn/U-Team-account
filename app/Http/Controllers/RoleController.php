<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoleController
{
    public function create(Request $request) : JsonResponse
    {
        $role = new Role();
        $role->name = $request->name;
        $role->save();

        return new JsonResponse([
            'message' => sprintf('Role %s has been created', $role->name),
        ], 204);
    }

    public function read()
    {

    }

    public function update()
    {

    }

    public function delete()
    {

    }
}