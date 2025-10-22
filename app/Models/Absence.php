<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
    use HasFactory;

    /**
     * Les champs qui peuvent être remplis massivement
     */
    protected $fillable = [
        'etudiant_id',
        'enseignant_id',
        'date_debut',
        'date_fin',
        'motif',
        'statut',
        'justificatif',
        'commentaire_validation'
    ];

    /**
     * L'étudiant qui a déclaré cette absence
     */
    public function etudiant()
    {
        return $this->belongsTo(User::class, 'etudiant_id');
    }

    /**
     * L'enseignant qui a traité cette absence
     */
    public function enseignant()
    {
        return $this->belongsTo(User::class, 'enseignant_id');
    }
}
