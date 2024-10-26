<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Exécute la migration.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id(); // Clé primaire auto-incrémentée

            // Ajouter client_id
            $table->foreignId('client_id')
                  ->constrained('clients')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');

            $table->foreignId('distributeur_id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null')
                  ->onUpdate('cascade');

            $table->enum('type', ['depot', 'retrait', 'transfert', 'annule']);
            $table->decimal('montant', 10, 2);
            $table->decimal('frais', 10, 2)->nullable();
            $table->decimal('commission', 10, 2)->nullable();
            $table->enum('etat', ['terminee', 'annulee', 'en_attente'])
                  ->default('en_attente'); // Remplacer par une valeur valide
            $table->text('motif')->nullable();
            $table->timestamp('date');
            $table->timestamps();

            // Index
            $table->index('type');
            $table->index('etat');
            $table->index('date');
            $table->index('client_id');
        });
    }

    /**
     * Annule la migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
}
