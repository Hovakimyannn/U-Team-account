<?php

namespace App\Http\Controllers;

use App\Enums\CourseDegreeEnum;
use App\Enums\CourseTypeEnum;
use App\Models\Course;
use App\Repositories\CourseRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class CourseController extends Controller
{
    /**
     * @var \App\Repositories\CourseRepository
     */
    protected CourseRepository $courseRepository;

    /**
     * @param \App\Repositories\CourseRepository $courseRepository
     */
    public function __construct(CourseRepository $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index() : JsonResponse
    {
        $this->authorize('index', Course::class);

        return new JsonResponse($this->courseRepository->findAll(), JsonResponse::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Request $request) : JsonResponse
    {
        $this->authorize('create', Course::class);

        $this->validate($request, [
            'number'        => ['required', 'string', 'min:3'],
            'degree'        => [new Enum(CourseDegreeEnum::class), 'required', 'string'],
            'type'          => [new Enum(CourseTypeEnum::class), 'required', 'string'],
            'department_id' => ['required', 'exists:departments,id'],
        ]);

        $course = new Course();
        $course->number = $request->get('number');
        $course->degree = $request->get('degree');
        $course->type = $request->get('type');
        $course->department()->associate($request->get('department_id'));
        $course->save();

        return new JsonResponse($course, JsonResponse::HTTP_CREATED);
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(int $id) : JsonResponse
    {
        $this->authorize('show', Course::class);

        return new JsonResponse($this->courseRepository->find($id), JsonResponse::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, int $id) : JsonResponse
    {
        $this->authorize('update', Course::class);

        $this->validate($request, [
            'number'        => ['string', 'min:3'],
            'degree'        => [new Enum(CourseDegreeEnum::class), 'string'],
            'type'          => [new Enum(CourseTypeEnum::class), 'string'],
            'department_id' => ['exists:departments,id'],
        ]);

        /** @var \App\Models\Course $course */
        $course = $this->courseRepository->find($id);
        $course->number = $request->get('number', $course->number);
        $course->degree = $request->get('degree', $course->degree);
        $course->type = $request->get('type', $course->type);
        $course->save();

        return new JsonResponse($course, JsonResponse::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(int $id) : JsonResponse
    {
        $this->authorize('destroy', Course::class);

        $course = $this->courseRepository->find($id);
        $course->delete();

        return new JsonResponse('deleted', JsonResponse::HTTP_NO_CONTENT);
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getGroups(int $id) : JsonResponse
    {
        $this->authorize('getGroups', Course::class);

        return new JsonResponse(
            $this->courseRepository->getRelatedModels($id, 'groups'),
            JsonResponse::HTTP_OK
        );
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getStudents(int $id) : JsonResponse
    {
        $this->authorize('getStudents', Course::class);

        return new JsonResponse(
            $this->courseRepository->getRelatedModels($id, 'students'),
            JsonResponse::HTTP_OK
        );
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getTeachers(int $id) : JsonResponse
    {
        $this->authorize('getTeachers', Course::class);

        return new JsonResponse(
            $this->courseRepository->getRelatedModels($id, 'teachers'),
            JsonResponse::HTTP_OK
        );
    }
}
