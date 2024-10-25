<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Compte;
use App\Models\Distributeur;
use App\Enums\UserRole;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class DistributeurTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private $distributeur;
    private $client;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Créer un distributeur pour les tests
        $this->distributeur = $this->createDistributeur();
        
        // Créer un client pour les tests
        $this->client = $this->createClient();
    }

    // Helper pour créer un distributeur
    private function createDistributeur()
    {
        $user = User::factory()->create([
            'role' => UserRole::DISTRIBUTEUR,
            'etat_compte' => 'actif'
        ]);

        $compte = Compte::create([
            'user_id' => $user->id,
            'numero' => 'DIS' . random_int(1000, 9999),
            'solde' => 10000,
            'est_bloque' => false
        ]);

        $distributeur = Distributeur::create([
            'user_id' => $user->id,
            'compte_id' => $compte->id,
            'solde' => 0
        ]);

        return $user;
    }

    // Helper pour créer un client
    private function createClient()
    {
        $user = User::factory()->create([
            'role' => UserRole::CLIENT,
            'etat_compte' => 'actif'
        ]);

        $compte = Compte::create([
            'user_id' => $user->id,
            'numero' => 'CLT' . random_int(1000, 9999),
            'solde' => 5000,
            'est_bloque' => false
        ]);

        return $user;
    }

    /** @test */
    public function un_distributeur_peut_voir_son_dashboard()
    {
        $response = $this->actingAs($this->distributeur)
            ->get('/distributeur/dashboard');

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.distributeur.dashboard');
        $response->assertViewHas('distributeur');
    }

    /** @test */
    public function un_distributeur_peut_crediter_un_client()
    {
        $montant = 1000;
        $commission = $montant * 0.01;

        $response = $this->actingAs($this->distributeur)
            ->postJson('/distributeur/crediter-client', [
                'numero_compte' => $this->client->compte->numero,
                'montant' => $montant
            ]);

        $response->assertStatus(200);
        
        // Vérifier la mise à jour des soldes
        $this->assertEquals(
            4000, // 5000 - 1000
            $this->distributeur->compte->fresh()->solde
        );
        
        $this->assertEquals(
            6000, // 5000 + 1000
            $this->client->compte->fresh()->solde
        );
        
        $this->assertEquals(
            $commission,
            $this->distributeur->distributeur->fresh()->solde
        );
    }

    /** @test */
    public function un_distributeur_peut_faire_un_retrait_pour_un_client()
    {
        $montant = 1000;
        $commission = $montant * 0.01;

        $response = $this->actingAs($this->distributeur)
            ->postJson('/distributeur/retrait-client', [
                'numero_compte' => $this->client->compte->numero,
                'montant' => $montant
            ]);

        $response->assertStatus(200);
        
        // Vérifier la mise à jour des soldes
        $this->assertEquals(
            6000, // 5000 + 1000
            $this->distributeur->compte->fresh()->solde
        );
        
        $this->assertEquals(
            4000, // 5000 - 1000
            $this->client->compte->fresh()->solde
        );
        
        $this->assertEquals(
            $commission,
            $this->distributeur->distributeur->fresh()->solde
        );
    }

    /** @test */
    public function un_distributeur_ne_peut_pas_crediter_plus_que_son_solde()
    {
        $response = $this->actingAs($this->distributeur)
            ->postJson('/distributeur/crediter-client', [
                'numero_compte' => $this->client->compte->numero,
                'montant' => 20000 // Plus que le solde du distributeur
            ]);

        $response->assertStatus(400);
        $response->assertJson([
            'message' => 'Solde distributeur insuffisant'
        ]);
    }

    /** @test */
    public function un_distributeur_ne_peut_pas_faire_un_retrait_si_le_client_na_pas_assez()
    {
        $response = $this->actingAs($this->distributeur)
            ->postJson('/distributeur/retrait-client', [
                'numero_compte' => $this->client->compte->numero,
                'montant' => 10000 // Plus que le solde du client
            ]);

        $response->assertStatus(400);
        $response->assertJson([
            'message' => 'Solde client insuffisant'
        ]);
    }

    /** @test */
    public function un_distributeur_peut_consulter_son_solde()
    {
        $response = $this->actingAs($this->distributeur)
            ->getJson('/distributeur/consulter-solde');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message',
            'data' => [
                'solde_commission',
                'solde_compte',
                'derniere_mise_a_jour'
            ]
        ]);
    }

    /** @test */
    public function un_distributeur_peut_voir_son_historique()
    {
        $response = $this->actingAs($this->distributeur)
            ->getJson('/distributeur/historique-transactions');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message',
            'data' => [
                'data',
                'current_page',
                'per_page'
            ]
        ]);
    }

    /** @test */
    public function un_distributeur_peut_verifier_un_compte_client()
    {
        $response = $this->actingAs($this->distributeur)
            ->postJson('/distributeur/verifier-compte', [
                'numero_compte' => $this->client->compte->numero
            ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message',
            'data' => [
                'numero_compte',
                'client' => [
                    'nom',
                    'prenom'
                ],
                'solde',
                'est_bloque'
            ]
        ]);
    }
}