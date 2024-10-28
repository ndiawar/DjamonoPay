<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CompteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 25; $i++) {
            DB::table('comptes')->insert([
                'numero' => 'COMPTE-' . str_pad($i, 5, '0', STR_PAD_LEFT), // Exemple : COMPTE-00001
                'user_id' => rand(1, 10), // Remplace par un ID d'utilisateur valide
                'solde' => rand(1000, 100000) / 100, // Solde entre 10.00 et 1000.00
                'qr_code' => Str::random(10), // QR code aléatoire
                'est_bloque' => (bool)rand(0, 1), // Bloqué ou non
                'qr_code_creation' => now()->subDays(rand(0, 30)), // Date de création aléatoire
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
