<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClientResource;
use App\Models\Client;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Resources\TransactionCollection;
use App\Models\Compte;
use App\Models\User;
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
 * Transfert entre deux clients effectué par un client
 *
 */
public function transfertEntreClients(Request $request)
{
    // Valider les données d'entrée
    $request->validate([
        'numero_compte_source' => 'required|string',
        'numero_compte_destination' => 'required|string',
        'montant' => 'required|numeric|min:0.01',
    ]);

    DB::beginTransaction();

    try {
        // Récupérer le compte source de l'utilisateur authentifié
        $compteSource = Compte::where('numero_compte', $request->numero_compte_source)->firstOrFail();
        // $compteSource = Compte::where('user_id', auth()->id())->firstOrFail();

        // Rechercher le compte de destination
        $compteDestination = Compte::where('numero_compte', $request->numero_compte_destination)->firstOrFail();

        // Récupérer les utilisateurs associés aux comptes
        $userSource = User::findOrFail($compteSource->user_id);
        $userDestination = User::findOrFail($compteDestination->user_id);

        // Vérifier que le compte source appartient à un client
        if (!$userSource->isClient()) {
            return redirect()->route('clients.afficher_Historiques_clients')->with('message', 'Le compte source doit appartenir à un client valide');
        }

        // Vérifier que le compte source a un solde suffisant
        if ($compteSource->solde < $request->montant) {
            return redirect()->route('clients.afficher_Historiques_clients')->with('message', 'Solde insuffisant dans le compte source');
        }

        // Calculer la commission (2 % du montant transféré)
        $commission = $request->montant * 0.02;

        // Effectuer le transfert en déduisant le montant du compte source
        $montantNet = $request->montant - $commission;
        $compteSource->solde -= $request->montant;
        $compteSource->save();

        // Créditez le montant net au compte de destination
        $compteDestination->solde += $montantNet;
        $compteDestination->save();

        // Enregistrer les transactions
        Transaction::create([
            'user_id' => $userSource->id,
            'type' => 'retrait',
            'montant' => $request->montant,
            'frais' => $commission, // Ajoutez la logique pour les frais si nécessaire
            'commission' => $commission,
            'etat' => 'terminee',
            'motif' => 'Transfert vers le compte ' . $compteDestination->numero_compte,
            'date' => now(),
        ]);

        Transaction::create([
            'user_id' => $userDestination->id,
            'type' => 'depot',
            'montant' => $request->montant,
            'frais' => 0,
            'commission' => 0,
            'etat' => 'terminee',
            'motif' => 'Transfert depuis le compte ' . $compteSource->numero_compte,
            'date' => now(),
        ]);

        DB::commit();

        // Redirection avec message de succès
        return redirect()->route('clients.afficher_Historiques_clients')->with('message', 'Transfert effectué avec succès. Votre commission pour cette transaction : ' . number_format($commission, 2, ',', ' ') . ' Fcfa');
    } catch (ModelNotFoundException $e) {
        DB::rollBack();
        return redirect()->route('clients.afficher_Historiques_clients')->with('error', 'Compte non trouvé');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->route('clients.afficher_Historiques_clients')->with('error', 'Erreur lors du transfert');
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

    /**
 * Historique transaction
 */
public function afficherHistoriqueClients() 
{
    try {
        // Récupérer les transactions des clients avec les clients et les comptes
        $transactions = Transaction::join('users', 'transactions.user_id', '=', 'users.id')
            ->join('comptes', 'users.id', '=', 'comptes.user_id')
            ->select([
                'transactions.id', // Ajout de l'ID pour les modales
                'transactions.type as type_transaction',
                'transactions.montant',
                'transactions.created_at',
                'users.nom',
                'users.prenom',
                'users.photo',
                'comptes.numero_compte'
            ])
            ->where('users.role', 'client') // Filtrer les clients
            ->orderBy('transactions.created_at', 'desc')
            ->get();

        // Déboguer pour vérifier les données récupérées
        // \Log::info('Transactions clients récupérées:', ['count' => $transactions->count()]);
        // dd($transactions);

        // Renvoyer la vue pour les clients (modifiez le nom de la vue si nécessaire)
        return view('dashboard.dashboard-client', ['transactions' => $transactions]);

    } catch (\Exception $e) {
        // Journaliser l'erreur
        // \Log::error('Erreur dans afficherHistoriqueClients: ' . $e->getMessage());
        return view('dashboard.dashboard-client')->with('error', 'Une erreur est survenue lors du chargement des transactions.');
    }
}

}
