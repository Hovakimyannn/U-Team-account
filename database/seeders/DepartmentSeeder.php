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
//                 Institute of Information and Telecommunication Technologies and Electronics
                ['name' => 'Algorithmic Languages and Programming', 'institute_id' => 1,],
                ['name' => 'Computer Systems and Networks', 'institute_id' => 1,],
                ['name' => 'Information Technologies and Automation', 'institute_id' => 1,],
                ['name' => 'Information Security and Software Provision', 'institute_id' => 1,],
                ['name' => 'Management Systems', 'institute_id' => 1,],
                ['name' => 'Electronic and Biomedical Measuring Equipment Systems', 'institute_id' => 1,],
                ['name' => 'Radio Equipment', 'institute_id' => 1,],
                ['name' => 'Communication Systems', 'institute_id' => 1,],
                ['name' => 'Electronic Devices and Measuring Systems', 'institute_id' => 1,],

//                Institute of Energy Electrical Engineering
                ['name' => 'Electric Machines and Devices', 'institute_id' => 2,],
                ['name' => 'Electrical Engineering and Electrification', 'institute_id' => 2,],
                ['name' => 'Thermal Energy and Environmental Protection', 'institute_id' => 2,],
                ['name' => 'Electricity', 'institute_id' => 2,],
                ['name' => 'Life Safety and Emergency Situations', 'institute_id' => 2,],

//                Mechanical Engineering, Transportation System and Design Institute
                ['name' => 'Mechanics and Machine Science', 'institute_id' => 3,],
                ['name' => 'Engineering Graphics', 'institute_id' => 3,],
                ['name' => 'Machine Building Technologies and Automation', 'institute_id' => 3,],
                ['name' => 'Vehicles', 'institute_id' => 3,],
                ['name' => 'Organization Of Transport Processes and Traffic', 'institute_id' => 3,],
                ['name' => 'Design and Fine Arts', 'institute_id' => 3,],

//                Institute of Mining, Metallurgy and Chemical Technologies
                ['name' => 'General Chemistry and Chemical Technologies', 'institute_id' => 4,],
                ['name' => 'Mountain Work and Environmental Protection', 'institute_id' => 4,],
                ['name' => 'Metallurgy and Material Science', 'institute_id' => 4,],

//                Faculty of Applied Mathematics and Physics
                ['name' => 'General Mathematical Education', 'institute_id' => 5,],
                ['name' => 'Professional Mathematical Education', 'institute_id' => 5,],
                ['name' => 'Physics', 'institute_id' => 5,],

//                Faculty of engineering economy and management
                ['name' => 'Economics and Management of Communication and Information Technologies', 'institute_id' => 6,],
                ['name' => 'Economics and Management of The Energy', 'institute_id' => 6,],
                ['name' => 'Economics and Management of Machine Building Industry and Transport', 'institute_id' => 6,],
                ['name' => 'Mining and Metallurgical Industry and Natural Resource Management and Management', 'institute_id' => 4,],

//                University Chairs
                ['name' => 'Physical Education and Sports', 'institute_id' => 7],
                ['name' => 'Microelectronic Circuits and Systems', 'institute_id' => 7],
                ['name' => 'Social Sciences', 'institute_id' => 7],
                ['name' => 'General Economics', 'institute_id' => 7],
                ['name' => 'Scientific and Educational Center of Languages', 'institute_id' => 7],
                ['name' => 'Armenian Language', 'institute_id' => 7],
                ['name' => 'Russian Language', 'institute_id' => 7],
                ['name' => 'Foreign Languages', 'institute_id' => 7],
            ]
        );
    }
}