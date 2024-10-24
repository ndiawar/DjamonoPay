<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Exécuter les migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            // Client qui fait la transaction
            $table->foreignId('client_id')
                  ->constrained('users')
                  ->onDelete('restrict');
            // Distributeur qui gère la transaction (pour dépôt/retrait)
            $table->foreignId('distributeur_id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('restrict');
            $table->enum('type', ['depot', 'retrait', 'transfert', 'annule']);
            $table->decimal('montant', 10, 2);
            $table->decimal('frais', 10, 2)->nullable();
            $table->decimal('commission', 10, 2)->nullable();
            $table->enum('etat', ['terminee', 'annulee', 'en_attente'])
                  ->default('en_attente');
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
     * Annuler les migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};