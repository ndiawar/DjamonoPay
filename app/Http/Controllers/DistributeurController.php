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
 * Crediter le compte du client
 */
    

 public function crediterCompteClient(Request $request)
 {
     // Validation des données d'entrée
     $request->validate([
         'numero_compte' => 'required|string',
         'montant' => 'required|numeric|min:0.01',
     ]);
 
     DB::beginTransaction();
 
     try {
         // Rechercher le compte par numéro de compte
         $compte = Compte::where('numero_compte', $request->numero_compte)->firstOrFail();
 
         // Vérifier si l'utilisateur associé est un client
         $user = User::find($compte->user_id);
         if (!$user || !$user->isClient()) {
             return response()->json(['message' => 'Le compte ne correspond pas à un client valide'], 400);
         }
 
         // Logique pour créditer le compte client
         $compte->solde += $request->montant;
         $compte->save();
 
         // Calculer la commission du distributeur (1% par exemple)
         $commission = $request->montant * 0.01;
 
         // Déduire la commission du solde du distributeur connecté
         $distributeur = auth()->user();
         $compteDistributeur = Compte::where('user_id', $distributeur->id)->firstOrFail();
 
         if ($compteDistributeur->solde < $commission) {
             DB::rollBack();
             return redirect()->route('distributeurs.afficher_Historique')->with('error', 'Solde insuffisant du distributeur pour couvrir la commission.');
         }
 
         $compteDistributeur->solde -= $commission;
         $compteDistributeur->save();
 
         // Enregistrer la transaction
         Transaction::create([
             'user_id' => $user->id,
             'type' => 'depot',
             'montant' => $request->montant,
             'frais' => 0,
             'commission' => $commission,
             'etat' => 'terminee',
             'motif' => 'Dépôt effectué',
             'date' => now(),
         ]);
 
         DB::commit();
 
         return redirect()->route('distributeurs.afficher_Historique')
                          ->with('message', 'Dépôt effectué avec succès. Votre commission pour cette transaction : ' . number_format($commission, 2, ',', ' ') . ' Fcfa');
 
     } catch (ModelNotFoundException $e) {
         DB::rollBack();
         return redirect()->route('distributeurs.afficher_Historique')->with('error', 'Compte non trouvé');
     } catch (\Exception $e) {
         DB::rollBack();
         return redirect()->route('distributeurs.afficher_Historique')->with('error', 'Erreur lors du dépôt.');
     }
 }
 

/**
 * Effectue un retrait sur le compte du client.
 */
public function effectuerRetrait(Request $request)
{
    // Validation des données entrantes
    $request->validate([
        'numero_compte' => 'required|string',
        'montant' => 'required|numeric|min:0.01',
    ]);

    // Démarrer une transaction SQL
    DB::beginTransaction();

    try {
        // 1. Rechercher le compte du client par numéro de compte
        $compteClient = Compte::where('numero_compte', $request->numero_compte)->firstOrFail();

        // 2. Trouver l'utilisateur associé au compte
        $client = User::find($compteClient->user_id);

        // 3. Vérifier si l'utilisateur est bien un client
        if (!$client || !$client->isClient()) {
            return redirect()->route('distributeurs.afficher_Historique')->with('error', 'Compte invalide ou utilisateur non client.');
        }

        // 4. Vérifier si le solde du client est suffisant
        if ($compteClient->solde < $request->montant) {
            return redirect()->route('distributeurs.afficher_Historique')->with('error', 'Solde insuffisant sur le compte du client.');
        }

        // 5. Récupérer le compte du distributeur connecté
        $distributeur = auth()->user();
        $compteDistributeur = Compte::where('user_id', $distributeur->id)->first();

        // 6. Vérifier si le distributeur a un solde suffisant pour effectuer l'opération
        if ($compteDistributeur->solde < $request->montant) {
            return redirect()->route('distributeurs.afficher_Historique')->with('error', 'Solde insuffisant du distributeur.');
        }

        // 7. Effectuer le retrait sur le compte du client
        $compteClient->solde -= $request->montant;
        $compteClient->save();

        // 8. Déduire également le montant du solde du distributeur
        $compteDistributeur->solde -= $request->montant;
        $compteDistributeur->save();

        // 9. Enregistrer la transaction dans la base de données
        Transaction::create([
            'user_id' => $client->id,  // ID du client
            'type' => 'retrait',
            'montant' => $request->montant,
            'frais' => 0, // Ajoutez la logique pour les frais si nécessaire
            'commission' => 0, // Ajoutez la logique pour la commission si nécessaire
            'etat' => 'terminee',
            'motif' => 'Retrait effectué par distributeur',
            'date' => now(),
        ]);

        // 10. Valider la transaction SQL
        DB::commit();

        // 11. Redirection avec un message de succès
        return redirect()->route('distributeurs.afficher_Historique')->with('message', 'Retrait effectué avec succès.');

    } catch (ModelNotFoundException $e) {
        DB::rollBack();
        return redirect()->route('distributeurs.afficher_Historique')->with('error', 'Compte non trouvé.');
    } catch (\Exception $e) {
        DB::rollBack();
        // \Log::error('Erreur lors du retrait: ' . $e->getMessage());
        return redirect()->route('distributeurs.afficher_Historique')->with('error', 'Erreur lors du retrait.');
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
            $transaction->etat = 'annulee';
            $transaction->save();

            return redirect()->back()->with('success', 'Transaction annulée avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de l\'annulation de la transaction : ' . $e->getMessage());
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
    /**
     * Transfert entre deux clients effectuer par le distributeur
     *
     */
    public function transfererEntreClients(Request $request)
{
    // Valider les données d'entrée
    $request->validate([
        'numero_compte_source' => 'required|string',
        'numero_compte_destination' => 'required|string',
        'montant' => 'required|numeric|min:0.01',
    ]);

    DB::beginTransaction();

    try {
        // Rechercher les comptes source et destination
        $compteSource = Compte::where('numero_compte', $request->numero_compte_source)->firstOrFail();
        $compteDestination = Compte::where('numero_compte', $request->numero_compte_destination)->firstOrFail();

        // Récupérer les utilisateurs associés aux comptes
        $userSource = User::findOrFail($compteSource->user_id);
        $userDestination = User::findOrFail($compteDestination->user_id);

        // Vérifier que les deux utilisateurs sont des clients
        if (!$userSource->isClient() || !$userDestination->isClient()) {
            return redirect()->route('distributeurs.afficher_Historique')->with('message', 'Les deux comptes doivent appartenir à des clients valides');
        }

        // Vérifier que le compte source a un solde suffisant
        if ($compteSource->solde < $request->montant) {
           return redirect()->route('distributeurs.afficher_Historique')->with('message','Solde insuffisant dans le compte source');
        }

        // Calculer la commission (1 % du montant transféré)
        $commission = $request->montant * 0.01;

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
        return redirect()->route('distributeurs.afficher_Historique')->with('message', 'Transfert effectué avec succès. Votre commission pour cette transaction : ' . number_format($commission, 2, ',', ' ') . ' Fcfa');
    } catch (ModelNotFoundException $e) {
        DB::rollBack();
        return redirect()->route('distributeurs.afficher_Historique')->with('error', 'Compte non trouvé');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->route('distributeurs.afficher_Historique')->with('error', 'Erreur lors du transfert');
    }
}
/**
 * Historique transaction
 */
public function afficherHistorique() 
{
    try {
        // Récupérer l'utilisateur connecté (distributeur)
        $distributeur = auth()->user();

        // Vérifier que l'utilisateur est bien connecté et a le rôle distributeur
        if (!$distributeur || $distributeur->role !== 'distributeur') {
            return redirect()->back()->with('error', 'Accès non autorisé.');
        }

        // Récupérer le compte associé au distributeur connecté
        $compte = Compte::where('user_id', $distributeur->id)->first();

        // Vérifier si le compte existe
        if (!$compte) {
            return redirect()->back()->with('error', 'Aucun compte associé trouvé.');
        }

        // Récupérer le solde du compte
        $solde = $compte->solde;

        // Récupérer les transactions effectuées par le distributeur connecté
        $transactions = Transaction::join('users', 'transactions.user_id', '=', 'users.id')
            ->join('comptes', 'users.id', '=', 'comptes.user_id')
            ->select([
                'transactions.id', 
                'transactions.type as type_transaction',
                'transactions.montant',
                'transactions.created_at',
                'users.nom',
                'users.prenom',
                'users.photo',
                'comptes.numero_compte'
            ])
            // Filtrer par l'ID du distributeur dans les transactions
            ->where('transactions.user_id', $distributeur->id) // Changez ceci pour filtrer par le user_id des transactions
            ->orderBy('transactions.created_at', 'desc')
            ->get();

        // Passer les transactions et le solde à la vue
        return view('dashboard.dashboard-distributeur', [
            'transactions' => $transactions,
            'solde' => $solde
        ]);

    } catch (\Exception $e) {
        // Gestion des erreurs
       // \Log::error('Erreur dans afficherHistorique: ' . $e->getMessage());
        return view('dashboard.dashboard-distributeur')
            ->with('error', 'Une erreur est survenue lors du chargement des transactions.');
    }
}


}
