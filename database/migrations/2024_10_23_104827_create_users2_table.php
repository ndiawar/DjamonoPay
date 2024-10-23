<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\UserRole;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users2', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('email')->unique();
            $table->string('photo')->nullable();
            $table->string('mot_de_passe');
            $table->enum('role', [
                UserRole::CLIENT,
                UserRole::DISTRIBUTEUR,
                UserRole::AGENT
            ]);
            $table->string('telephone');
            $table->string('adresse');
            $table->date('date_naissance');
            $table->string('numero_identite');
            $table->boolean('etat_compte')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users2');
    }
};
