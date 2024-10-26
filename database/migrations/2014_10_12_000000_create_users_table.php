<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Exécuter les migrations.
     */
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
            $table->string('profile_photo_path')->nullable(); // Si vous n'avez pas besoin de la longueur, pas besoin de spécifier
            
            // Gestion d'équipe et vérification
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
