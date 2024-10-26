<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemLoggersTable extends Migration
{
    /**
     * Exécute la migration.
     */
    public function up(): void
    {
        Schema::create('system_loggers', function (Blueprint $table) {
            $table->id(); // Clé primaire auto-incrémentée
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Clé étrangère vers users
            $table->string('action'); // Action (créée, annulée, modifiée)
            $table->timestamp('timestamp')->useCurrent(); // Timestamp de l'action
            $table->string('description'); // Description de l'action
            $table->timestamps(); // created_at et updated_at
        });
    }

    /**
     * Annule la migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_loggers');
    }
}
