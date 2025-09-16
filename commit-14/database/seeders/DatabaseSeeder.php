<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@health.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Create test users for different roles
        User::create([
            'name' => 'Test Doctor',
            'email' => 'doctor@health.com',
            'password' => bcrypt('password'),
            'role' => 'doctor',
        ]);

        User::create([
            'name' => 'Test Nurse',
            'email' => 'nurse@health.com',
            'password' => bcrypt('password'),
            'role' => 'nurse',
        ]);

        User::create([
            'name' => 'Test Patient',
            'email' => 'patient@health.com',
            'password' => bcrypt('password'),
            'role' => 'patient',
        ]);

        // Run other seeders
        $this->call([
            PatientSeeder::class,
            DoctorSeeder::class,
        ]);
    }
}
