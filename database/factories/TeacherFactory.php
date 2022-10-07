<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Teacher>
 */
class TeacherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'first_name' => fake()->name(),
            'last_name' => fake()->lastName(),
            'patronymic' => fake()->name(),
            'email' => fake()->email(),
            'birth_date' =>fake()->date,
            'email_verified_at' => now(),
            'department_id' => random_int(1,5),
            'course_id' => Course::first()->id,
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'position' => 'lecturer'
        ];
    }
}
