<?php

namespace App\Http\Controllers;

use App\Http\Requests\Transaction\StoreTransactionRequest;
use App\Http\Requests\Transaction\UpdateTransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Exception;

class TransactionController extends Controller
{
    /**
     * Enregistre une nouvelle transaction.
     */
    public function enregistrerTransaction(StoreTransactionRequest $request)
    {
        try {
            $validated = $request->validated();

            // Calcul des frais ou commissions selon le type de transaction
            if ($validated['type'] === 'transfert') {
                $validated['frais'] = $validated['montant'] * 0.02; // 2% de frais
            } elseif ($validated['type'] === 'depot' && isset($validated['distributeur_id'])) {
                $validated['commission'] = $validated['montant'] * 0.01; // 1% de commission pour dépôt
            } elseif ($validated['type'] === 'transfert' && isset($validated['distributeur_id'])) {
                $validated['commission'] = $validated['montant'] * 0.02; // 2% de commission pour transfert
            }

            $transaction = Transaction::create($validated);

            return new TransactionResource($transaction);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Erreur lors de l\'enregistrement de la transaction : ' . $e->getMessage()], 400);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur inattendue : ' . $e->getMessage()], 500);
        }
    }

    /**
     * Annule une transaction.
     */
    public function annulerTransaction(Transaction $transaction)
    {
        try {
            $transaction->etat = 'annulé';
            $transaction->save();
    
            return redirect()->back()->with('success', 'Transaction annulée avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de l\'annulation de la transaction : ' . $e->getMessage());
        }
    }

    /**
     * Consulte l'historique des transactions d'un utilisateur.
     */
    // public function consulterHistorique(Request $request)
    // {
    //     try {
    //         $userId = $request->query('user_id'); // Obtenez l'ID de l'utilisateur depuis la requête

    //         $transactions = Transaction::where('client_id', $userId)->with(['user', 'distributeur'])->get();

    //         return TransactionResource::collection($transactions);
    //     } catch (Exception $e) {
    //         return response()->json(['message' => 'Erreur lors de la récupération de l\'historique des transactions : ' . $e->getMessage()], 500);
    //     }
    // }

    /**
     * Calcule les frais d'une transaction.
     */
    public function calculerFrais($montant, $type)
    {
        if ($type === 'transfert') {
            return $montant * 0.02; // 2% de frais pour transfert
        }

        return 0; // Aucun frais par défaut
    }

    /**
     * Calcule la commission d'une transaction.
     */
    public function calculerCommission($montant, $type, $isDistributeur = false)
    {
        if ($isDistributeur) {
            if ($type === 'depot') {
                return $montant * 0.01; // 1% de commission pour dépôt
            } elseif ($type === 'transfert') {
                return $montant * 0.02; // 2% de commission pour transfert
            }
        }

        return 0; // Aucun commission par défaut
    }

}
