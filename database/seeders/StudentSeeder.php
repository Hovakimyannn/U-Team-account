<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Student;
use App\Models\StudentGroupPivot;
use Illuminate\Database\Seeder;


class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() : void
    {
        $students = [];

        Student::factory(100)
            ->create()
            ->each(function ($student) use (&$students) {
                $students[] = [
                    'studentId' => $student->id,
                    'courseId'  => $student->courseId
                ];
            });

        $this->insertStudentGroupPivot($students);
    }

    /**
     * @param $students
     *
     * @return void
     */
    private function insertStudentGroupPivot($students) : void
    {
        $data = [];

        foreach ($students as $student) {
            $studentGroups = Group::all('id', 'parent_id', 'course_id')
                ->where('course_id', $student['courseId'])
                ->where('parent_id', null)
                ->toArray();

            $randomGroup = $studentGroups[array_rand($studentGroups)];

            $subGroup = Group::all('id', 'parent_id')
                ->where('parent_id', $randomGroup['id'])
                ->toArray();

            $data[] = [
                'student_id' => $student['studentId'],
                'group_id'   => $randomGroup['id']
            ];

            if ($subGroup != []) {
                $randomSubgroup = $subGroup[array_rand($subGroup)];
                $data[] = [
                    'student_id' => $student['studentId'],
                    'group_id'   => $randomSubgroup['id']
                ];
            }
        }

        StudentGroupPivot::insert($data);
    }
}
