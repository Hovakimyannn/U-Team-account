<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() : array
    {
        return [
            'firstName' => $this->faker->name(),
            'lastName' => $this->faker->lastName(),
            'patronymic' => $this->faker->name(),
            'email' => 'admin@u_team.com',
            'emailVerifiedAt' => now(),
            'password' => Hash::make('password'),
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
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
