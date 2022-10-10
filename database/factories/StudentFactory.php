<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

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
        $randomCourse = $this->faker->randomElement($courseIdAssociateDepartmentId);

        return [
            'firstName'     => $this->faker->name(),
            'lastName'      => $this->faker->lastName(),
            'patronymic'    => $this->faker->firstNameMale(),
            'email'         => $this->faker->email(),
            'birth_date'    => $this->faker->date(),
            'department_id' => $randomCourse['departmentId'],
            'course_id'     => $randomCourse['id'],
            'password'      => Hash::make('password'),
            'rememberToken' => $this->faker->sha1(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified() : static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
