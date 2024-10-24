<?php

namespace App\Http\Controllers;

use App\Models\Distributeur;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Compte;
use App\Http\Requests\Distributeur\StoreDistributeurRequest;
use App\Http\Requests\Distributeur\UpdateDistributeurRequest;
use App\Http\Resources\DistributeurResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DistributeurController extends Controller
{
    public function index(Request $request)
    {
        // Récupérer les distributeurs
        $distributeurs = User::where('role', 'distributeur')
            ->with('distributeur')
            ->when($request->input('search'), function($query, $search) {
                $query->where(function($q) use ($search) {
                    $q->where('nom', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('numero_identite', 'like', "%{$search}%");
                });
            })
            ->orderBy($request->input('sort_by', 'created_at'), $request->input('sort_direction', 'desc'))
            ->paginate($request->input('per_page', 10));

        // Calculer les statistiques
        $statistics = [
            'total_distributeurs' => User::where('role', 'distributeur')->count(),
            'total_solde' => Distributeur::sum('solde'),
            'solde_moyen' => Distributeur::avg('solde'),
            'total_distributeurs_actifs' => User::where('role', 'distributeur')
                                              ->where('etat_compte', 'actif')
                                              ->count()
        ];

        return view('dashboard.dashboard-distributeur', compact('distributeurs', 'statistics'));
    }

    public function dashboard()
    {
        $distributeur = auth()->user();
        return view('dashboard.distributeur.dashboard', compact('distributeur'));
    }

    public function store(StoreDistributeurRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $userData = $request->validated();
            
            if ($request->hasFile('photo')) {
                $photo = $request->file('photo');
                $filename = time() . '_' . $photo->getClientOriginalName();
                $path = $photo->storeAs('photos/distributeurs', $filename, 'public');
                $userData['photo'] = $path;
            }

            $userData['password'] = Hash::make($userData['password']);
            $userData['role'] = 'distributeur';
            $userData['etat_compte'] = 'actif';

            $user = User::create($userData);

            // Créer le distributeur associé
            $distributeur = $user->distributeur()->create([
                'solde' => 0
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Distributeur créé avec succès',
                'data' => $user->load('distributeur')
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($userData['photo'])) {
                Storage::disk('public')->delete($userData['photo']);
            }
            return response()->json([
                'message' => 'Erreur lors de la création du distributeur',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id): JsonResource
    {
        $user = User::where('role', 'distributeur')
                    ->with('distributeur')
                    ->findOrFail($id);
                    
        return new DistributeurResource($user);
    }

    public function update(UpdateDistributeurRequest $request, $id): JsonResponse
    {
        try {
            DB::beginTransaction();

            $user = User::where('role', 'distributeur')->findOrFail($id);
            $userData = $request->safe()->except(['solde']);

            if ($request->hasFile('photo')) {
                if ($user->photo) {
                    Storage::disk('public')->delete($user->photo);
                }
                
                $photo = $request->file('photo');
                $filename = time() . '_' . $photo->getClientOriginalName();
                $path = $photo->storeAs('photos/distributeurs', $filename, 'public');
                $userData['photo'] = $path;
            }

            if (isset($userData['password'])) {
                $userData['password'] = Hash::make($userData['password']);
            }

            $user->update($userData);

            if ($request->has('solde')) {
                $user->distributeur->update(['solde' => $request->solde]);
            }

            DB::commit();

            return response()->json([
                'message' => 'Distributeur mis à jour avec succès',
                'data' => $user->load('distributeur')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($userData['photo'])) {
                Storage::disk('public')->delete($userData['photo']);
            }
            return response()->json([
                'message' => 'Erreur lors de la mise à jour du distributeur',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            DB::beginTransaction();

            $user = User::where('role', 'distributeur')->findOrFail($id);

            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }

            $user->delete();

            DB::commit();

            return response()->json([
                'message' => 'Distributeur supprimé avec succès'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Erreur lors de la suppression du distributeur',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function crediterClient(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'numero_compte' => 'required|exists:comptes,numero',
                'montant' => 'required|numeric|min:0',
            ]);

            DB::beginTransaction();

            $compte = Compte::where('numero', $request->numero_compte)->firstOrFail();
            $client = $compte->user;

            // Vérifier si le compte est bloqué
            if ($compte->est_bloque) {
                throw new \Exception('Ce compte est bloqué');
            }

            // Vérifier que le distributeur a assez de solde
            if (auth()->user()->distributeur->solde < $request->montant) {
                throw new \Exception('Solde distributeur insuffisant');
            }

            // Calculer la commission (1%)
            $commission = $request->montant * 0.01;

            // Créer la transaction
            $transaction = Transaction::create([
                'client_id' => $client->id,
                'distributeur_id' => auth()->id(),
                'type' => 'depot',
                'montant' => $request->montant,
                'commission' => $commission,
                'etat' => 'terminee',
                'date' => now()
            ]);

            // Mettre à jour les soldes
            auth()->user()->distributeur->decrement('solde', $request->montant);
            auth()->user()->distributeur->increment('solde', $commission);
            $compte->increment('solde', $request->montant);

            DB::commit();

            return response()->json([
                'message' => 'Dépôt effectué avec succès',
                'data' => [
                    'transaction' => $transaction,
                    'nouveau_solde_client' => $compte->solde,
                    'nouveau_solde_distributeur' => auth()->user()->distributeur->solde
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function retraitClient(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'numero_compte' => 'required|exists:comptes,numero',
                'montant' => 'required|numeric|min:0',
            ]);

            DB::beginTransaction();

            $compte = Compte::where('numero', $request->numero_compte)->firstOrFail();
            $client = $compte->user;

            // Vérifier si le compte est bloqué
            if ($compte->est_bloque) {
                throw new \Exception('Ce compte est bloqué');
            }

            // Vérifier le solde du client
            if ($compte->solde < $request->montant) {
                throw new \Exception('Solde client insuffisant');
            }

            // Calculer la commission (1%)
            $commission = $request->montant * 0.01;

            // Créer la transaction
            $transaction = Transaction::create([
                'client_id' => $client->id,
                'distributeur_id' => auth()->id(),
                'type' => 'retrait',
                'montant' => $request->montant,
                'commission' => $commission,
                'etat' => 'terminee',
                'date' => now()
            ]);

            // Mettre à jour les soldes
            $compte->decrement('solde', $request->montant);
            auth()->user()->distributeur->increment('solde', $commission);

            DB::commit();

            return response()->json([
                'message' => 'Retrait effectué avec succès',
                'data' => [
                    'transaction' => $transaction,
                    'nouveau_solde_client' => $compte->solde,
                    'nouveau_solde_distributeur' => auth()->user()->distributeur->solde
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function annulerTransaction(Transaction $transaction): JsonResponse
    {
        try {
            if ($transaction->etat !== 'terminee') {
                throw new \Exception('Cette transaction ne peut pas être annulée');
            }

            if ($transaction->distributeur_id !== auth()->id()) {
                throw new \Exception('Vous ne pouvez pas annuler cette transaction');
            }

            if (now()->diffInHours($transaction->date) > 24) {
                throw new \Exception('La transaction ne peut plus être annulée (délai dépassé)');
            }

            DB::beginTransaction();

            // Récupérer le compte client
            $compte = Compte::where('user_id', $transaction->client_id)->firstOrFail();

            // Annuler la transaction selon son type
            if ($transaction->type === 'depot') {
                $compte->decrement('solde', $transaction->montant);
                auth()->user()->distributeur->increment('solde', $transaction->montant);
            } else { // retrait
                $compte->increment('solde', $transaction->montant);
            }

            // Retirer la commission du distributeur
            auth()->user()->distributeur->decrement('solde', $transaction->commission);

            // Marquer la transaction comme annulée
            $transaction->update([
                'etat' => 'annulee',
                'motif' => 'Annulée par le distributeur'
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Transaction annulée avec succès',
                'data' => [
                    'transaction' => $transaction->fresh(),
                    'nouveau_solde_distributeur' => auth()->user()->distributeur->solde
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function consulterSolde(): JsonResponse
    {
        try {
            $distributeur = auth()->user()->distributeur;
            
            return response()->json([
                'message' => 'Solde récupéré',
                'data' => [
                    'solde' => $distributeur->solde,
                    'derniere_mise_a_jour' => $distributeur->updated_at
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function historiqueTrasactions(Request $request): JsonResponse
    {
        try {
            $transactions = Transaction::where('distributeur_id', auth()->id())
                ->with(['client'])
                ->when($request->date_debut, function($query, $date) {
                    return $query->whereDate('date', '>=', $date);
                })
                ->when($request->date_fin, function($query, $date) {
                    return $query->whereDate('date', '<=', $date);
                })
                ->when($request->type, function($query, $type) {
                    return $query->where('type', $type);
                })
                ->when($request->etat, function($query, $etat) {
                    return $query->where('etat', $etat);
                })
                ->orderBy('date', 'desc')
                ->paginate($request->per_page ?? 10);

            return response()->json([
                'message' => 'Historique récupéré',
                'data' => $transactions
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function verifierCompte(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'numero_compte' => 'required|exists:comptes,numero'
            ]);

            $compte = Compte::where('numero', $request->numero_compte)
                ->with('user')
                ->firstOrFail();

            if ($compte->est_bloque) {
                throw new \Exception('Ce compte est bloqué');
            }

            return response()->json([
                'message' => 'Compte vérifié avec succès',
                'data' => [
                    'numero_compte' => $compte->numero,
                    'client' => [
                        'nom' => $compte->user->nom,
                        'prenom' => $compte->user->prenom,
                    ],
                    'solde' => $compte->solde,
                    'est_bloque' => $compte->est_bloque
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function updateSolde(Request $request, $id): JsonResponse
    {
        try {
            $request->validate([
                'montant' => 'required|numeric|min:0'
            ]);
    
            $user = User::where('role', 'distributeur')->findOrFail($id);
            $user->distributeur->update(['solde' => $request->montant]);
    
            return response()->json([
                'message' => 'Solde mis à jour avec succès',
                'data' => $user->load('distributeur')
            ]);
    
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la mise à jour du solde',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}