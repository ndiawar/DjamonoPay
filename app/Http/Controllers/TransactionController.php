<?php

namespace App\Http\Controllers;

use App\Http\Requests\Transaction\StoreTransactionRequest;
use App\Http\Requests\Transaction\UpdateTransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Exception;
use Illuminate\Support\Facades\Auth;

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
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de l\'annulation de la transaction : ' . $e->getMessage());
        }
    }

    
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
    }public function index()
    {
        return $this->bilanGlobal();
    }
    public function bilanGlobal()
    {
        try {
            // Récupérer toutes les transactions
            $transactions = Transaction::all();
        
            // Vérification de la récupération des transactions
            if ($transactions->isEmpty()) {
                throw new Exception('Aucune transaction trouvée.');
            }
        
            // Calculer le montant total
            $totalMontant = $transactions->sum('montant');
        
            // Calculer les transactions terminées et annulées
            $totalTerminees = $transactions->where('etat', 'terminee')->sum('montant');
            $totalAnnulees = $transactions->where('etat', 'annulee')->sum('montant');
        
            // Calculer le total des envois et des retraits
            $totalEnvois = $transactions->where('type', 'depot')->sum('montant');
            $totalRetraits = $transactions->where('type', 'retrait')->sum('montant');
        
            // Calculer les montants journaliers, hebdomadaires et mensuels
            $montantJournalier = Transaction::whereDate('created_at', now())->sum('montant');
            $montantHebdomadaire = Transaction::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->sum('montant');
            $montantMensuel = Transaction::whereMonth('created_at', now()->month)->sum('montant');
        
            // Récupérer les 5 transactions les plus récentes
            $transactionsRecentes = Transaction::orderBy('created_at', 'desc')->take(5)->get();
        
            // Calculer les pourcentages
            $pourcentageTerminees = $totalMontant > 0 ? ($totalTerminees / $totalMontant) * 100 : 0;
            $pourcentageAnnulees = $totalMontant > 0 ? ($totalAnnulees / $totalMontant) * 100 : 0;
    
            // Récupérer les transactions par mois
            $transactionsParMois = Transaction::selectRaw('MONTH(date) as month, YEAR(date) as year, SUM(montant) as total')
                ->groupBy('month', 'year')
                ->orderBy('year')
                ->orderBy('month')
                ->get();
    
            // Préparer les données pour le graphique
            $months = [];
            $totals = [];
            
            foreach ($transactionsParMois as $transaction) {
                $months[] = Carbon::createFromFormat('m', $transaction->month)->format('F Y'); // Nom du mois et année
                $totals[] = $transaction->total;
            }
    
            // Passer les données à la vue
            return view('dashboard.index', compact(
                'totalMontant', 
                'pourcentageTerminees', 
                'pourcentageAnnulees', 
                'totalEnvois', 
                'totalRetraits', 
                'montantJournalier', 
                'montantHebdomadaire', 
                'montantMensuel',
                'transactionsRecentes', // Ajouter ici
                'months', // Ajouter ici pour le graphique
                'totals' // Ajouter ici pour le graphique
            ));
        } catch (QueryException $e) {
            logger('Erreur de requête: ' . $e->getMessage());
            return view('dashboard.index', compact('totalMontant', 'totalEnvois', 'totalRetraits', 'montantJournalier', 'montantHebdomadaire', 'montantMensuel'));
        } catch (Exception $e) {
            logger('Erreur générale: ' . $e->getMessage());
            return view('dashboard.index', compact('totalMontant', 'totalEnvois', 'totalRetraits', 'montantJournalier', 'montantHebdomadaire', 'montantMensuel'));
        }
    }

    public function afficherHistorique(Request $request)
    {
        try {
            // Récupérer toutes les transactions avec leurs informations associées
            $query = Transaction::join('users', 'transactions.user_id', '=', 'users.id')
                ->join('comptes', 'users.id', '=', 'comptes.user_id')
                ->select([
                    'transactions.id',
                    'transactions.type as type_transaction',
                    'transactions.montant',
                    'transactions.created_at',
                    'users.nom',
                    'users.adresse',
                    'users.numero_identite',
                    'users.prenom',
                    'users.photo',
                    'comptes.numero_compte'
                ])
                ->where('users.role', 'distributeur')
                ->orderBy('transactions.created_at', 'desc');
    
            // Appliquer un filtre de type de transaction si spécifié
            if ($request->has('type_transaction') && $request->type_transaction != '') {
                $query->where('transactions.type', $request->type_transaction);
            }
    
            $transactions = $query->get();
    
            // Calcul des totaux par type de transaction
            $totalDepot = $transactions->where('type_transaction', 'depot')->sum('montant');
            $totalRetrait = $transactions->where('type_transaction', 'retrait')->sum('montant');
            $totalTransfert = $transactions->where('type_transaction', 'transfert')->sum('montant');
    
            // Calcul du solde global (exemple : dépôts - retraits)
            $solde = $totalDepot - $totalRetrait;
    
            return view('dashboard.dashboard-transactions', [
                'transactions' => $transactions,
                'solde' => $solde,
                'totalDepot' => $totalDepot,
                'totalRetrait' => $totalRetrait,
                'totalTransfert' => $totalTransfert,
            ]);
    
        } catch (Exception $e) {
            return view('dashboard.dashboard-transactions')
                ->with('error', 'Une erreur est survenue lors du chargement des transactions.');
        }
    }
    
    }
    



