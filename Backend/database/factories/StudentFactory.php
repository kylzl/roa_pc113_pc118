<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class StudentFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'firstname' => fake()->firstName(),
            'middlename' => fake()->optional()->firstName(),
            'lastname' => fake()->lastName(),
            'gender' => fake()->randomElement(['Male', 'Female']),
            'birthdate' => fake()->date(),
            'address' => fake()->address(),
            'contact_number' => fake()->phoneNumber(),
            'guardian_name' => fake()->name(),
            'guardian_contact_number' => fake()->phoneNumber(),
            'guardian_relationship' => fake()->randomElement(['Parent', 'Sibling', 'Relative', 'Other']),
            'guardian_address' => fake()->address(),
            'guardian_email' => fake()->safeEmail(),
            'image' => fake()->optional()->imageUrl(),
            'email' => fake()->unique()->safeEmail(),
        ];
    }
}