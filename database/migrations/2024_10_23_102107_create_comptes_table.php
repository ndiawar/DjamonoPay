<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComptesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('comptes', function (Blueprint $table) {
            $table->id(); 
            $table->string('numero_compte'); 
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('restrict') // Empêche la suppression de l'utilisateur si des comptes existent
                  ->onUpdate('cascade'); // Met à jour la clé étrangère si l'ID de l'utilisateur change
            $table->decimal('solde', 15, 2)->default(0); // Solde initial à 0
            $table->string('qr_code')->nullable();
            $table->boolean('est_bloque')->default(false); // Non bloqué par défaut
            $table->timestamp('qr_code_creation')->nullable();
            $table->timestamps(); // created_at et updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comptes');
    }
};