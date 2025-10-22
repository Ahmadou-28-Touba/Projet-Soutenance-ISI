<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absence;

class AbsenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $absences = Absence::all();
        return response()->json($absences,200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $absence = Absence::create($request->all());
        return response()->json($absence,201);
    }

    /**
     * Display the specified resource.
     */
        public function show(string $id)
    {
        $absence = Absence::with(['etudiant', 'enseignant'])->find($id);

        //  Si l'absence n'existe pas
        if (!$absence) {
            return response()->json([
                'message' => 'Absence non trouvée'
            ], 404);
        }

        // Retourner l'absence trouvée
        return response()->json($absence, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //  Chercher l'absence
        $absence = Absence::find($id);

        //  Si l'absence n'existe pas
        if (!$absence) {
            return response()->json([
                'message' => 'Absence non trouvée'
            ], 404);
        }

        //  Valider les données
        $request->validate([
            'date_debut' => 'sometimes|date',
            'date_fin' => 'sometimes|date|after_or_equal:date_debut',
            'motif' => 'sometimes|string',
            'statut' => 'sometimes|in:en_attente,validée,rejetée',
            'enseignant_id' => 'sometimes|exists:users,id',
            'commentaire_validation' => 'sometimes|string'
        ]);

        //  Mettre à jour l'absence
        $absence->update($request->all());

        //  Recharger l'absence avec les relations
        $absence->load(['etudiant', 'enseignant']);

        //  Retourner l'absence mise à jour
        return response()->json($absence, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Absence::destroy($id);
        return response()->json('Absence supprimée avec succès', 204);
    }
}
