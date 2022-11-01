<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Repositories\TeacherRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
    public function getAll() : JsonResponse
    {
       return new JsonResponse($this->teacherRepository->findAll(), JsonResponse::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
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
            'birthDate'  => 'required|date',
            'email'      => 'required|email|unique:students,email',
            'password'   => 'required|confirmed|min:5',
            'position'   => 'required'
        ]);

        if ($validator->fails())
        {
            return new JsonResponse($validator->errors(), JsonResponse::HTTP_BAD_REQUEST);
        }

        $teacher = new Teacher();
        $teacher->firstName = $request->get('firstName');
        $teacher->lastName = $request->get('lastName');
        $teacher->patronymic = $request->get('patronymic');
        $teacher->birthDate = $request->get('birthDate');
        $teacher->email = $request->get('email');
        $teacher->position = $request->get('position');
        $teacher->password = Hash::make($request->get('password'));

        $teacher->department()->associate($request->get('department_id'));
        $teacher->save();

        return new JsonResponse($teacher, JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id) : JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'firstName'  => 'string|max:255',
            'lastName'   => 'string|max:255',
            'patronymic' => 'string|max:255',
            'birthDate'  => 'date',
            'email'      => 'email|unique:students,email',
        ]);

        if($validator->fails())
        {
            return new JsonResponse($validator->errors(), JsonResponse::HTTP_BAD_REQUEST);
        }

        $teacher = $this->teacherRepository->find($id);

        $teacher->firstName = $request->get('firstName') ?? $teacher->firstName;
        $teacher->lastName = $request->get('lastName') ?? $teacher->lastName;
        $teacher->patronymic = $request->get('patronymic') ?? $teacher->patronymic;
        $teacher->birthDate = $request->get('birthDate') ?? $teacher->birthDate;
        $teacher->email = $request->get('email') ?? $teacher->email;
        $teacher->position = $request->get('position') ?? $teacher->position;

        $teacher->save();

        return new JsonResponse($teacher, JsonResponse::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
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
