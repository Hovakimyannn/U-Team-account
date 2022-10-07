<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Department::insert(
            [
                ['name' => 'Algorithmic languages and programming', 'institute_id' => 1,],
                ['name' => 'Computer systems and networks', 'institute_id' => 1,],
                ['name' => 'Information technologies and automation', 'institute_id' => 1,],
                ['name' => 'Information security and software', 'institute_id' => 1,],
                ['name' => 'Management systems', 'institute_id' => 1,],
                ['name' => 'Electronic and biomedical measuring equipment systems', 'institute_id' => 1,],
                ['name' => 'Radio equipment', 'institute_id' => 1,],
                ['name' => 'Communication systems', 'institute_id' => 1,],
                ['name' => 'Economics and management', 'institute_id' => 1,],
                ['name' => 'Electronic devices and measuring systems', 'institute_id' => 1,],

                ['name' => 'Electric machines and devices', 'institute_id' => 2,],
                ['name' => 'Electrical engineering and electrification', 'institute_id' => 2,],
                ['name' => 'Economics and management of the energy sector', 'institute_id' => 2,],
                ['name' => 'Thermal energy and environmental protection', 'institute_id' => 2,],
                ['name' => 'Electricity', 'institute_id' => 2,],
                ['name' => 'Life safety and emergency situations', 'institute_id' => 2,],

                ['name' => 'Mechanics and machine science', 'institute_id' => 3,],
                ['name' => 'Engineering graphics', 'institute_id' => 3,],
                ['name' => 'Machine building technologies and automation', 'institute_id' => 3,],
                ['name' => 'Vehicles', 'institute_id' => 3,],
                ['name' => 'Organization of transport processes and traffic', 'institute_id' => 3,],
                ['name' => 'Economics and management of machine building industry and transport', 'institute_id' => 3,],
                ['name' => 'Design and fine arts', 'institute_id' => 3,],

                ['name' => 'General chemistry and chemical technologies', 'institute_id' => 4,],
                ['name' => 'Mountain work and environmental protection', 'institute_id' => 4,],
                ['name' => 'Mining and metallurgical industry and natural resource management and management', 'institute_id' => 4,],
                ['name' => 'Metallurgy and material science', 'institute_id' => 4,],

                ['name' => 'General mathematical education', 'institute_id' => 5,],
                ['name' => 'Professional mathematical education', 'institute_id' => 5,],
                ['name' => 'Physics', 'institute_id' => 5,],

            ]
        );
    }
}
