<?php

namespace Database\Seeders;

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
//Institute of Information and Telecommunication Technologies and Electronics
//                    Algorithmic Languages and Programming
                    ['number' => 924, 'degree' => $degree, 'type' => $type, 'department_id' => 1],
//                    Computer Systems and Networks
                    ['number' => 221, 'degree' => $degree, 'type' => $type, 'department_id' => 2],
//                    Information Technologies and Automation
                    ['number' => 220, 'degree' => $degree, 'type' => $type, 'department_id' => 3],
//                    Information Security and Software Provision
                    ['number' => 255, 'degree' => $degree, 'type' => $type, 'department_id' => 4],
//                    Management Systems
                    ['number' => 222, 'degree' => $degree, 'type' => $type, 'department_id' => 5],
//                    Electronic and Biomedical Measuring Equipment Systems
                    ['number' => 238, 'degree' => $degree, 'type' => $type, 'department_id' => 6],
//                    Radio Equipment
                    ['number' => 216, 'degree' => $degree, 'type' => $type, 'department_id' => 7],
//                    Communication Systems
                    ['number' => 209, 'degree' => $degree, 'type' => $type, 'department_id' => 8],
//                    Electronic Devices and Measuring Systems
                    ['number' => 218, 'degree' => $degree, 'type' => $type, 'department_id' => 9],
//Institute of Energy Electrical Engineering
//                    Electric Machines and Devices
                    ['number' => 208, 'degree' => $degree, 'type' => $type, 'department_id' => 10],
//                    Electrical Engineering and Electrification
                    ['number' => 234, 'degree' => $degree, 'type' => $type, 'department_id' => 11],
//                    Thermal Energy and Environmental Protection
                    ['number' => 205, 'degree' => $degree, 'type' => $type, 'department_id' => 12],
//                    Electricity
                    ['number' => 206, 'degree' => $degree, 'type' => $type, 'department_id' => 13],
//                    Life Safety and Emergency Situations
                    ['number' => 211, 'degree' => $degree, 'type' => $type, 'department_id' => 14],
//Mechanical Engineering, Transportation System and Design Institute
//                    Mechanics and Machine Science
                    ['number' => 204, 'degree' => $degree, 'type' => $type, 'department_id' => 15],
//                    Engineering Graphics
                    ['number' => 243, 'degree' => $degree, 'type' => $type, 'department_id' => 16],
//                    Machine Building Technologies and Automation
                    ['number' => 210, 'degree' => $degree, 'type' => $type, 'department_id' => 17],
                    ['number' => 213, 'degree' => $degree, 'type' => $type, 'department_id' => 17],
//                    Vehicles
                    ['number' => 212, 'degree' => $degree, 'type' => $type, 'department_id' => 18],
                    ['number' => 215, 'degree' => $degree, 'type' => $type, 'department_id' => 18],
//                    Organization Of Transport Processes and Traffic
                    ['number' => 247, 'degree' => $degree, 'type' => $type, 'department_id' => 19],
//                    Design and Fine Arts
                    ['number' => 245, 'degree' => $degree, 'type' => $type, 'department_id' => 20],
//Institute of Mining, Metallurgy and Chemical Technologies
//                    General Chemistry and Chemical Technologies
                    ['number' => 201, 'degree' => $degree, 'type' => $type, 'department_id' => 21],
                    ['number' => 233, 'degree' => $degree, 'type' => $type, 'department_id' => 21],
//                    Mountain Work and Environmental Protection
                    ['number' => 223, 'degree' => $degree, 'type' => $type, 'department_id' => 22],
//                    Metallurgy and Material Science
                    ['number' => 225, 'degree' => $degree, 'type' => $type, 'department_id' => 23],
//Faculty of Applied Mathematics and Physics
//                    Professional Mathematical Education
                    ['number' => 240, 'degree' => $degree, 'type' => $type, 'department_id' => 25],
//Faculty of engineering economy and management
//                    Economics and Management of Communication and Information Technologies
                    ['number' => 007, 'degree' => $degree, 'type' => $type, 'department_id' => 27],
//                    Economics and Management of The Energy
                    ['number' => 017, 'degree' => $degree, 'type' => $type, 'department_id' => 28],
//                    Economics and Management of Machine Building Industry and Transport
                    ['number' => 027, 'degree' => $degree, 'type' => $type, 'department_id' => 29],
//                    Mining and Metallurgical Industry and Natural Resource Management and Management
                    ['number' => 057, 'degree' => $degree, 'type' => $type, 'department_id' => 30],
                ];
            }
        }
        Course::insert(array_merge(...$data));
    }
}
