<?php

namespace Database\Seeders;

use App\Models\Admin;
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
        if (!Admin::exists()) {
            // email    => admin@u_team.com
            // password => 'password'
            Admin::factory(1)->create();
        }
    }

    /**
     * @param $student_id
     * @return void
     */
    private function insertStudentGroupPivot($student_id) : void
    {

        StudentGroupPivot::factory(10)->create([
            'student_id' => $student_id
        ]);
    }
}
