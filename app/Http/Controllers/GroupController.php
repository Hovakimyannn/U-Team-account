<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Repositories\GroupRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * @var \App\Repositories\GroupRepository
     */
    protected GroupRepository $groupRepository;

    /**
     * @param \App\Repositories\GroupRepository $groupRepository
     */
    public function __construct(GroupRepository $groupRepository)
    {
        $this->groupRepository = $groupRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAll() : JsonResponse
    {
        return new JsonResponse($this->groupRepository->findAll(), JsonResponse::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(Request $request) : JsonResponse
    {
        $this->validate($request, [
            'number'    => ['required', 'int', 'min:3'],
            'parent_id' => ['int', 'exists:groups,id'],
            'course_id' => ['required', 'int', 'exists:courses,id'],
        ]);

        $group = new Group();
        $group->number = $request->get('number');
        $group->parentId = $request->get('parentId');
        $group->course()->associate($request->get('courseId'));
        $group->save();

        return new JsonResponse($group, JsonResponse::HTTP_CREATED);
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
        return new JsonResponse($this->groupRepository->find($id), JsonResponse::HTTP_OK);
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
            'number'    => ['int', 'min:3'],
            'parent_id' => ['int', 'exists:groups,id'],
            'course_id' => ['int', 'exists:courses,id'],
        ]);

        /** @var \App\Models\Group $group */
        $group = $this->groupRepository->find($id);
        $group->number = $request->get('number', $group->number);
        $group->parentId = $request->get('parentId', $group->parentId);
        $group->save();

        return new JsonResponse($group, JsonResponse::HTTP_OK);
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
        $group = $this->groupRepository->find($id);
        $group->delete();

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStudents(int $id) : JsonResponse
    {
        return new JsonResponse(
            $this->groupRepository->getRelatedModels($id, 'students'),
            JsonResponse::HTTP_OK
        );
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTeachers(int $id) : JsonResponse
    {
        return new JsonResponse(
            $this->groupRepository->getRelatedModels($id, 'teachers'),
            JsonResponse::HTTP_OK
        );
    }
}
