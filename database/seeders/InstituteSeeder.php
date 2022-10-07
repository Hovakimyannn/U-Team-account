<?php

namespace Database\Seeders;

use App\Models\Institute;
use Illuminate\Database\Seeder;

class InstituteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() : void
    {
        Institute::insert(
            [
                ['name' => 'Institute of Information and Telecommunication Technologies and Electronics'],
                ['name' => 'Institute of Energy Electrical Engineering'],
                ['name' => 'Mechanical Engineering, Transportation System and Design Institute'],
                ['name' => 'Institute of Mining, Metallurgy and Chemical Technologies'],
                ['name' => 'Faculty of Applied Mathematics and Physics'],
                ['name' => 'Faculty of engineering economy and management']
            ]
        );
    }
}
