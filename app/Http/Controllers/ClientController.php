<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClientResource;
use App\Models\Client;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Resources\TransactionCollection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    /**
     * Affiche un client spécifique avec ses comptes et transactions.
     */
    public function show(Client $client)
    {
        return new ClientResource($client->load('comptes', 'transactions'));
    }

    /**
     * Voir le solde total du client.
     */
    public function voirSolde(Client $client)
    {
        try {
            $soldeTotal = $client->comptes()->sum('solde');
            return response()->json(['solde_total' => $soldeTotal]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erreur lors de la récupération du solde'], 500);
        }
    }

    /**
     * Masquer le solde du client.
     */
    public function masquerSolde(Client $client)
    {
        // Logique pour masquer le solde
        return response()->json(['message' => 'Solde masqué']);
    }

    /**
     * Faire un transfert d'argent.
     */
    public function faireTransfert(Request $request, Client $client)
    {
        $request->validate([
            'montant' => 'required|numeric|min:0.01',
            'destinataire_id' => 'required|exists:clients,id',
        ]);

        DB::beginTransaction();

        try {
            $destinataire = Client::findOrFail($request->destinataire_id);

            // Vérifiez si le client a suffisamment de solde
            $soldeTotal = $client->comptes()->sum('solde');
            if ($soldeTotal < $request->montant) {
                return response()->json(['message' => 'Solde insuffisant pour le transfert'], 400);
            }

            // Enregistrer la transaction
            Transaction::create([
                'client_id' => $client->id,
                'distributeur_id' => null, // Ou un ID spécifique si applicable
                'type' => 'transfert',
                'montant' => $request->montant,
                'etat' => 'terminée',
            ]);

            // Logique pour mettre à jour les soldes
            // Débiter et créditer ici selon votre logique

            DB::commit();

            return response()->json(['message' => 'Transfert effectué avec succès']);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['message' => 'Destinataire non trouvé'], 404);
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json(['message' => 'Erreur de validation'], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Erreur lors du transfert'], 500);
        }
    }

    /**
     * Voir les transactions du client.
     */
    public function voirTransactions(Client $client)
    {
        $transactions = $client->transactions()->paginate();
        return new TransactionCollection($transactions);
    }
}
