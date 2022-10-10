<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Student;
use App\Models\StudentGroupPivot;
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
        $studentIds = [];

        Teacher::factory(50)->create();
       /*     ->create()
            ->each(function ($student) use (&$studentIds) {
                $studentIds[] = $student->id;
            });

        $this->insertStudentGroupPivot($studentIds);*/
    }

    /**
     * @param $teacherIds
     * @return void
     */
    private function insertStudentGroupPivot($teacherIds) : void
    {
        $max = Group::all('id')->last()->id;
        $data = [];

        foreach ($teacherIds as $studentId) {
            $data[] = [
                'student_id' => $studentId,
                'group_id' => rand(1,$max)
            ];
        }

        StudentGroupPivot::insert($data);
    }
}
