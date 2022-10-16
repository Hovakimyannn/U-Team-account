<?php

namespace App\Http\Controllers;

use App\Models\Institute;
use App\Repositories\InstituteRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InstituteController
{
    protected InstituteRepository $repository;

    public function __construct(InstituteRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAll() : JsonResponse
    {
        return new JsonResponse($this->repository->findAll());
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(int $id) : JsonResponse
    {
        return new JsonResponse($this->repository->find($id));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request) : JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $institute = new Institute();
        $institute->name = $request->get('name');

        return new JsonResponse($institute, JsonResponse::HTTP_CREATED);
    }

    /**
     * @param int                      $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(int $id, Request $request) : JsonResponse
    {
        $request->validate([
            'name' => 'nullable|string|max:255'
        ]);

        /** @type  Institute $institute */
        $institute = $this->repository->find($id);
        $institute->name = $request->get('name');
        $institute->save();

        return new JsonResponse($institute);
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(int $id) : JsonResponse
    {
        /** @var Institute $institute */
        $institute = $this->repository->find($id);
        $institute->delete();

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
