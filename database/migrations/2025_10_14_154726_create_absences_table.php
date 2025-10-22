<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('absences', function (Blueprint $table) {
            $table->id();

            // Élève qui déclare l'absence
            $table->foreignId('etudiant_id')->constrained('users')->onDelete('cascade');

            // Enseignant qui valide l'absence (peut être NULL si pas encore traité)
            $table->foreignId('enseignant_id')->nullable()->constrained('users')->onDelete('cascade');

            // Période d'absence
            $table->date('date_debut');
            $table->date('date_fin');

            // Informations sur l'absence
            $table->string('motif');
            $table->enum('statut', ['en_attente', 'validée', 'rejetée'])->default('en_attente');
            $table->string('justificatif')->nullable();
            $table->text('commentaire_validation')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('absences');
    }
};
