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
use App\Enums\UserRole;
use Illuminate\Http\Resources\Json\JsonResource;

class DistributeurController extends Controller
{
    public function index(Request $request)
    {
        $distributeurs = User::where('role', UserRole::DISTRIBUTEUR)
            ->with(['distributeur', 'compte'])
            ->when($request->input('search'), function($query, $search) {
                $query->where(function($q) use ($search) {
                    $q->where('nom', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('numero_identite', 'like', "%{$search}%");
                });
            })
            ->orderBy($request->input('sort_by', 'created_at'), $request->input('sort_direction', 'desc'))
            ->paginate($request->input('per_page', 10));

        $statistics = [
            'total_distributeurs' => User::where('role', UserRole::DISTRIBUTEUR)->count(),
            'total_solde_commission' => Distributeur::sum('solde'),
            'total_solde_compte' => User::where('role', UserRole::DISTRIBUTEUR)
                ->join('comptes', 'users.id', '=', 'comptes.user_id')
                ->sum('comptes.solde'),
            'solde_moyen_commission' => Distributeur::avg('solde'),
            'total_distributeurs_actifs' => User::where('role', UserRole::DISTRIBUTEUR)
                                              ->where('etat_compte', 'actif')
                                              ->count()
        ];

        return view('dashboard.dashboard-distributeur', compact('distributeurs', 'statistics'));
    }

    public function dashboard()
{
    // Récupérer l'utilisateur connecté avec ses relations
    $distributeur = User::with(['distributeur', 'compte'])
        ->where('id', auth()->id())
        ->where('role', 'distributeur')
        ->firstOrFail();

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
            $userData['role'] = UserRole::DISTRIBUTEUR;
            $userData['etat_compte'] = 'actif';

            $user = User::create($userData);

            // Créer le compte
            $compte = Compte::createWithNumber([
                'solde' => 0,
                'est_bloque' => false
            ], $user);

            // Créer le distributeur
            $distributeur = $user->distributeur()->create([
                'solde' => 0,
                'compte_id' => $compte->id
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Distributeur créé avec succès',
                'data' => $user->load(['distributeur', 'compte'])
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
        $user = User::where('role', UserRole::DISTRIBUTEUR)
                    ->with(['distributeur', 'compte'])
                    ->findOrFail($id);
                    
        return new DistributeurResource($user);
    }

    public function update(UpdateDistributeurRequest $request, $id): JsonResponse
    {
        try {
            DB::beginTransaction();

            $user = User::where('role', UserRole::DISTRIBUTEUR)->findOrFail($id);
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

            DB::commit();

            return response()->json([
                'message' => 'Distributeur mis à jour avec succès',
                'data' => $user->load(['distributeur', 'compte'])
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

            $user = User::where('role', UserRole::DISTRIBUTEUR)->findOrFail($id);

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

            $compteClient = Compte::where('numero', $request->numero_compte)->firstOrFail();
            $compteDistributeur = auth()->user()->distributeur->compte;
            $distributeur = auth()->user()->distributeur;

            // Vérifications
            if ($compteClient->est_bloque) {
                throw new \Exception('Le compte client est bloqué');
            }

            if ($compteDistributeur->est_bloque) {
                throw new \Exception('Votre compte est bloqué');
            }

            if ($compteDistributeur->solde < $request->montant) {
                throw new \Exception('Votre solde est insuffisant');
            }

            // Calculer la commission (1%)
            $commission = $request->montant * 0.01;

            // Créer la transaction
            $transaction = Transaction::create([
                'client_id' => $compteClient->user_id,
                'distributeur_id' => auth()->id(),
                'type' => 'depot',
                'montant' => $request->montant,
                'commission' => $commission,
                'etat' => 'terminee',
                'date' => now()
            ]);

            // Mettre à jour les soldes
            $compteDistributeur->decrement('solde', $request->montant);
            $compteClient->increment('solde', $request->montant);
            $distributeur->increment('solde', $commission); // Commission

            DB::commit();

            return response()->json([
                'message' => 'Dépôt effectué avec succès',
                'data' => [
                    'transaction' => $transaction,
                    'solde_compte' => $compteDistributeur->fresh()->solde,
                    'solde_commission' => $distributeur->fresh()->solde,
                    'solde_client' => $compteClient->fresh()->solde
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

            $compteClient = Compte::where('numero', $request->numero_compte)->firstOrFail();
            $compteDistributeur = auth()->user()->distributeur->compte;
            $distributeur = auth()->user()->distributeur;

            // Vérifications
            if ($compteClient->est_bloque) {
                throw new \Exception('Le compte client est bloqué');
            }

            if ($compteDistributeur->est_bloque) {
                throw new \Exception('Votre compte est bloqué');
            }

            if ($compteClient->solde < $request->montant) {
                throw new \Exception('Solde client insuffisant');
            }

            // Calculer la commission (1%)
            $commission = $request->montant * 0.01;

            // Créer la transaction
            $transaction = Transaction::create([
                'client_id' => $compteClient->user_id,
                'distributeur_id' => auth()->id(),
                'type' => 'retrait',
                'montant' => $request->montant,
                'commission' => $commission,
                'etat' => 'terminee',
                'date' => now()
            ]);

            // Mettre à jour les soldes
            $compteClient->decrement('solde', $request->montant);
            $compteDistributeur->increment('solde', $request->montant);
            $distributeur->increment('solde', $commission); // Commission

            DB::commit();

            return response()->json([
                'message' => 'Retrait effectué avec succès',
                'data' => [
                    'transaction' => $transaction,
                    'solde_compte' => $compteDistributeur->fresh()->solde,
                    'solde_commission' => $distributeur->fresh()->solde,
                    'solde_client' => $compteClient->fresh()->solde
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

            $compteClient = Compte::where('user_id', $transaction->client_id)->firstOrFail();
            $compteDistributeur = auth()->user()->distributeur->compte;
            $distributeur = auth()->user()->distributeur;

            // Annuler la transaction selon son type
            if ($transaction->type === 'depot') {
                $compteClient->decrement('solde', $transaction->montant);
                $compteDistributeur->increment('solde', $transaction->montant);
            } else { // retrait
                $compteClient->increment('solde', $transaction->montant);
                $compteDistributeur->decrement('solde', $transaction->montant);
            }

            // Retirer la commission
            $distributeur->decrement('solde', $transaction->commission);

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
                    'solde_compte' => $compteDistributeur->fresh()->solde,
                    'solde_commission' => $distributeur->fresh()->solde
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
            $distributeur = auth()->user()->distributeur->load('compte');
            
            return response()->json([
                'message' => 'Soldes récupérés avec succès',
                'data' => [
                    'solde_commission' => $distributeur->solde,
                    'solde_compte' => $distributeur->compte->solde,
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
                'message' => 'Historique récupéré avec succès',
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
}