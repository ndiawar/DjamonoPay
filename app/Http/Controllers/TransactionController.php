<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Afficher la liste des transactions
     */
    public function index(Request $request)
    {
        $transactions = Transaction::with(['client', 'distributeur'])
            ->when($request->type, function($query, $type) {
                return $query->where('type', $type);
            })
            ->when($request->etat, function($query, $etat) {
                return $query->where('etat', $etat);
            })
            ->when($request->date_debut, function($query, $date) {
                return $query->whereDate('date', '>=', $date);
            })
            ->when($request->date_fin, function($query, $date) {
                return $query->whereDate('date', '<=', $date);
            })
            ->orderBy('date', 'desc')
            ->paginate(10);

        return response()->json($transactions);
    }

    /**
     * Créer une nouvelle transaction
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'client_id' => 'required|exists:users,id',
                'type' => 'required|in:depot,retrait,transfert',
                'montant' => 'required|numeric|min:0'
            ]);

            DB::beginTransaction();

            $client = User::findOrFail($request->client_id);
            
            // Vérifier si le compte est bloqué
            if ($client->compte->est_bloque) {
                throw new \Exception('Le compte client est bloqué');
            }

            switch ($request->type) {
                case 'depot':
                    $transaction = Transaction::creerDepot(
                        $client->id,
                        auth()->id(),
                        $request->montant,
                        $request->montant * 0.01 // 1% commission
                    );
                    break;

                case 'retrait':
                    if ($client->compte->solde < $request->montant) {
                        throw new \Exception('Solde insuffisant');
                    }
                    $transaction = Transaction::creerRetrait(
                        $client->id,
                        auth()->id(),
                        $request->montant,
                        $request->montant * 0.01 // 1% commission
                    );
                    break;

                case 'transfert':
                    $frais = $request->montant * 0.02; // 2% frais
                    if ($client->compte->solde < ($request->montant + $frais)) {
                        throw new \Exception('Solde insuffisant avec les frais');
                    }
                    $transaction = Transaction::creerTransfert(
                        $client->id,
                        $request->montant,
                        $frais
                    );
                    break;
            }

            DB::commit();

            return response()->json([
                'message' => 'Transaction créée avec succès',
                'transaction' => $transaction
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Erreur lors de la création de la transaction',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Afficher une transaction spécifique
     */
    public function show(Transaction $transaction): JsonResponse
    {
        return response()->json([
            'transaction' => $transaction->load(['client', 'distributeur'])
        ]);
    }

    /**
     * Annuler une transaction
     */
    public function annuler(Transaction $transaction): JsonResponse
    {
        try {
            DB::beginTransaction();

            // Vérifier si la transaction peut être annulée
            if ($transaction->etat !== 'en_attente') {
                throw new \Exception('Cette transaction ne peut pas être annulée');
            }

            // Si c'est une transaction avec un distributeur, retirer sa commission
            if ($transaction->distributeur_id) {
                $transaction->distributeur->compte->decrement('solde', $transaction->commission);
            }

            // Rembourser le montant selon le type de transaction
            switch ($transaction->type) {
                case 'depot':
                    $transaction->client->compte->decrement('solde', $transaction->montant);
                    break;

                case 'retrait':
                    $transaction->client->compte->increment('solde', $transaction->montant);
                    break;

                case 'transfert':
                    $transaction->client->compte->increment('solde', $transaction->montant + $transaction->frais);
                    break;
            }

            $transaction->annuler();

            DB::commit();

            return response()->json([
                'message' => 'Transaction annulée avec succès',
                'transaction' => $transaction->fresh()
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Erreur lors de l\'annulation',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Historique des transactions pour un utilisateur
     */
    public function historique(Request $request): JsonResponse
    {
        $user = auth()->user();
        
        $transactions = Transaction::where(function($query) use ($user) {
                if ($user->role === 'client') {
                    $query->where('client_id', $user->id);
                } else {
                    $query->where('distributeur_id', $user->id);
                }
            })
            ->when($request->type, function($query, $type) {
                return $query->where('type', $type);
            })
            ->when($request->etat, function($query, $etat) {
                return $query->where('etat', $etat);
            })
            ->when($request->date_debut, function($query, $date) {
                return $query->whereDate('date', '>=', $date);
            })
            ->when($request->date_fin, function($query, $date) {
                return $query->whereDate('date', '<=', $date);
            })
            ->with(['client', 'distributeur'])
            ->orderBy('date', 'desc')
            ->paginate($request->per_page ?? 10);

        return response()->json($transactions);
    }

    /**
     * Statistiques des transactions
     */
    public function statistiques(): JsonResponse
    {
        $user = auth()->user();

        $stats = [
            'total_transactions' => Transaction::where(function($query) use ($user) {
                if ($user->role === 'client') {
                    $query->where('client_id', $user->id);
                } else {
                    $query->where('distributeur_id', $user->id);
                }
            })->count(),
            'montant_total' => Transaction::where(function($query) use ($user) {
                if ($user->role === 'client') {
                    $query->where('client_id', $user->id);
                } else {
                    $query->where('distributeur_id', $user->id);
                }
            })->sum('montant'),
            'commission_totale' => Transaction::where('distributeur_id', $user->id)->sum('commission'),
            'transactions_par_type' => Transaction::where(function($query) use ($user) {
                if ($user->role === 'client') {
                    $query->where('client_id', $user->id);
                } else {
                    $query->where('distributeur_id', $user->id);
                }
            })
            ->selectRaw('type, count(*) as total')
            ->groupBy('type')
            ->get()
        ];

        return response()->json($stats);
    }
}