<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Course;
use Illuminate\Database\Seeder;


class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() : void
    {
        $degrees = ['bachelor', 'master', 'PhD'];
        $types = ['available', 'remotely'];
        $data = [];

        foreach ($degrees as $degree) {
            foreach ($types as $type) {
                $data[] = [
                    // dataOfEE
                    ['number' => 219, 'degree' => $degree, 'type' => $type, 'department_id' => 1],
                    ['number' => 221, 'degree' => $degree, 'type' => $type, 'department_id' => 1],
                    ['number' => 224, 'degree' => $degree, 'type' => $type, 'department_id' => 2],
                    ['number' => 255, 'degree' => $degree, 'type' => $type, 'department_id' => 3],
                    ['number' => 216, 'degree' => $degree, 'type' => $type, 'department_id' => 4],
                    ['number' => 218, 'degree' => $degree, 'type' => $type, 'department_id' => 4],
                    ['number' => 222, 'degree' => $degree, 'type' => $type, 'department_id' => 5],
                    ['number' => 238, 'degree' => $degree, 'type' => $type, 'department_id' => 6],
                    ['number' => 260, 'degree' => $degree, 'type' => $type, 'department_id' => 7],
                    ['number' => 268, 'degree' => $degree, 'type' => $type, 'department_id' => 7],
                    ['number' => 209, 'degree' => $degree, 'type' => $type, 'department_id' => 9],
                    ['number' => 269, 'degree' => $degree, 'type' => $type, 'department_id' => 10],

                    // dataOfEE
                    ['number' => 205, 'degree' => $degree, 'type' => $type, 'department_id' => 11],
                    ['number' => 206, 'degree' => $degree, 'type' => $type, 'department_id' => 12],
                    ['number' => 234, 'degree' => $degree, 'type' => $type, 'department_id' => 14],
                    ['number' => 208, 'degree' => $degree, 'type' => $type, 'department_id' => 16],

                    // dataOfM
                    ['number' => 212, 'degree' => $degree, 'type' => $type, 'department_id' => 17],
                    ['number' => 256, 'degree' => $degree, 'type' => $type, 'department_id' => 18],
                    ['number' => 226, 'degree' => $degree, 'type' => $type, 'department_id' => 19],
                    ['number' => 257, 'degree' => $degree, 'type' => $type, 'department_id' => 19],
                    ['number' => 210, 'degree' => $degree, 'type' => $type, 'department_id' => 20],
                    ['number' => 213, 'degree' => $degree, 'type' => $type, 'department_id' => 21],
                    ['number' => 232, 'degree' => $degree, 'type' => $type, 'department_id' => 21],
                    ['number' => 204, 'degree' => $degree, 'type' => $type, 'department_id' => 22],
                    ['number' => 243, 'degree' => $degree, 'type' => $type, 'department_id' => 23],
                    ['number' => 245, 'degree' => $degree, 'type' => $type, 'department_id' => 23],

                    // dataOfL
                    ['number' => 223, 'degree' => $degree, 'type' => $type, 'department_id' => 24],
                    ['number' => 225, 'degree' => $degree, 'type' => $type, 'department_id' => 25],
                    ['number' => 201, 'degree' => $degree, 'type' => $type, 'department_id' => 26],

                    // dataOfMT
                    ['number' => 240, 'degree' => $degree, 'type' => $type, 'department_id' => 28],

                    // dataOfIT
                    ['number' => 247, 'degree' => $degree, 'type' => $type, 'department_id' => 31],
                    ['number' => 270, 'degree' => $degree, 'type' => $type, 'department_id' => 33],
                    ['number' => 207, 'degree' => $degree, 'type' => $type, 'department_id' => 37],
                ];
            }
        }
        Course::insert(array_merge(...$data));
    }
}
