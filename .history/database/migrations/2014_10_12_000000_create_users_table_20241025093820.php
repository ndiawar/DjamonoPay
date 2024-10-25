<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Exécuter les migrations.
     */
    // public function up(): void
    // {
    //     Schema::create('users', function (Blueprint $table) {
    //         $table->id();
    //         $table->string('name');
    //         $table->string('email')->unique();
    //         $table->timestamp('email_verified_at')->nullable();
    //         $table->string('password');
    //         $table->rememberToken();
    //         $table->foreignId('current_team_id')->nullable();
    //         $table->string('profile_photo_path', 2048)->nullable();
    //         $table->timestamps();
    //     });
    // }
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();  // ID unique auto-incrémenté
            
            // Informations personnelles de base
            $table->string('nom');
            $table->string('prenom');
            $table->string('email')->unique();
            $table->string('password');
            
            // Rôle et état du compte
            $table->enum('role', ['client', 'distributeur', 'agent'])->default('client');
            $table->enum('etat_compte', ['actif', 'inactif', 'suspendu'])->default('actif');
            
            // Informations personnelles détaillées
            $table->string('telephone')->unique();
            $table->text('adresse')->nullable();
            $table->date('date_naissance')->nullable();
            $table->string('numero_identite')->unique();
            
            // Gestion des photos
            $table->string('photo')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
            
            // Gestion d'équipe et vérification
            $table->foreignId('current_team_id')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            
            // Index pour optimiser les performances
            $table->index('role');
            $table->index('etat_compte');
            $table->index(['nom', 'prenom']);
            $table->index('telephone');
        });
    }

    /**
     * Annuler les migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};