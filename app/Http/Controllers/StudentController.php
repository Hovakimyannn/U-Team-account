<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Repositories\StudentRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use stdClass;

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
    public function index(): JsonResponse
    {
        return new JsonResponse($this->studentRepository->findAll(), JsonResponse::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        return new JsonResponse($this->studentRepository->find($id), JsonResponse::HTTP_OK);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function department(Request $request): JsonResponse
    {
        return new JsonResponse($request->user()->department, JsonResponse::HTTP_OK);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function course(Request $request): JsonResponse
    {
        return new JsonResponse($request->user()->course, JsonResponse::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \stdClass $invitation
     *
     * @return \App\Models\Student
     */
    public static function create(stdClass $invitation): Student
    {
        $student = new Student();
        $student->firstName = $invitation->firstName;
        $student->lastName = $invitation->lastName;
        $student->patronymic = $invitation->patronymic;
        $student->birthDate = $invitation->birthDate;
        $student->email = $invitation->email;
        $student->password = Hash::make($invitation->password);
        $student->department()->associate($invitation->departmentId);
        $student->course()->associate($invitation->courseId);
        $student->save();

        if (isset($invitation->groupId)) {
            $student->groups()->sync($invitation->groupId);
        }

        return $student;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $this->validate($request, [
            'firstName' => ['string', 'max:255'],
            'lastName' => ['string', 'max:255'],
            'patronymic' => ['string', 'max:255'],
            'birthDate' => ['date'],
            'email' => ['email', 'unique:students,email'],
            'department_id' => ['int', 'exists:departments,id'],
            'course_id' => ['int', 'exists:courses,id']
        ]);

        /** @var \App\Models\Student $student */
        $student = $this->studentRepository->find($id);
        $student->firstName = $request->get('firstName', $student->firstName);
        $student->lastName = $request->get('lastName', $student->lastName);
        $student->patronymic = $request->get('patronymic', $student->patronymic);
        $student->birthDate = $request->get('birthDate', $student->birthDate);
        $student->email = $request->get('email', $student->email);
        $student->save();

        return new JsonResponse($student, JsonResponse::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $student = $this->studentRepository->find($id);
        $student->delete();

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
