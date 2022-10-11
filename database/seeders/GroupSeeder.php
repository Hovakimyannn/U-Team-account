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
            ['number' => 1, 'course_id' => 31, 'parent_id' => null],
            ['number' => 1, 'course_id' => 31, 'parent_id' => 1],
            ['number' => 2, 'course_id' => 31, 'parent_id' => 1],
            ['number' => 2, 'course_id' => 31, 'parent_id' => null],
            ['number' => 1, 'course_id' => 1, 'parent_id' => null],
            ['number' => 1, 'course_id' => 1, 'parent_id' => 5],
            ['number' => 2, 'course_id' => 1, 'parent_id' => 5],
            ['number' => 2, 'course_id' => 1, 'parent_id' => null],
            ['number' => 1, 'course_id' => 1, 'parent_id' => 8],
            ['number' => 2, 'course_id' => 1, 'parent_id' => 8],
            ['number' => 1, 'course_id' => 7, 'parent_id' => null],
            ['number' => 2, 'course_id' => 7, 'parent_id' => null],
            ['number' => 1, 'course_id' => 3, 'parent_id' => null],
            ['number' => 2, 'course_id' => 3, 'parent_id' => null],
            ['number' => 1, 'course_id' => 4, 'parent_id' => null],
            ['number' => 2, 'course_id' => 4, 'parent_id' => null],
            ['number' => 1, 'course_id' => 5, 'parent_id' => null],
            ['number' => 2, 'course_id' => 5, 'parent_id' => null],
            ['number' => 1, 'course_id' => 25, 'parent_id' => null],
            ['number' => 2, 'course_id' => 25, 'parent_id' => null],
            ['number' => 1, 'course_id' => 99, 'parent_id' => null],
            ['number' => 2, 'course_id' => 99, 'parent_id' => null],
            ['number' => 1, 'course_id' => 132, 'parent_id' => null],
            ['number' => 2, 'course_id' => 132, 'parent_id' => null],
            ['number' => 1, 'course_id' => 83, 'parent_id' => null],
            ['number' => 2, 'course_id' => 83, 'parent_id' => null],
            ['number' => 1, 'course_id' => 116, 'parent_id' => null],
            ['number' => 2, 'course_id' => 116, 'parent_id' => null],
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
