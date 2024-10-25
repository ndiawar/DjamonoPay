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
        Schema::table('distributeurs', function (Blueprint $table) {
            $table->dropForeign(['compte_id']); // Supprimez la contrainte de clé étrangère
            $table->dropColumn('compte_id'); // Supprimez la colonne
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('distributeurs', function (Blueprint $table) {
            $table->foreignId('compte_id')
                  ->constrained('comptes')
                  ->onDelete('restrict');
        });
    }
};
