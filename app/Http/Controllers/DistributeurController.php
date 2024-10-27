<?php

namespace App\Http\Controllers;

use App\Http\Requests\Distributeur\StoreDistributeurRequest;
use App\Http\Requests\Distributeur\UpdateDistributeurRequest;
use App\Http\Resources\DistributeurResource;
use App\Http\Resources\DistributeurCollection;
use App\Http\Resources\TransactionCollection;
use App\Models\Client;
use App\Models\Compte;
use App\Models\Distributeur;
use App\Models\Transaction;
use App\Models\User;
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

    public function crediterCompteClient(Request $request)
    {
        $request->validate([
            'numero_compte' => 'required|string',
            'montant' => 'required|numeric|min:0.01'
        ]);
        // dd($request->all());
        
        DB::beginTransaction();

        try {
            // Rechercher le compte par numéro de compte
            $compte = Compte::where('numero_compte', $request->numero_compte)->firstOrFail();
           

            // Logique pour créditer le compte
            // Ajouter le montant au solde existant
            $compte->solde += $request->montant;
            $compte->save();

            DB::commit();
            return response()->json(['message' => 'Crédit effectué avec succès']);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['message' => 'Compte non trouvé'], 404);
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
    // Validation des données entrantes
    $request->validate(['montant' => 'required|numeric|min:0.01']);

    // Démarrer une transaction
    DB::beginTransaction();

    try {
        // Trouver le client par son ID
        $client = Client::findOrFail($clientId);

        // Supposons que le client a un compte avec un solde
        $compte = $client->compte; // Assurez-vous que la relation est définie dans le modèle Client

        // Vérifier si le solde est suffisant
        if ($compte->solde < $request->montant) {
            return response()->json(['message' => 'Solde insuffisant pour effectuer ce retrait'], 400);
        }

        // Logique pour effectuer le retrait
        // Déduire le montant du solde existant
        $compte->solde -= $request->montant;
        $compte->save(); // Enregistrer les modifications

        DB::commit(); // Valider la transaction
        return response()->json(['message' => 'Retrait effectué avec succès']);
    } catch (ModelNotFoundException $e) {
        DB::rollBack(); // Annuler la transaction en cas d'erreur
        return response()->json(['message' => 'Client non trouvé'], 404);
    } catch (\Exception $e) {
        DB::rollBack(); // Annuler la transaction en cas d'erreur générale
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

    public function afficherDistributeurs()
    {
        // Sélectionner les utilisateurs ayant le rôle de distributeur et leurs comptes
        $distributeurs = User::where('role', 'distributeur')
                             ->with('comptes')
                             ->get();
        
        // Récupérer la somme des soldes de tous les comptes
        $totalCredits = Compte::sum('solde');

        return view('dashboard.dashboard-approvisionner', compact('distributeurs', 'totalCredits'));
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
