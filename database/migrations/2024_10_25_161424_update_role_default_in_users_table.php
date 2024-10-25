<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        // Modifier la colonne role pour définir une valeur par défaut à 'client'
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['client', 'distributeur', 'agent'])
                ->default('client') // Définir la valeur par défaut ici
                ->change(); // Indiquer que c'est une modification
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        // Revenir à l'ancienne définition sans valeur par défaut
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['client', 'distributeur', 'agent'])
                ->default(null) // Supprimer la valeur par défaut
                ->change(); // Indiquer que c'est une modification
        });
    }
};
