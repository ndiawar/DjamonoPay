<?php

namespace App\Http\Controllers;

use App\Http\Requests\Agent\StoreAgentRequest;
use App\Http\Requests\Agent\UpdateAgentRequest;
use App\Http\Resources\AgentResource;
use App\Http\Resources\AgentCollection;
use App\Models\Agent;
use App\Models\Client;
use App\Models\Compte;
use App\Models\Distributeur;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Enums\UserRole;


class AgentController extends Controller
{
    /**
     * Affiche tous les agents.
     */
    public function index(Request $request)
    {
        $agents = Agent::paginate(10);
        return new AgentCollection($agents);
    }

    /**
     * Affiche un agent spécifique.
     */
    public function show(Agent $agent)
    {
        return new AgentResource($agent->load('transactions'));
    }

    /**
     * Enregistre un nouvel agent.
     */
    public function store(StoreAgentRequest $request)
    {
        $validated = $request->validated();
        $agent = Agent::create($validated);
        return new AgentResource($agent);
    }

    /**
     * Met à jour un agent existant.
     */
    public function update(UpdateAgentRequest $request, Agent $agent)
    {
        $validated = $request->validated();
        $agent->update($validated);
        return new AgentResource($agent);
    }

    /**
     * Supprime un agent.
     */
    public function destroy(Agent $agent)
    {
        $agent->delete();
        return response()->json(['message' => 'Agent supprimé avec succès'], 200);
    }

    /**
     * Crée un compte client.
     */
    public function creerCompteClient(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'telephone' => 'required|string|unique:users,telephone',
            'adresse' => 'nullable|string',
            'date_naissance' => 'nullable|date',
            'numero_identite' => 'required|string|unique:users,numero_identite',
        ]);

        DB::beginTransaction();

        try {
            $client = Client::create($request->all());
            DB::commit();
            return response()->json([
                'message' => 'Compte client créé avec succès',
                'client' => new AgentResource($client)
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Erreur lors de la création du compte client'], 500);
        }
    }

    /**
     * Modifie un compte client.
     */
    public function modifierCompte(Request $request, $clientId)
    {
        DB::beginTransaction();

        try {
            $client = Client::findOrFail($clientId);
            $client->update($request->all());
            DB::commit();
            return response()->json([
                'message' => 'Compte client modifié avec succès',
                'client' => new AgentResource($client)
            ]);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['message' => 'Client non trouvé'], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Erreur lors de la modification du compte client'], 500);
        }
    }

    /**
     * Créditer un compte distributeur.
     */
    public function crediterCompteDistributeur(Request $request)
    {
        $request->validate([
            'numero_compte' => 'required|string',
            'montant' => 'required|numeric|min:0.01'
        ]);

        DB::beginTransaction();

        try {
            $compte = Compte::where('numero_compte', $request->numero_compte)->firstOrFail();
            $compte->solde += $request->montant;
            $compte->save();

            Transaction::create([
                'user_id' => $compte->user_id,
                'type' => 'depot',
                'montant' => $request->montant,
                'etat' => 'terminee',
                'motif' => 'Créditation effectuée',
                'date' => now()
            ]);

            DB::commit();
            return redirect()->route('dashboard-approvisionner')->with('message', 'Créditation effectuée avec succès');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return redirect()->route('dashboard-approvisionner')->with('error', 'Compte non trouvé');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('dashboard-approvisionner')->with('error', 'Erreur lors de la créditation');
        }
    }

    /**
     * Bloquer ou débloquer un compte utilisateur.
     */
    public function bloquerOuDebloquerCompte(Request $request, $userId)
    {
        DB::beginTransaction();

        try {
            $user = User::findOrFail($userId);
            $user->etat_compte = $user->etat_compte === 'actif' ? 'inactif' : 'actif';
            $user->save();
            DB::commit();

            return redirect()->route('dashboard-utilisateurs')->with('success', 'L\'état du compte a été mis à jour avec succès.');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['message' => 'Utilisateur non trouvé'], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Erreur lors de la mise à jour du compte'], 500);
        }
    }

    /**
     * Annuler une transaction.
     */
    public function annulerTransaction(Request $request, Transaction $transaction)
    {
        try {
            $transaction->etat = 'annulé';
            $transaction->save();
            return response()->json(['message' => 'Transaction annulée avec succès'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erreur lors de l\'annulation'], 500);
        }
    }
    /**
 * Affiche l'historique des transactions des distributeurs.
 */
public function afficherTransactions(Request $request)
{
    // Récupérer les transactions pour le distributeur, vous pourriez avoir un filtre ici selon l'utilisateur connecté
    $transactions = Transaction::with(['user' => function($query) {
        $query->select('id', 'prenom', 'adresse', 'numero_identite');
    }])->paginate(10); // Pagination si nécessaire

    return view('dashboard-transactions', compact('transactions')); // Remplacez par le nom de votre vue
}



   
     

    
    

}
