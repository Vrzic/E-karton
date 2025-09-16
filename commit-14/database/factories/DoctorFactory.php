<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Doctor>
 */
class DoctorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'license_number' => 'DR' . $this->faker->unique()->numberBetween(100000, 999999),
            'specialization' => $this->faker->randomElement(['Cardiology', 'Neurology', 'Orthopedics', 'Pediatrics', 'General Medicine', 'Surgery']),
            'qualifications' => $this->faker->optional()->randomElements(['MD', 'PhD', 'Fellowship', 'Board Certified'], $this->faker->numberBetween(1, 3)),
            'years_of_experience' => $this->faker->numberBetween(1, 30),
            'department' => $this->faker->randomElement(['Emergency', 'ICU', 'Outpatient', 'Surgery']),
            'is_available' => $this->faker->boolean(80),
        ];
    }
}
