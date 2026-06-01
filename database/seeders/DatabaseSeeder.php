<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin Cabinet',
            'email' => 'admin@cabinet.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // User::factory(10)->create();
        // 5 médecins + 5 patients = 10 users
        User::factory(4)->create(['role' => 'medecin']);
        User::factory(5)->create(['role' => 'patient']);
        User::factory(1)->create(['role' => 'admin' , "password" => bcrypt('12345678')]);

        // 5 services
        Service::factory(5)->create();

        // 20 rendez-vous
        Appointment::factory(20)->create();
    }
}
