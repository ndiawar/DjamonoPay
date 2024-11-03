<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransactionSeeder extends Seeder
{
    /**
     * Exécute le seeder.
     *
     * @return void
     */
    public function run()
    {
        // Récupérer les IDs des comptes existants
        $userIds = DB::table('users')->pluck('id')->toArray();

        $transactions = [];
        for ($i = 0; $i < 80; $i++) {
            $userId = $userIds[array_rand($userIds)]; // Choisir un user_id aléatoire
            $type = ['depot', 'retrait', 'transfert', 'annule'][array_rand(['depot', 'retrait', 'transfert', 'annule'])];
            $montant = rand(10000, 500000); // Montant aléatoire entre 10,000 et 500,000 CFA
            $frais = $montant * 0.01; // 1% de frais
            $commission = $type === 'transfert' ? $montant * 0.02 : null; // 2% de commission si c'est un transfert
            $etat = ['terminee', 'annulee', 'en_attente'][array_rand(['terminee', 'annulee', 'en_attente'])];
            $motif = $this->generateMotif($type);

            // Générer une date aléatoire entre maintenant et 6 mois en arrière
            $date = Carbon::now()->subDays(rand(0, 180));

            $transactions[] = [
                'user_id' => $userId,
                'type' => $type,
                'montant' => $montant,
                'frais' => $frais,
                'commission' => $commission,
                'etat' => $etat,
                'motif' => $motif,
                'date' => $date,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        DB::table('transactions')->insert($transactions);
    }

    /**
     * Générer un motif aléatoire en fonction du type de transaction.
     *
     * @param string $type
     * @return string
     */
    private function generateMotif($type)
    {
        $motifs = [
            'depot' => 'Dépôt de fonds',
            'retrait' => 'Retrait d\'argent',
            'transfert' => 'Transfert vers un autre compte',
            'annule' => 'Transaction annulée',
        ];

        return $motifs[$type];
    }
}
