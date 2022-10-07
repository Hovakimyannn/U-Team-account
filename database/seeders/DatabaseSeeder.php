<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() : void
    {
        /**
         * email    => admin@u_team.com
         * password => 'password'
         */
        if (!Admin::exists()) {
            Admin::factory(1)->create();
        }

        $this->call([
            InstituteSeeder::class,
            DepartmentSeeder::class,
        ]);

        /*if (!Student::exists()) {
            // email    => student@u_team.com
            // password => 'password'
            Student::factory(1)->create();
        }*/
    }
}
