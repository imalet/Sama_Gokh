<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentaireResource;
use App\Models\Commentaire;
use Illuminate\Http\Request;

class CommentaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CommentaireResource::collection(Commentaire::all());
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
        $newData = new Commentaire();
        $newData->annonce_id = $request->annonce_id;
        $newData->contenu = $request->contenu;
        $newData->user_id = $request->user_id;

        $newData->save();

        return response('Insertion Commentaire OK', 200);
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
        $commentaire = Commentaire::findOrFail($id);
        $commentaire->contenu = $request->contenu;

        $commentaire->save();
        return response('update Commentaire OK', 200);
    }

    /**
     * Remove the archieve resource from storage.
     */
    public function archiver(string $id, string $etat)
    {
        
        $commentaire = Commentaire::findOrFail($id);
        $commentaire->etat = $etat;
        $commentaire->save();

        return response('Archiver Commentaire OK', 200);
    }
}
