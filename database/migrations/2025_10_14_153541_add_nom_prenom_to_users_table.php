<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // D'abord ajouter prenom comme nullable
            $table->string('prenom')->nullable()->after('name');
        });

        // Mettre à jour les données existantes avec des valeurs par défaut
        DB::table('users')->update(['prenom' => 'Utilisateur']);

        // Maintenant rendre prenom non nullable
        Schema::table('users', function (Blueprint $table) {
            $table->string('prenom')->nullable(false)->change();
        });

        // Renommer name en nom
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('name', 'nom');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('nom', 'name');
            $table->dropColumn('prenom');
        });
    }
};
