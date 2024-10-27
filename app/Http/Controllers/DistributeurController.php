<?php

namespace App\Http\Controllers;

use App\Http\Requests\Distributeur\StoreDistributeurRequest;
use App\Http\Requests\Distributeur\UpdateDistributeurRequest;
use App\Http\Resources\DistributeurResource;
use App\Http\Resources\DistributeurCollection;
use App\Http\Resources\TransactionCollection;
use App\Models\Client;
use App\Models\Distributeur;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DistributeurController extends Controller
{
    /**
     * Affiche tous les distributeurs.
     */
  /**
 * Affiche tous les distributeurs.
 */
    public function index(Request $request)
    {
        $distributeurs = Distributeur::paginate(10);
        return view('dashboard.dashboard-distributeur', compact('distributeurs'));
    }

    /**
     * Affiche un distributeur spécifique.
     */
    public function show(Distributeur $distributeur)
    {
        return new DistributeurResource($distributeur->load('transactions'));
    }

    /**
     * Enregistre un nouveau distributeur.
     */
    public function store(StoreDistributeurRequest $request)
    {
        $validated = $request->validated();
        $distributeur = Distributeur::create($validated);
        return new DistributeurResource($distributeur);
    }

    /**
     * Met à jour un distributeur existant.
     */
    public function update(UpdateDistributeurRequest $request, Distributeur $distributeur)
    {
        $validated = $request->validated();
        $distributeur->update($validated);
        return new DistributeurResource($distributeur);
    }

    /**
     * Supprime un distributeur.
     */
    public function destroy(Distributeur $distributeur)
    {
        $distributeur->delete();
        return response()->json(['message' => 'Distributeur supprimé avec succès'], 200);
    }

    /**
     * Consulte le solde total d'un client.
     */
    public function consulterSolde(Request $request, $clientId)
    {
        try {
            $client = Distributeur::findOrFail($clientId);
            $soldeTotal = $client->comptes()->sum('solde');
            return response()->json(['solde_total' => $soldeTotal]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Distributeur non trouvé'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erreur lors de la récupération du solde'], 500);
        }
    }

    /**
     * Crédite un compte client.
     */
    public function crediterCompteClient(Request $request, $clientId)
    {
        $request->validate(['montant' => 'required|numeric|min:0.01']);
        DB::beginTransaction();

        try {
            $client = Client::findOrFail($clientId);
            // Logique pour créditer le compte
            // Exemple : mettre à jour le solde des comptes
            // Assurez-vous de mettre à jour la transaction

            DB::commit();
            return response()->json(['message' => 'Crédit effectué avec succès']);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['message' => 'Client non trouvé'], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Erreur lors du crédit'], 500);
        }
    }

    /**
     * Effectue un retrait sur le compte du client.
     */
    public function effectuerRetrait(Request $request, $clientId)
    {
        $request->validate(['montant' => 'required|numeric|min:0.01']);
        DB::beginTransaction();

        try {
            $client = Client::findOrFail($clientId);
            // Logique pour effectuer le retrait
            // Exemple : déduire du solde des comptes

            DB::commit();
            return response()->json(['message' => 'Retrait effectué avec succès']);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['message' => 'Client non trouvé'], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Erreur lors du retrait'], 500);
        }
    }

    /**
     * Voir le solde d'un distributeur.
     */
    public function voirSolde(Distributeur $distributeur)
    {
        $solde = $distributeur->comptes()->sum('solde');
        return response()->json(['solde' => $solde]);
    }

    /**
     * Voir les transactions d'un distributeur.
     */
    public function voirTransactions(Distributeur $distributeur)
    {
        $transactions = $distributeur->transactions()->paginate();
        return new TransactionCollection($transactions);
    }

    /**
     * Annule une transaction.
     */
    public function annulerTransaction(Request $request, Transaction $transaction)
    {
        try {
            $transaction->etat = 'annulé';
            $transaction->save();
            return response()->json(['message' => 'Transaction annulée avec succès'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erreur lors de l\'annulation de la transaction'], 500);
        }
    }

    /**
     * Scanner un QR Code.
     */
    public function scannerQRCode(Request $request)
    {
        // Logique pour scanner et vérifier le QR Code
        // Par exemple, récupérer le QR Code depuis le request et valider
        return response()->json(['message' => 'QR Code scanné avec succès']);
    }
}
