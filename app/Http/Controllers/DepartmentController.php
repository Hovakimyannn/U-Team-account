<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
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

        $department = new Department();

        if(!(Department::where('name', $request->department)->first())) {
            $department->name = $request->department;
            $department->save();
        }

        return true;
    }


    public function read(){}
    public function update(){}
    public function delete(){}
}
