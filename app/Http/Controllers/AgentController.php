<?php

namespace App\Http\Controllers;

use App\Http\Requests\Agent\StoreAgentRequest;
use App\Http\Requests\Agent\UpdateAgentRequest;
use App\Http\Resources\AgentResource;
use App\Http\Resources\AgentCollection;
use App\Models\Agent;
use App\Models\Client;
use App\Models\Distributeur;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
            return response()->json(['message' => 'Compte client créé avec succès', 'client' => new AgentResource($client)]);
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
        $request->validate([
            // Ajoutez les validations nécessaires
        ]);

        DB::beginTransaction();

        try {
            $client = Client::findOrFail($clientId);
            $client->update($request->all());
            DB::commit();
            return response()->json(['message' => 'Compte client modifié avec succès', 'client' => new AgentResource($client)]);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['message' => 'Client non trouvé'], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Erreur lors de la modification du compte client'], 500);
        }
    }

    /**
     * Crédite le compte d'un distributeur.
     */
    public function crediterCompteDistributeur(Request $request, $distributeurId)
    {
        $request->validate([
            'numero_compte' => 'required|string',
            'montant' => 'required|numeric|min:0.01']);
        DB::beginTransaction();

        try {
            // Rechercher le distributeur par numéro de compte
        $distributeur = Distributeur::where('numero_compte', $request->numero_compte)->firstOrFail();
            // Logique pour créditer le compte du distributeur
            // Mettez à jour le solde
             // Ajouter le montant au solde existant
        $distributeur->solde += $request->montant;
        $distributeur->save();

            DB::commit();
            return response()->json(['message' => 'Crédit effectué avec succès']);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['message' => 'Distributeur non trouvé'], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Erreur lors du crédit'], 500);
        }
    }

    /**
     * Bloque un compte client.
     */
    public function bloquerCompte(Request $request, $clientId)
    {
        DB::beginTransaction();

        try {
            $client = Client::findOrFail($clientId);
            $client->etat = 'bloqué'; // Par exemple, une colonne pour l'état
            $client->save();
            DB::commit();
            return response()->json(['message' => 'Compte bloqué avec succès']);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['message' => 'Client non trouvé'], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Erreur lors du blocage du compte'], 500);
        }
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
    public function showForm($agentId, $distributeurId)
{
    // Trouver l'agent par son ID
    $agent = Agent::findOrFail($agentId);

    // Trouver le distributeur par son ID
    $distributeur = Distributeur::findOrFail($distributeurId);
    
    // Passer les données à la vue
    return view('dashboard.index', compact('agent', 'distributeur'));
}
}
  