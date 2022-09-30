<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\SubGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GroupController extends Controller
{
    /**
     * @var SubGroup $subGroup
     */
    public SubGroup $subGroup;

    /**
     * @param $request
     *
     * @return mixed
     */
    public function create(mixed $request)
    {
      /*  $validator = Validator::make($request, [
            'number' => 'numeric|min:3',
        ]);

        if ($validator->failed()) {
            return false;
        }*/


        if(!($group = Group::where('number', $request->group)->first())) {
            $group = new Group();
            $group->number = $request->group;
            $group->save();
        }

        return $group;
    }

    public function update(){}
    public function read() {}
    public function delete(){}

}
