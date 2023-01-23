<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Services\FileManager\ExcelFileManager;
use App\Services\FileManager\FileManagerVisitor;
use App\Traits\RecordMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

use function sprintf;
class ScheduleController extends Controller
{
    use RecordMessage;

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request) : JsonResponse
    {
        $this->validate($request,[
            'schedule'  => ['required', 'mimes:xls,xlsx,xlsb,ods'],
            'courseId' => ['required','exists:courses,id', 'int'],
            'groupId'  => [ 'int','exists:groups,id', Rule::requiredIf(fn() => Group::where('course_id', $request->get('courseId'))->get()->isNotEmpty())],
        ]);

        $schedule = $request->file('schedule');
        $courseId = $request->get('courseId');
        $groupId = $request->get('groupId');

        $path = Storage::path(
            sprintf(
                'schedule/%s/%s',
                $request->get('courseId'),
                $request->get('groupId')
            )
        );

        if (File::exists($path)) {
            $this->destroy($courseId, $groupId);
        }

        $schedule->store('/' . $courseId . '/' . $groupId, 'schedule');
        $filename = $this->getFileName($path);
        $path = $this->convertToJson($path, $filename);

        return new JsonResponse($path, JsonResponse::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $courseId, int $groupId) : JsonResponse
    {
        $path = Storage::path( 'schedule' . '/' . $courseId . '/' . $groupId);
        $filename = $this->getFileName(Storage::path('schedule') . "/$courseId/$groupId");

        return new JsonResponse($path . '/' . $filename ,JsonResponse::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $courseId, int $groupId) : JsonResponse
    {
        $filename = $this->getFileName(Storage::path('schedule') . "/$courseId/$groupId");
        Storage::disk('schedule')->delete(sprintf(
            '/%s/%s/%s',
            $courseId,
            $groupId,
            $filename
        ));

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }

    /**
     * Get generated file name
     *
     * @param $globalPath
     *
     * @return string
     */
    private function getFileName($globalPath) : string
    {
        $file = File::files($globalPath);
        $file= array_pop($file);

        return $file->getFilename();
    }

    /**
     * Convert excel file to json file
     *
     * @param $globalPath
     * @param $filename
     *
     * @return string
     */
    private function convertToJson($globalPath, $filename) : string
    {
        $fileManagerVisitor = new FileManagerVisitor(new ExcelFileManager($globalPath . '/' .  $filename));
        $fileManager = $fileManagerVisitor->visit;
        $data =$fileManager->read();
        $fileManager->convertToJson($data);

        return $fileManager->getPath();
    }
}