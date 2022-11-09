<?php
//
//namespace App\Http\Controllers;
//
//use App\Models\Course;
//use App\Models\CourseGroupSubgroup;
//use App\Models\Group;
//use App\Models\Student;
//use App\Models\Subgroup;
//use App\Models\Teacher;
//use App\Models\Admin;
//use Illuminate\Support\Facades\Storage;
//
//class Jsoncontroller extends Controller
//{
//    public RoleController $roleController;
//    public DepartmentController $departmentController;
//    public AuthController $authController;
//    public CourseController $courseController;
//    public GroupController $groupController;
//    public SubgroupController $subgroupController;
//    public Student $student;
//    public Teacher $teacher;
//
//    public function __construct(
//        RoleController $roleController,
//        DepartmentController $departmentController,
//        AuthController $authController,
//        GroupController $groupController,
//        SubgroupController $subgroupController,
//        CourseController $courseController,
//        Student $student,
//        Teacher $teacher,
//    )
//    {
//        $this->roleController = $roleController;
//        $this->departmentController = $departmentController;
//        $this->authController = $authController;
//        $this->groupController = $groupController;
//        $this->subgroupController = $subgroupController;
//        $this->courseController = $courseController;
//        $this->student = $student;
//        $this->teacher = $teacher;
//    }
//
//    public function store()
//    {
//        $data = Storage::get('users.json');
//        $data = json_decode($data);
//
//        foreach ($data as $d) {
//            $role = $this->roleController->create($d);
//            $this->departmentController->create($d);
//            $user = $this->authController->register($d);
//            $group = $this->groupController->create($d);
//            $subgroup =  $this->subgroupController->create($d);
//            $course = $this->courseController->create($d);
//            if(!($a = CourseGroupSubgroup::where([
//                ['group_id', '=', $group->id],
//                ['subGroup_id', '=', $subgroup->id],
//                ['course_id', '=', $course->id]
//            ])->first())){
//            $group->course()->attach($course->id, ['subgroup_id' => $subgroup->id]);
//            }
//            //check this part
//            if($d->role === 'student'){
//                $fullName = $this->getFullNameId($course->id, $group->id, $subgroup->id);
//                $user->fullCourseName()->attach( $fullName->id);
//            } else if($d->role === 'teacher') {
//                $user->teacher()->updateOrCreate(['user_id' => $user->id]);
//                // maybe pivot?????
//            }
//
//        }
//    }
//
//    public function getGroupId($number){
//        return Group::where('number', $number)->get()->id;
//    }
//
//    public function getSubgroupId($number){
//        return Subgroup::where('number', $number)->get()->id;
//    }
//
//    public function getCourseId($number){
//        return Course::where('number', $number)->get()->dd();
//    }
//
//    public function getFullNameId($course, $group, $subgroup) {
//        return CourseGroupSubgroup::where([
//            ['group_id', '=', $group],
//            ['subGroup_id', '=', $subgroup],
//            ['course_id', '=', $course]
//        ])->first();
//    }
//
//    public function getUserId($user) {
//        return Admin::where('email', $user->email)->get('id');
//    }
//
//
//    public function produce()
//    {
//
//    }
//}
