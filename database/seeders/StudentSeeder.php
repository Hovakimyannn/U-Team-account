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
    public function run()
    {
        $studentIds = [];

        Student::factory(100)
            ->create()
            ->each(function ($student) use (&$studentIds) {
                $studentIds[] = $student->id;
            });

        $this->insertStudentGroupPivot($studentIds);
    }

    /**
     * @param $studentIds
     * @return void
     */
    private function insertStudentGroupPivot($studentIds) : void
    {
        $max = Group::all('id')->last()->id;
        $data = [];

        foreach ($studentIds as $studentId) {
            $data[] = [
                'student_id' => $studentId,
                'group_id' => rand(1,$max)
            ];
        }

        StudentGroupPivot::insert($data);
    }
}
