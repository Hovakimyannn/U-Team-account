<?php

namespace App\Http\Controllers;

use App\Events\ScheduleCreatedEvent;
use App\Models\Group;
use App\Models\Schedule;
use App\Repositories\ScheduleRepository;
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
     * @var \App\Repositories\ScheduleRepository
     */
    protected ScheduleRepository $scheduleRepository;

    /**
     * @param \App\Repositories\ScheduleRepository $scheduleRepository
     */
    public function __construct(ScheduleRepository $scheduleRepository)
    {
        $this->scheduleRepository = $scheduleRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() : JsonResponse
    {
        return new JsonResponse($this->scheduleRepository->findAll(), JsonResponse::HTTP_OK);
    }
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

        $data = [
            'userId'   => $userId,
            'courseId' => $courseId,
            'groupId'  => $groupId,
        ];

        if (File::exists($path)) {
            if (!empty($userId) && 'teacher' === $role) {
                $teacherSchedule = Schedule::where('user_id', '=', $userId)->first();
                $this->destroy($teacherSchedule->id);
            } else {
                $studentSchedule = Schedule::where('course_id', '=', $courseId)
                    ->where('group_id', '=', $groupId)
                    ->first();
                $this->destroy($studentSchedule->id);
            }
        }

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

        event(new ScheduleCreatedEvent($data, asset($storagePath)));

        return new JsonResponse($storagePath, JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $groupId) : JsonResponse // changeThis
    {

        $schedule = Group::where('id', $groupId)->first()->course_id;


        return new JsonResponse($schedule,JsonResponse::HTTP_OK);
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
        $schedule = $this->scheduleRepository->find($id);

        $path = $schedule->path;
        $explodesPath = explode('/', $path);
        $path = implode('/', array_slice($explodesPath, 3));

        //delete from storage
        Storage::disk('schedule')->delete($path);
        //delete from model
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
