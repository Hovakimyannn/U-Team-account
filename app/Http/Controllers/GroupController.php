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
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index() : JsonResponse
    {
        $this->authorize('index', Group::class);

        return new JsonResponse($this->groupRepository->findAll(), JsonResponse::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Request $request) : JsonResponse
    {
        $this->authorize('create', Group::class);

        $this->validate($request, [
            'number'    => ['required', 'int', 'min:1'],
            'parent_id' => ['int', 'exists:groups,id'],
            'course_id' => ['required', 'int', 'exists:courses,id'],
        ]);

        $group = new Group();
        $group->number = $request->get('number');
        $group->parentId = $request->get('parent_id');
        $group->course()->associate($request->get('course_id'));
        $group->save();

        return new JsonResponse($group, JsonResponse::HTTP_CREATED);
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
        $this->authorize('show', Group::class);

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
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, int $id) : JsonResponse
    {
        $this->authorize('update', Group::class);

        $this->validate($request, [
            'number'    => ['int', 'min:1'],
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
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(int $id) : JsonResponse
    {
        $this->authorize('destroy', Group::class);

        $group = $this->groupRepository->find($id);
        $group->delete();

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getStudents(int $id) : JsonResponse
    {
        $this->authorize('getStudents', Group::class);

        return new JsonResponse(
            $this->groupRepository->getRelatedModels($id, 'students'),
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
        $this->authorize('getTeachers', Group::class);

        return new JsonResponse(
            $this->groupRepository->getRelatedModels($id, 'teachers'),
            JsonResponse::HTTP_OK
        );
    }

    /**
     * Returned all groups with their courses.
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getCourse() : JsonResponse
    {
        $this->authorize('getCourse', Group::class);
        return new JsonResponse(
            $this->groupRepository->findAllByWith(['course']),
        JsonResponse::HTTP_OK
        );
    }
}
