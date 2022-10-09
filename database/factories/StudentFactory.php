<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() : array
    {
        $courseIdAssociateDepartmentId = Course::all('department_id', 'id')->toArray();
        $randomCourse = $courseIdAssociateDepartmentId[array_rand($courseIdAssociateDepartmentId)];

        return [
            'firstName' => fake()->name(),
            'lastName' => fake()->lastName(),
            'patronymic' => fake()->firstNameMale(),
            'email' => fake()->email(),
            'birth_date' =>fake()->date(),
            'emailVerifiedAt' => now(),
            'department_id' => $randomCourse['departmentId'],
            'course_id' => $randomCourse['id'],
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
