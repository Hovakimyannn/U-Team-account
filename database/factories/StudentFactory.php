<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() : array
    {
        return [
            'firstName' => fake()->name(),
            'lastName' => fake()->lastName(),
            'patronymic' => fake()->name(),
            'email' => 'student@u_team.com',
            'birth_date' =>fake()->date,
            'emailVerifiedAt' => now(),
            'department_id' => Department::first()->id,
            'course_id' => Course::first()->id,
            'password' => Hash::make('password'),
            'rememberToken' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified() : static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
