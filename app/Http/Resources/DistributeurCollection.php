<?php

namespace App\Http\Controllers;

use App\Models\Distributeur;
use App\Models\User;
use App\Models\Transaction;
use App\Http\Requests\Distributeur\StoreDistributeurRequest;
use App\Http\Requests\Distributeur\UpdateDistributeurRequest;
use App\Http\Resources\DistributeurResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
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

        return view('dashboard.dashboard-distributeur', [
            'distributeurs' => $distributeurs,
            'statistics' => $statistics
        ]);
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
            $distributeur = new Distributeur(['solde' => 0]);
            $user->distributeur()->save($distributeur);

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

            if ($request->has('solde') && $user->distributeur) {
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

            // Supprime d'abord le distributeur s'il existe
            if ($user->distributeur) {
                $user->distributeur->delete();
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

    public function updateSolde(Request $request, $id): JsonResponse
    {
        try {
            $request->validate([
                'montant' => 'required|numeric|min:0'
            ]);

            $user = User::where('role', 'distributeur')
                       ->with('distributeur')
                       ->findOrFail($id);

            if (!$user->distributeur) {
                throw new \Exception('Le distributeur n\'a pas de compte associé');
            }

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