<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['agent', 'client', 'distributeur'];

        for ($i = 1; $i <= 25; $i++) {
            // Insérer l'utilisateur
            $userId = DB::table('users')->insertGetId([
                'nom' => 'Nom ' . $i,
                'prenom' => 'Prénom ' . $i,
                'email' => 'user' . $i . '@example.com',
                'photo' => null,
                'password' => bcrypt('password'),
                'role' => $roles[array_rand($roles)],
                'telephone' => '01234567' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'adresse' => 'Adresse ' . $i,
                'date_naissance' => Carbon::now()->subYears(rand(18, 40)),
                'numero_identite' => 'ID' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'etat_compte' => 'actif',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Insérer le compte associé à l'utilisateur
            DB::table('comptes')->insert([
                'user_id' => $userId,
                'numero' => 'COMPTE-' . str_pad($userId, 5, '0', STR_PAD_LEFT),
                'solde' => 0,
                'qr_code' => Str::random(10),
                'est_bloque' => false,
                'qr_code_creation' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
