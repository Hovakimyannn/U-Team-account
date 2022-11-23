<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class TeacherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->name(),
            'last_name' => $this->faker->lastName(),
            'patronymic' => $this->faker->firstNameMale(),
            'birth_date' => $this->faker->date(),
            'email' => $this->faker->email(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => $this->faker->sha1(),
            'department_id' => $this->faker->numberBetween(1, 38),
            'position' => $this->faker->randomElement(
                [
                    'assistant',
                    'lecturer',
                    'associate_professor',
                    'professors'
                ]
            ),
        ];
    }
}
