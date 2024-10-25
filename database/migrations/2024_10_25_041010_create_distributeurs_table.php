<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('distributeurs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            $table->foreignId('compte_id')
                  ->constrained('comptes')
                  ->onDelete('restrict');
            $table->decimal('solde', 10, 2)->default(0)->comment('Solde des commissions'); // Solde pour les commissions
            $table->timestamps();

            // Index
            $table->unique('user_id');
            $table->unique('compte_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distributeurs');
    }
};