<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Group;
use Illuminate\Database\Seeder;


class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() : void
    {
        $ids = Course::all()->modelKeys();

        $data = [
            ['number' => 1, 'course_id' => 1, 'parent_id' => null],
            ['number' => 1, 'course_id' => 1, 'parent_id' => 1],
            ['number' => 2, 'course_id' => 1, 'parent_id' => 1],
            ['number' => 2, 'course_id' => 1, 'parent_id' => null],
            ['number' => 1, 'course_id' => 20, 'parent_id' => null],
            ['number' => 1, 'course_id' => 20, 'parent_id' => 5],
            ['number' => 2, 'course_id' => 20, 'parent_id' => 5],
            ['number' => 2, 'course_id' => 20, 'parent_id' => null],
            ['number' => 1, 'course_id' => 20, 'parent_id' => 8],
            ['number' => 2, 'course_id' => 20, 'parent_id' => 8],
            ['number' => 1, 'course_id' => 40, 'parent_id' => null],
            ['number' => 1, 'course_id' => 40, 'parent_id' => 11],
            ['number' => 2, 'course_id' => 40, 'parent_id' => 11],
            ['number' => 2, 'course_id' => 40, 'parent_id' => null],
            ['number' => 1, 'course_id' => 40, 'parent_id' => 14],
            ['number' => 2, 'course_id' => 40, 'parent_id' => 14],
            ['number' => 1, 'course_id' => 60, 'parent_id' => null],
            ['number' => 1, 'course_id' => 60, 'parent_id' => 17],
            ['number' => 2, 'course_id' => 60, 'parent_id' => 17],
            ['number' => 2, 'course_id' => 60, 'parent_id' => null],
            ['number' => 1, 'course_id' => 60, 'parent_id' => 20],
            ['number' => 2, 'course_id' => 60, 'parent_id' => 20],
            ['number' => 1, 'course_id' => 80, 'parent_id' => null],
            ['number' => 1, 'course_id' => 80, 'parent_id' => 23],
            ['number' => 2, 'course_id' => 80, 'parent_id' => 23],
            ['number' => 2, 'course_id' => 80, 'parent_id' => null],
            ['number' => 1, 'course_id' => 80, 'parent_id' => 26],
            ['number' => 2, 'course_id' => 80, 'parent_id' => 26],
            ['number' => 1, 'course_id' => 100, 'parent_id' => null],
            ['number' => 1, 'course_id' => 100, 'parent_id' => 29],
            ['number' => 2, 'course_id' => 100, 'parent_id' => 29],
            ['number' => 2, 'course_id' => 100, 'parent_id' => null],
            ['number' => 1, 'course_id' => 100, 'parent_id' => 32],
            ['number' => 2, 'course_id' => 100, 'parent_id' => 32],
            ['number' => 1, 'course_id' => 120, 'parent_id' => null],
            ['number' => 2, 'course_id' => 120, 'parent_id' => null],
            ['number' => 1, 'course_id' => 140, 'parent_id' => null],
            ['number' => 2, 'course_id' => 140, 'parent_id' => null],
            ['number' => 1, 'course_id' => 160, 'parent_id' => null],
            ['number' => 2, 'course_id' => 160, 'parent_id' => null],
            ['number' => 1, 'course_id' => 180, 'parent_id' => null],
            ['number' => 2, 'course_id' => 180, 'parent_id' => null],
        ];
        $filteredData = [];
        array_filter($data, function ($item) use (&$filteredData) {
            $filteredData[] = $item['course_id'];
        });

        $availableCourseIds = array_diff($ids, $filteredData);

        foreach ($availableCourseIds as $availableCourseId) {
            $data[] =
                ['number' => 1, 'course_id' => $availableCourseId, 'parent_id' => null];
        }
        Group::insert($data);
    }
}
