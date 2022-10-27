<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Repositories\DepartmentRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{
    /**
     * @var \App\Repositories\DepartmentRepository
     */
    protected DepartmentRepository $departmentRepository;

    /**
     * @param \App\Repositories\DepartmentRepository $departmentRepository
     */
    public function __construct(DepartmentRepository $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return new JsonResponse($this->departmentRepository->findAll(), JsonResponse::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255'

        ]);

        if ($validator->fails())
        {
            return new JsonResponse($validator->errors(), JsonResponse::HTTP_BAD_REQUEST);
        }

        $department = new Department();
        $department->name = $request->get('name');

        $department->institute()->associate($request->get('institute_id'));

        $department->save();

        return new JsonResponse($department, JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id) : JsonResponse
    {
        return new JsonResponse($this->departmentRepository->find($id), JsonResponse::HTTP_OK);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request,int  $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|min:3'
        ]);

        if ($validator->fails())
        {
            return new JsonResponse($validator->errors(), JsonResponse::HTTP_BAD_REQUEST);
        }

        $department = $this->departmentRepository->find($id);
        $department->name = $request->get('name');
        $department->save();

        return new JsonResponse($department, JsonResponse::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $department = $this->departmentRepository->find($id);
        $department->delete();

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
