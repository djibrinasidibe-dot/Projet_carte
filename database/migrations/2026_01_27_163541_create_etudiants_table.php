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
        Schema::create('etudiant', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('ine')->unique(); // Identifiant national étudiant 
            $table->string('nom'); 
            $table->string('prenom'); 
            $table->string('filiere'); 
            $table->string('niveau'); 
            $table->string('annee_academique'); 
            $table->string('photo')->nullable(); // chemin vers la photo $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etudiant');
    }
};
