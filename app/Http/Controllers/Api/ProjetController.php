<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjetResource;
use App\Models\Projet;
use Illuminate\Http\Request;

class ProjetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ProjetResource::collection(Projet::all());
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
        $newData = new Projet();
        $newData->titre = $request->titre;
        $newData->description = $request->description;
        $newData->image = $request->image;
        $newData->couts = $request->couts;
        $newData->delai = $request->delai;
        $newData->etat = $request->etat;
        $newData->type_projet_id = $request->type_projet_id;
        $newData->etat_projet_id = $request->etat_projet_id;

        if ($newData->save()) {
            return response('Insertion Ok', 200);
        }

        return response('BAD Insert', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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

        $projet = Projet::findOrFail($id);

        $projet->titre = $request->titre;
        $projet->description = $request->description;
        $projet->image = $request->image;
        $projet->couts = $request->couts;
        $projet->delai = $request->delai;
        $projet->etat = $request->etat;
        $projet->type_projet_id = $request->type_projet_id;
        $projet->etat_projet_id = $request->etat_projet_id;

        if ($projet->save()) {
            return response('Update Ok', 200);
        }

        return response('BAD Update', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(string $id)
    // {
    //     $projet = Projet::findOrFail($id);

    //     $projet->delete();

    //     return response('Delete OK', 200);
    // }

    public function archiver(string $id, string $etat)
    {
        
        $projet = Projet::findOrFail($id);
        $projet->etat = $etat;
        $projet->save();

        return response('Archiver OK', 200);
    }
}
