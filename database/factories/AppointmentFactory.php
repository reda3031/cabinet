<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'patient_id' => User::where('role', 'patient')->inRandomOrder()->first()->id,
            'medecin_id' => User::where('role', 'medecin')->inRandomOrder()->first()->id,
            'service_id' => Service::inRandomOrder()->first()->id,
            'appointment_date' => fake()->dateTimeBetween('now', '+2 months'),
            'status' => fake()->randomElement(['pending', 'confirmed', 'cancelled']),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
