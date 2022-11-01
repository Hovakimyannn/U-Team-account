<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Repositories\AdminRepository;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    /**
     * @var \App\Repositories\AdminRepository
     */
    protected AdminRepository $adminRepository;

    /**
     * @param \App\Repositories\AdminRepository $adminRepository
     */
    public function __construct(AdminRepository $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAll() : JsonResponse
    {
        return new JsonResponse($this->adminRepository->findAll(), JsonResponse::HTTP_OK);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request) : JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'firstName'  => 'required|string|max:255',
            'lastName'   => 'required|string|max:255',
            'patronymic' => 'required|string|max:255',
            'email'      => 'required|email|unique:students,email',
            'password'   => 'required|confirmed|min:5'
        ]);

        if($validator->fails())
        {
            return new JsonResponse($validator->errors(), JsonResponse::HTTP_BAD_REQUEST);
        }

        $admin = new Admin();
        $admin->firstName = $request->get('firstName');
        $admin->lastName = $request->get('lastName');
        $admin->patronymic = $request->get('patronymic');
        $admin->email = $request->get('email');
        $admin->password = Hash::make($request->get('password'));

        $admin->save();

        return new JsonResponse($admin, JsonResponse::HTTP_CREATED);
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
        return new JsonResponse($this->adminRepository->find($id), JsonResponse::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id) : JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'firstName'  => 'string|max:255',
            'lastName'   => 'string|max:255',
            'patronymic' => 'string|max:255',
            'email'      => 'email|unique:students,email',
        ]);

        if($validator->fails())
        {
            return new JsonResponse($validator->errors(), JsonResponse::HTTP_BAD_REQUEST);
        }

        $admin = $this->adminRepository->find($id);

        $admin->firstName = $request->get('firstName') ?? $admin->firstName;
        $admin->lastName = $request->get('lastName') ?? $admin->lastName;
        $admin->patronymic = $request->get('patronymic') ?? $admin->patronymic;
        $admin->email = $request->get('email') ?? $admin->email;

        $admin->save();

        return new JsonResponse($admin, JsonResponse::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id) : JsonResponse
    {
        $admin = $this->adminRepository->find($id);
        $admin->delete();

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
