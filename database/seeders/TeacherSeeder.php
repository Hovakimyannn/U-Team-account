<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Group;
use App\Models\Teachable;
use App\Models\Teacher;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teacherIds = [];

        Teacher::factory(100)->create()
            ->each(function ($teacher) use (&$teacherIds) {
                $teacherIds[] = $teacher->id;
            });

        $this->insertStudentGroupPivot($teacherIds);
    }

    /**
     * @param $teacherIds
     *
     * @return void
     */
    private function insertStudentGroupPivot($teacherIds) : void
    {
        $maxGroup = Group::all('id')->last()->id;
        $maxCourse = Course::all('id')->last()->id;
        $data = [];

        foreach ($teacherIds as $teacherId) {
            $index = 0;
            while ($index < 3) {
                $model = array_rand(['Course', 'Group']);

                if ($model === 0) {
                    $model = 'Course';
                    $modelId = rand(1, $maxCourse);
                } else {
                    $model = 'Group';
                    $modelId = rand(1, $maxGroup);
                }

                $data[] = [
                    'teacher_id'     => $teacherId,
                    'teachable_type' => $model,
                    'teachable_id'   => $modelId,
                ];
                $index++;
            }
        }
        Teachable::insert($data);
    }
}
