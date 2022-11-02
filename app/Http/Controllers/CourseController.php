<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Repositories\CourseRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
     */
    public function getAll() : JsonResponse
    {
        return new JsonResponse($this->courseRepository->findAll(), JsonResponse::HTTP_OK);
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
        $this->validate($request, [
            'number' => 'required|int|min:3',
            'degree' => 'required|string',
            'type'   =>  'required|string',
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
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id) : JsonResponse
    {
        return new JsonResponse($this->courseRepository->find($id), JsonResponse::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int  $id) : JsonResponse
    {
        $this->validate($request, [
            'number' => 'int|min:3',
            'degree' => 'string',
            'type' => 'string',
        ]);

        $course = $this->courseRepository->find($id);
        $course->number = $request->get('number') ?? $course->number;
        $course->degree = $request->get('degree') ?? $course->degree;
        $course->type = $request->get('type') ?? $course->type;

        $course->save();

        return new JsonResponse($course, JsonResponse::HTTP_OK);
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
        $course = $this->courseRepository->find($id);
        $course->delete();

        return new JsonResponse('deleted', JsonResponse::HTTP_NO_CONTENT);
    }
}
