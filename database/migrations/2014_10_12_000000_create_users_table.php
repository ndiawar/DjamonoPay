<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
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
            $table->id();  // ID unique
            $table->string('nom');  // Nom de l'utilisateur
            $table->string('prenom');  // Prénom(s) de l'utilisateur
            $table->string('email')->unique();  // Email unique
            $table->string('photo')->nullable();  // Chemin de la photo de profil
            $table->string('password');  // Mot de passe hashé
            $table->enum('role', ['client', 'distributeur', 'agent']);  // Rôle (via Enum)
            $table->string('telephone')->nullable();  // Téléphone
            $table->string('adresse')->nullable();  // Adresse de l'utilisateur
            $table->date('date_naissance')->nullable();  // Date de naissance
            $table->string('numero_identite')->unique();  // Numéro d'identité
            $table->boolean('etat_compte')->default(true);  // État du compte (actif ou désactivé)
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->timestamp('email_verified_at')->nullable();  // Vérification de l'email
            $table->rememberToken();  // Token de session
            $table->timestamps();  // Colonnes created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
