<?php

namespace Database\Seeders;

use App\Models\Admin;
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
            ['number' => 1, 'course_id' => 31],
            ['number' => 2, 'course_id' => 31],
            ['number' => 1, 'course_id' => 1],
            ['number' => 2, 'course_id' => 1],
            ['number' => 1, 'course_id' => 7],
            ['number' => 2, 'course_id' => 7],
            ['number' => 1, 'course_id' => 3],
            ['number' => 2, 'course_id' => 3],
            ['number' => 1, 'course_id' => 4],
            ['number' => 2, 'course_id' => 4],
            ['number' => 1, 'course_id' => 5],
            ['number' => 2, 'course_id' => 5],
            ['number' => 1, 'course_id' => 25],
            ['number' => 2, 'course_id' => 25],
            ['number' => 1, 'course_id' => 99],
            ['number' => 2, 'course_id' => 99],
            ['number' => 1, 'course_id' => 132],
            ['number' => 2, 'course_id' => 132],
            ['number' => 1, 'course_id' => 83],
            ['number' => 2, 'course_id' => 83],
            ['number' => 1, 'course_id' => 116],
            ['number' => 2, 'course_id' => 116],
        ];
        $filteredData = [];
        array_filter($data, function($item) use (&$filteredData) {
            $filteredData[] = $item['course_id'];
        });

        $availableCourseIds = array_diff($ids,$filteredData);

        foreach ($availableCourseIds as $availableCourseId) {
            $data[] =
                ['number' => 1, 'course_id' => $availableCourseId];
        }
        Group::insert($data);

    }
}
