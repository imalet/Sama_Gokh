<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Annonce\AjouterAnnonceRequest;
use App\Http\Requests\Annonce\ModifierAnnonceRequest;
use App\Models\Annonce;
use Illuminate\Http\Request;

class AnnonceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Annonce::all();
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
    public function store(AjouterAnnonceRequest $request)
    {
        $newData = new Annonce();
        $newData->titre = $request->titre;
        $newData->image = $request->image;
        $newData->description = $request->description;
        $newData->etat = $request->etat;
        $newData->user_id = 1;

        if ($newData->save()) {
            return response()->json(['message'=>'Insertion Reussi'],200);
        }

        return response()->json(['message'=>'Échec de l\'insertion'],422);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $annonce = Annonce::findOrfail($id);
        return $annonce;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ModifierAnnonceRequest $request, string $id)
    {
        $annonce = Annonce::findOrFail($id);

        $annonce->titre = $request->titre;
        $annonce->image = $request->image;
        $annonce->description = $request->description;
        $annonce->etat = $request->etat;

        if ($annonce->save()) {
            return response()->json(["message"=>"Annonce modifié Avec Success", 200]);
        }

        return response()->json(['message'=>"Erreur d'Insertion"],422);
    }

    /**
     * Archieve the specified resource from storage.
     */
    public function archiver(string $id, string $etat)
    {
        
        $projet = Annonce::findOrFail($id);
        $projet->etat = $etat;
        $projet->save();

        return response('Archiver Annonce OK', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


}
