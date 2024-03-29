<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Repositories\AdminRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
    public function index() : JsonResponse
    {
        return new JsonResponse($this->adminRepository->findAll(), JsonResponse::HTTP_OK);
    }

    /**
     * @param \stdClass $invitation
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public static function create(\stdClass $invitation) : JsonResponse
    {
        $admin = new Admin();
        $admin->firstName = $invitation->firstName;
        $admin->lastName = $invitation->lastName;
        $admin->patronymic = $invitation->patronymic;
        $admin->email = $invitation->email;
        $admin->password = Hash::make($invitation->password);
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
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, int $id) : JsonResponse
    {
        $this->validate($request, [
            'firstName'  => ['string', 'max:255'],
            'lastName'   => ['string', 'max:255'],
            'patronymic' => ['string', 'max:255'],
            'email'      => ['email', 'unique:admins,email'],
        ]);

        /** @var \App\Models\Admin $admin */
        $admin = $this->adminRepository->find($id);
        $admin->firstName = $request->get('firstName', $admin->firstName);
        $admin->lastName = $request->get('lastName', $admin->lastName);
        $admin->patronymic = $request->get('patronymic', $admin->patronymic);
        $admin->email = $request->get('email', $admin->email);
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
