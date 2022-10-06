<?php

namespace App\Http\Controllers;

use App\Models\Subgroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubgroupController extends Controller
{

    public function create(mixed $request) {
     /*   $validator = Validator::make($request, [
            'number' => 'numeric|min:3',
        ]);

        if($validator->failed()) {
            return false;
        }*/


        if(!($subgroup = Subgroup::where('number', $request->subgroup)->first())) {
            $subgroup = new Subgroup();
            $subgroup->number = $request->subgroup;
            $subgroup->save();
        }

        return $subgroup;
    }

    public function read() {}
    public function update() {}
    public function delete() {}
}
