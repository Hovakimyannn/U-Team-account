<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Repositories\StudentRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     * @var \App\Repositories\StudentRepository
     */
    protected StudentRepository $studentRepository;

    /**
     * @param \App\Repositories\StudentRepository $studentRepository
     */
    public function __construct(StudentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAll() : JsonResponse
    {
        return new JsonResponse($this->studentRepository->findAll());
    }

    /**
     * Show the form for creating a new resource.
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
            'password'   => 'required|confirmed|min:5'
        ]);

        if ($validator->fails())
        {
            return new JsonResponse($validator->errors(), JsonResponse::HTTP_BAD_REQUEST);
        }

        $student = new Student();
        $student->firstName = $request->get('firstName');
        $student->lastName = $request->get('lastName');
        $student->patronymic = $request->get('patronymic');
        $student->birthDate = $request->get('birthDate');
        $student->email = $request->get('email');
        $student->password = Hash::make($request->get('password'));

        $student->department()->associate($request->get('department_id'));
        $student->course()->associate($request->get('course_id'));

        $student->save();

        return new JsonResponse($student, JsonResponse::HTTP_CREATED);
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
        return new JsonResponse($this->studentRepository->find($id), JsonResponse::HTTP_OK);
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

        $student = $this->studentRepository->find($id);
        $student->firstName = $request->get('firstName') ?? $student->firstName;
        $student->lastName = $request->get('lastName') ?? $student->lastName;
        $student->patronymic = $request->get('patronymic') ?? $student->patronymic;
        $student->birthDate = $request->get('birthDate') ?? $student->birthDate;
        $student->email = $request->get('email') ?? $student->email;

        $student->save();

        return new JsonResponse($student, JsonResponse::HTTP_OK);
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
        $student = $this->studentRepository->find($id);
        $student->delete();

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}