<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Admin;
use App\Models\Course;
use App\Models\Department;
use App\Models\Institute;
use App\Models\Student;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() : void
    {
        if (!Admin::exists()) {
            // email    => admin@u_team.com
            // password => 'password'
            Admin::factory(1)->create();
        }

        if (!Institute::exists()) {
            Institute::factory(1)->create();
        }

        if (!Department::exists()) {
            Department::factory(1)->create();
        }

        if (!Course::exists()) {
            Course::factory(1)->create();
        }

        if (!Student::exists()) {
            // email    => student@u_team.com
            // password => 'password'
            Student::factory(1)->create();
        }
    }
}
