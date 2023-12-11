<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Commentaire\AjouterCommentaireRequest;
use App\Http\Requests\Commentaire\ModifierCommentaireRequest;
use App\Http\Resources\CommentaireResource;
use App\Models\Commentaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function store(AjouterCommentaireRequest $request, $id)
    {
        $newData = new Commentaire();
        $newData->annonce_id = $id;
        $newData->contenu = $request->contenu;
        $newData->user_id = auth()->user()->id;
        // $newData->user_id = $request->user_id;

        if ($newData->save()) {
            return response()->json(["Message"=>"Insertion de Commentaire"],200);
        }

        return response()->json(["Message"=>"Insertion Echoué"],422);

        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $commentaire = Commentaire::findOrFail($id);
        return $commentaire;
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
    public function update(ModifierCommentaireRequest $request, string $id)
    {
        $commentaire = Commentaire::findOrFail($id);
        // dd($commentaire);
        // dd(auth()->user()->id);
        if(auth()->user()->id == $commentaire->user_id){
            // dd("ok");
            $commentaire->contenu = $request->contenu;
            $commentaire->save();
            return response()->json('Commentaire sauvegardé', 200);
        }else{
            return response()->json('Vous ne pouvez pas modifier ce commentaire', 403);
        }
        

        // 
        
    }

    /**
     * Remove the archieve resource from storage.
     */
    public function archiver(string $id)
    {
        
        $commentaire = Commentaire::findOrFail($id);
        if(auth()->user()->id == $commentaire->user_id){
            $commentaire->etat = false;
            $commentaire->save();
    
            return response()->json('Archiver Commentaire OK', 200);
        }
       
    }
}
