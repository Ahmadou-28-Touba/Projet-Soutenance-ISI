<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom', 'prenom', 'email', 'password', 'role',
        'telephone', 'photo', 'sexe',
        'date_naissance', 'adresse', 'filiere', 'annee',
        'date_inscription', 'numero_etudiant',
        'matricule', 'matieres_enseignees', 'bureau',
        'classes_enseignees', 'heures_travail_semaine',
        'heure_arrivee', 'heure_depart', 'est_present'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'classes_enseignees' => 'array',
        'est_present' => 'boolean'
    ];

    // Relations pour les absences
    public function absencesDeclarees()
    {
        return $this->hasMany(Absence::class, 'etudiant_id');
    }

    public function absencesValidees()
    {
        return $this->hasMany(Absence::class, 'enseignant_id');
    }

    // Vérification des rôles
    public function isEtudiant() { return $this->role === 'etudiant'; }
    public function isEnseignant() { return $this->role === 'enseignant'; }
    public function isAdmin() { return $this->role === 'admin'; }
    public function isDirecteur() { return $this->role === 'directeur'; }

    // Nom complet
    public function getNomCompletAttribute()
    {
        return $this->prenom . ' ' . $this->nom;
    }
}
