<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EtatProjetResource;
use App\Models\EtatProjet;
use Illuminate\Http\Request;

class EtatProjetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return EtatProjet::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $newData = new EtatProjet();
        $newData->statut = $request->statut;
        $newData->save();

        return response('Ajout Etat OK', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $etat_projet = EtatProjet::findOrFail($id);
        return $etat_projet;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $etat_projet = EtatProjet::findOrFail($id);
        $etat_projet->statut = $request->statut;

        $etat_projet->save();

        return response('Modification OK', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $etat_projet = EtatProjet::findOrFail($id);

        $etat_projet->delete();

        return response('Delete OK', 200);
    }

    public function archiver(string $id)
    {
        
    }
}
