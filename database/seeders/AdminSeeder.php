<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!Admin::exists()) {
            // email    => admin@u-team.com
            // password => 'password'
            Admin::factory(1)->create();
        }
    }
}
