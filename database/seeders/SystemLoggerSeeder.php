<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SystemLogger;
use App\Models\User;
use Faker\Factory as Faker;

class SystemLoggerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Assurez-vous qu'il y a des utilisateurs existants dans la base de données
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->warn('No users found, please seed the users table first.');
            return;
        }

        // Créer des logs pour chaque utilisateur
        foreach ($users as $user) {
            for ($i = 0; $i < 10; $i++) { // Générer 10 logs par utilisateur
                SystemLogger::create([
                    'user_id'    => $user->id,
                    'action'     => $faker->randomElement(['Créée', 'Annulée', 'Modifiée']),
                    'timestamp'  => $faker->dateTimeThisYear(),
                    'description'=> $faker->sentence(),
                ]);
            }
        }
    }
}
