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
        Schema::create('carte', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('etudiant_id'); // clé étrangère vers etudiants.id 
            $table->string('numero_carte')->unique(); 
            $table->string('qr_code')->nullable(); 
            $table->enum('statut', ['active', 'suspendue', 'expiree'])->default('active'); 
            $table->date('date_expiration')->nullable(); 
            $table->foreign('etudiant_id') ->references('id') ->on('etudiant') ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carte');
    }
};
