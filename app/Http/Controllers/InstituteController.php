<?php

namespace App\Http\Controllers;

use App\Models\Institute;
use App\Repositories\InstituteRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InstituteController extends Controller
{
    /**
     * @var \App\Repositories\InstituteRepository
     */
    protected InstituteRepository $instituteRepository;

    /**
     * @param \App\Repositories\InstituteRepository $instituteRepository
     */
    public function __construct(InstituteRepository $instituteRepository)
    {
        $this->instituteRepository = $instituteRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() : JsonResponse
    {
        return new JsonResponse($this->instituteRepository->findAll());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(Request $request) : JsonResponse
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255']
        ]);

        $institute = new Institute();
        $institute->name = $request->get('name');
        $institute->save();

        return new JsonResponse($institute, JsonResponse::HTTP_CREATED);
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
        return new JsonResponse($this->instituteRepository->find($id));
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
            'name' => ['string', 'max:255']
        ]);

        /** @type  Institute $institute */
        $institute = $this->instituteRepository->find($id);
        $institute->name = $request->get('name', $institute->name);
        $institute->save();

        return new JsonResponse($institute);
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
        $institute = $this->instituteRepository->find($id);
        $institute->delete();

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDepartments(int $id) : JsonResponse
    {
       return new JsonResponse(
           $this->instituteRepository->getRelatedModels($id, 'departments'),
           JsonResponse::HTTP_OK
       );
    }
}
