<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $services = ['Consultation générale', 'Radiologie', 'Cardiologie', 'Pédiatrie', 'Dermatologie'];
        return [
            'name' => fake()->unique()->randomElement($services),
            'description' => fake()->sentence(),
            'duration_minutes' => fake()->randomElement([15, 30, 45, 60]),
        ];
    }
}
