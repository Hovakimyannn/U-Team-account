<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class RoleController
{

    public function create(mixed $request)
    {
//        $validator = Validator::make($request, [
//            'name' => 'required|string|max:100'
//        ]);
//
//        if ($validator->fails()) {
//            return false;
//        }

        $role = new Role();

        if(!(Role::where('name', $request->role)->first())) {
            $role->name = $request->role;
            $role->save();
        }

        return $role;
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
