<?php

namespace App\Http\Controllers;

use App\Events\ScheduleCreatedEvent;
use App\Models\Group;
use App\Models\Schedule;
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
            'role' => ['required', 'string'],  //Create new Enum for userRole
            'userId' => ['exists:teachers,id', 'int'],
            'courseId' => ['exists:courses,id', 'int'],
            'groupId'  => [ 'int','exists:groups,id', Rule::requiredIf(fn() => Group::where('course_id', $request->get('courseId'))->get()->isNotEmpty())],
        ]);

        $scheduleFile = $request->file('schedule');
        $courseId = $request->get('courseId');
        $groupId = $request->get('groupId');
        $userId = $request->get('userId');
        $role = $request->get('role');

        $subPath = sprintf('%s/%s/%s',
            $role,
            $courseId,
            $groupId,
        );

        if(!empty($request->get('userId')) && $request->get('role') === 'teacher'){ // check this to enum
            $subPath = sprintf('%s/%s',
                $role,
                $userId,
            );
        }

        $path = Storage::path(
            sprintf('schedule/%s', $subPath)
        );

//        change this
//        if (File::exists($path)) {
//            dd($path);
//            $a = Schedule::find($path);
//            dd($a);
//            $this->destroy($courseId, $groupId);
//        }

        $scheduleFile->store($subPath, 'schedule');
        $filename = $this->getFileName($path);
        $path = $this->convertToJson($path, $filename);
        $storagePath = Storage::url(str_replace(storage_path().'/app/', '', $path));

        $schedule = new Schedule();
        $schedule->role = $role;
        $schedule->userId = $userId;
        $schedule->courseId = $courseId;
        $schedule->groupId = $groupId;
        $schedule->path = $storagePath;

        $schedule->save();

//        event(new ScheduleCreatedEvent($courseId, $groupId, asset($storagePath)));

        return new JsonResponse($storagePath, JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $courseId, int $groupId) : JsonResponse // changeThis
    {
        $path = Storage::path( 'schedule' . '/' . $courseId . '/' . $groupId);
        $filename = $this->getFileName(Storage::path('schedule') . "/$courseId/$groupId");

        return new JsonResponse($path . '/' . $filename ,JsonResponse::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $courseId
     * @param int $groupId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id) : JsonResponse
    {
        //Look this
        $schedule = Schedule::findOrFail($id);

        $path = $schedule->path;
        $explodesPath = explode('/', $path);
        $teacherPath = implode('/', array_slice($explodesPath, 3));

        Storage::disk('schedule')->delete($teacherPath);
        $schedule->delete();

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
