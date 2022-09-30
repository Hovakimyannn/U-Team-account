<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    public function create(mixed $request)
    {
    /*    $validator = Validator::make($request, [
            'number' => 'required|numeric|min:3',
        ]);

        if ($validator->failed()) {
            return false;
        }*/

        if(!($course = Course::where('number', $request->course)->first())) {
            $course = new Course();
            $course->number = $request->course;
            $course->save();
        }

        return $course;
    }


    public function update(){}
    public function read() {}
    public function delete(){}
}
