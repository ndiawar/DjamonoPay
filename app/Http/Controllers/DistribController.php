<?php

namespace App\Http\Controllers;

use App\Models\Distributeur_model;
use Illuminate\Http\Request;

class DistribController extends Controller
{
    // Affiche le tableau de bord des distributeurs
    public function index()
    {
        // Récupérer tous les distributeurs
        $distributeurs = Distributeur_model::distributeurs()->get();

        // Calculer les statistiques nécessaires
        $statistics = [
            'total_solde' => $distributeurs->sum('solde'),
            'total_distributeurs' => $distributeurs->count(),
            'total_distributeurs_actifs' => $distributeurs->where('etat_compte', 'actif')->count(),
        ];

        // Retourner la vue avec les données
        return view('dashboard-distributeurs', compact('distributeurs', 'statistics'));
    }
}
