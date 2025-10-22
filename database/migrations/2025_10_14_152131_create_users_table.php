<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Champs pour tous les utilisateurs
            $table->enum('role', ['etudiant', 'enseignant', 'admin', 'directeur'])->default('etudiant');
            $table->string('telephone')->nullable();
            $table->string('photo')->nullable();
            $table->enum('sexe', ['M', 'F'])->nullable();

            // Champs pour étudiants
            $table->date('date_naissance')->nullable();
            $table->text('adresse')->nullable();
            $table->string('filiere')->nullable();
            $table->string('annee')->nullable();
            $table->date('date_inscription')->nullable();
            $table->string('numero_etudiant')->unique()->nullable();

            // Champs pour enseignants
            $table->string('matricule')->unique()->nullable();
            $table->string('matieres_enseignees')->nullable();
            $table->string('bureau')->nullable();

            // NOUVEAUX champs pour enseignants
            $table->json('classes_enseignees')->nullable();
            $table->integer('heures_travail_semaine')->nullable();
            $table->time('heure_arrivee')->nullable();
            $table->time('heure_depart')->nullable();
            $table->boolean('est_present')->default(false);
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role', 'telephone', 'photo', 'sexe',
                'date_naissance', 'adresse', 'filiere', 'annee',
                'date_inscription', 'numero_etudiant',
                'matricule', 'matieres_enseignees', 'bureau',
                'classes_enseignees', 'heures_travail_semaine',
                'heure_arrivee', 'heure_depart', 'est_present'
            ]);
        });
    }
};
