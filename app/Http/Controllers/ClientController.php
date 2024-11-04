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
use Illuminate\Support\Facades\Auth;


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

    /**
     * Transfert entre deux clients effectué par un client
     */
    public function transfertEntreClients(Request $request)
    {
        // Valider les données d'entrée
        $request->validate([
            'numero_compte_destination' => 'required|string|exists:comptes,numero_compte',
            'montant' => 'required|numeric|min:0.01',
        ]);

        DB::beginTransaction();

        try {
            // Récupérer le compte source (de l'utilisateur connecté)
            $compteSource = Compte::where('user_id', auth()->id())->firstOrFail();
   
    $request->validate([
        'numero_compte_destination' => 'required|string|exists:comptes,numero_compte',
        'montant' => 'required|numeric|min:0.01',
    ]);

            // Récupérer le compte destinataire
            $compteDestination = Compte::where('numero_compte', $request->numero_compte_destination)->firstOrFail();

            // Vérifier si le compte source et le compte destinataire sont identiques
            if ($compteSource->user_id === $compteDestination->user_id) {
                return back()->with('warning', 'Vous ne pouvez pas transférer de l\'argent vers votre propre compte.');
            }

            // Vérifier le solde du compte source
            if ($compteSource->solde < $request->montant) {
                return back()->with('message', 'Solde insuffisant dans le compte source.');
            }

            // Calcul des frais (2%) et du montant net à transférer
            $commission = $request->montant * 0.02;
            $montantNet = $request->montant - $commission;

            // Mettre à jour les soldes
            $compteSource->solde -= $request->montant;
            $compteSource->save();

            $compteDestination->solde += $montantNet;
            $compteDestination->save();

            // Enregistrer les transactions
            Transaction::create([
                'user_id' => $compteSource->user_id,
                'type' => 'retrait',
                'montant' => $request->montant,
                'frais' => $commission,
                'etat' => 'terminee',
                'motif' => 'Transfert vers ' . $compteDestination->numero_compte,
                'date' => now(),
            ]);

            Transaction::create([
                'user_id' => $compteDestination->user_id,
                'type' => 'depot',
                'montant' => $montantNet,
                'etat' => 'terminee',
                'motif' => 'Transfert depuis ' . $compteSource->numero_compte,
                'date' => now(),
            ]);

            DB::commit();

            // Récupérer le type de transaction à filtrer (s'il existe)
            $typeTransaction = $request->query('type_transaction');

            // Récupérer les transactions avec un filtre optionnel
            $transactions = Transaction::when($typeTransaction, function ($query, $typeTransaction) {
                return $query->where('type_transaction', $typeTransaction);
            })->get();

            // Retourner la vue avec les transactions filtrées
            return view('dashboard.dashboard-client', compact('transactions'))
                ->with('message', 'Transfert effectué avec succès.');

        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return back()->with('error', 'Compte non trouvé: ' . $e->getMessage());
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors du transfert: ' . $e->getMessage());
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
        // Récupérer le client connecté
        $client = Auth::user();

        // Récupérer les transactions de transfert ou réception spécifiques au client connecté
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
            ->where('users.id', $client->id) // Filtrer par ID du client connecté
            ->whereIn('transactions.type', ['transfert', 'reception','annule']) // Filtrer les types de transactions
            ->orderBy('transactions.created_at', 'desc')
            ->get();

        // Vérifier si le client a un compte et récupérer le solde
        $compte = Compte::where('user_id', $client->id)->first();
        $solde = $compte ? $compte->solde : 0; // Assurez-vous que le compte existe

        // Renvoyer la vue pour les clients
        return view('dashboard.dashboard-client', [
            'transactions' => $transactions,
            'solde' => $solde // Passer le solde à la vue
        ]);

    } catch (\Exception $e) {
        // Journaliser l'erreur
        return view('dashboard.dashboard-client')->with('error', 'Une erreur est survenue lors du chargement des transactions.');
    }
}



}
