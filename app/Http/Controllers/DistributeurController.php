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


        // Vérifier si user_id est un client
        $user = User::find($compte->user_id);
        if (!$user || !$user->isClient()) {
            return response()->json(['message' => 'Le compte ne correspond pas à un client valide'], 400);
        }
        // Logique pour créditer le compte
        // Ajouter le montant au solde existant
        $compte->solde += $request->montant;
        $compte->save();

        // Calculer la commission pour le distributeur (supposons un taux de 2%)
        $commission = $request->montant * 0.01; // 1% de commission

        // Enregistrer la transaction
        Transaction::create([
            'user_id' => $user->id, // ID du client
            'type' => 'depot',
            'montant' => $request->montant,
            'frais' => 0, // Ajoutez la logique pour les frais si nécessaire
            'commission' => $commission, // Ajoutez la logique pour la commission si nécessaire
            'etat' => 'terminee',
            'motif' => 'Dépôt effectué',
            'date' => now(),
        ]);

        DB::commit();

        // Si vous utilisez AJAX, renvoyez un JSON
        return redirect()->route('dashboard-distributeur')->with('message', 'Dépôt effectué avec succès. Votre commission pour cette transaction : ' . number_format($commission, 2, ',', ' ') . ' Fcfa');
    } catch (ModelNotFoundException $e) {
        DB::rollBack();
        return redirect()->route('dashboard-distributeur')->with('error', 'Compte non trouvé');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->route('dashboard-distributeur')->with('error', 'Error lors du Depôt ');
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

    // Démarrer une transaction
    DB::beginTransaction();

    try {
        // Rechercher le compte par numéro de compte
        $compte = Compte::where('numero_compte', $request->numero_compte)->firstOrFail();

        // Trouver l'utilisateur associé au compte
        $user = User::find($compte->user_id);

        // Vérifier si l'utilisateur est bien un client
        if (!$user || !$user->isClient()) {
            return redirect()->route('dashboard-distributeur')->with('error', 'Le compte ne correspond pas à un client valide');
        }

        // Vérifier si le solde est suffisant
        if ($compte->solde < $request->montant) {
            return redirect()->route('dashboard-distributeur')->with('error', 'Solde insuffisant pour effectuer ce retrait');
        }

        // Logique pour effectuer le retrait
        $compte->solde -= $request->montant;
        $compte->save(); // Enregistrer les modifications

        // Enregistrer la transaction
        Transaction::create([
            'user_id' => $user->id, // ID du client
            'type' => 'retrait',
            'montant' => $request->montant,
            'frais' => 0, // Ajoutez la logique pour les frais si nécessaire
            'commission' => 0, // Ajoutez la logique pour la commission si nécessaire
            'etat' => 'terminee',
            'motif' => 'Retrait effectué',
            'date' => now(),
        ]);

        DB::commit();

        // Redirection avec un message de succès
        return redirect()->route('dashboard-distributeur')->with('message', 'Retrait effectué avec succès');
    } catch (ModelNotFoundException $e) {
        DB::rollBack();
        return redirect()->route('dashboard-distributeur')->with('error', 'Compte non trouvé');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->route('dashboard-distributeur')->with('error', 'Erreur lors du retrait');
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
            return redirect()->route('dashboard-distributeur')->with('message', 'Les deux comptes doivent appartenir à des clients valides');
        }

        // Vérifier que le compte source a un solde suffisant
        if ($compteSource->solde < $request->montant) {
           return redirect()->route('dashboard-distributeur')->with('message','Solde insuffisant dans le compte source');
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
        return redirect()->route('dashboard-distributeur')->with('message', 'Transfert effectué avec succès. Votre commission pour cette transaction : ' . number_format($commission, 2, ',', ' ') . ' Fcfa');
    } catch (ModelNotFoundException $e) {
        DB::rollBack();
        return redirect()->route('dashboard-distributeur')->with('error', 'Compte non trouvé');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->route('dashboard-distributeur')->with('error', 'Erreur lors du transfert');
    }
}
/**
 * Historique transaction
 */
public function afficherHistorique() 
{
    try {
        // Récupérer les transactions avec les utilisateurs et les comptes
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
            ->where('users.role', 'distributeur')
            ->orderBy('transactions.created_at', 'desc')
            ->get();

        // Debug pour voir les données récupérées
        // \Log::info('Transactions récupérées:', ['count' => $transactions->count()]);
        //dd($transactions);
        return view('dashboard.dashboard-distributeur', ['transactions' => $transactions]);

    } catch (\Exception $e) {
        // \Log::error('Erreur dans afficherHistorique: ' . $e->getMessage());
        return view('dashboard.dashboard-distributeur')->with('error', 'Une erreur est survenue lors du chargement des transactions.');
    }
}
}
