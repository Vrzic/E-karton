<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
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
            'medical_record_number' => 'MRN' . $this->faker->unique()->numberBetween(100000, 999999),
            'blood_type' => $this->faker->randomElement(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']),
            'allergies' => $this->faker->optional()->randomElements(['Penicillin', 'Aspirin', 'Ibuprofen', 'Latex', 'Peanuts'], $this->faker->numberBetween(0, 3)),
            'medical_history' => $this->faker->optional()->randomElements(['Hypertension', 'Diabetes', 'Asthma', 'Heart Disease'], $this->faker->numberBetween(0, 2)),
            'emergency_contact_name' => $this->faker->optional()->name(),
            'emergency_contact_phone' => $this->faker->optional()->phoneNumber(),
            'insurance_provider' => $this->faker->optional()->company(),
            'insurance_number' => $this->faker->optional()->regexify('[A-Z]{2}[0-9]{8}'),
        ];
    }
}
