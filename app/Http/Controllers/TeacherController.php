<?php

namespace App\Http\Controllers;

use App\Enums\TeacherPositionEnum;
use App\Repositories\TeacherRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class TeacherController extends Controller
{
    /**
     * @var \App\Repositories\TeacherRepository
     */
    protected TeacherRepository $teacherRepository;

    /**
     * @param \App\Repositories\TeacherRepository $teacherRepository
     */
    public function __construct(TeacherRepository $teacherRepository)
    {
        $this->teacherRepository = $teacherRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() : JsonResponse
    {
        return new JsonResponse($this->teacherRepository->findAll(), JsonResponse::HTTP_OK);
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
        return new JsonResponse($this->teacherRepository->find($id), JsonResponse::HTTP_OK);
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
            'firstName'     => ['string', 'max:255'],
            'lastName'      => ['string', 'max:255'],
            'patronymic'    => ['string', 'max:255'],
            'birthDate'     => ['date'],
            'email'         => ['email', 'unique:students,email'],
            'position'      => [new Enum(TeacherPositionEnum::class), 'string'],
            'department_id' => ['int', 'exists:departments,id'],
        ]);

        /** @var \App\Models\Teacher $teacher */
        $teacher = $this->teacherRepository->find($id);
        $teacher->firstName = $request->get('firstName', $teacher->firstName);
        $teacher->lastName = $request->get('lastName', $teacher->lastName);
        $teacher->patronymic = $request->get('patronymic', $teacher->patronymic);
        $teacher->birthDate = $request->get('birthDate', $teacher->birthDate);
        $teacher->email = $request->get('email', $teacher->email);
        $teacher->position = $request->get('position', $teacher->position);
        $teacher->save();

        return new JsonResponse($teacher, JsonResponse::HTTP_OK);
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
        $teacher = $this->teacherRepository->find($id);
        $teacher->delete();

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
