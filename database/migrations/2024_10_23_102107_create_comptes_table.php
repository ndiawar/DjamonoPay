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
        Schema::create('comptes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            $table->string('numero', 5)->unique(); // Changé en string(5) pour 2 lettres + 3 chiffres
            $table->decimal('solde', 10, 2)->default(0);
            $table->string('qr_code')->nullable();
            $table->boolean('est_bloque')->default(false);
            $table->timestamp('qr_code_creation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comptes');
    }
};