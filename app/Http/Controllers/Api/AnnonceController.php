<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use App\Models\Annonce;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Annonce\AjouterAnnonceRequest;
use App\Http\Requests\Annonce\ModifierAnnonceRequest;

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
        if($request->file('image')){
            $file = $request->file('image');
            $fileName = date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('public/images'), $fileName);
            $newData['image'] = $fileName;
        }
        $newData->description = $request->description;
        // $newData->etat = $request->etat;
        $newData->user_id = auth()->user()->id;

        if ($newData->save()) {
            return response()->json(['message'=>'Annonce inséré avec succès'],200);
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
        if(Role::where("nom", "AdminCommune")->get()->first()->id == auth()->user()->role_id && 
         Annonce::where("user_id",auth()->user()->id)->where("id", $annonce->id)->exists()){
       
        // Annonce::where("user_id",auth()->user()->id)->get()->first()->id == $annonce->id){
                // dd('Ok');
                $annonce->titre = $request->titre;
                $annonce->description = $request->description;
                if ($annonce->save()) {
                        return response()->json(["message"=>"Annonce modifié Avec Succès", 200]);
                }
        }else{
            return response()->json(["message"=>"Vous ne pouvez pas modifier cette annonce", 200]);
        }        
        // $annonce->image = $request->image;
       
        // $annonce->etat = $request->etat;

        // if ($annonce->save()) {
        //     return response()->json(["message"=>"Annonce modifié Avec Success", 200]);
        // }

        return response()->json(['message'=>"Erreur d'Insertion"],422);
    }

    /**
     * Archieve the specified resource from storage.
     */
    public function archiver(string $id)
    {
        
        $annonce = Annonce::findOrFail($id);
        if(Role::where("nom", "AdminCommune")->get()->first()->id == auth()->user()->role_id && 
        Annonce::where("user_id",auth()->user()->id)->get()->first()->id == $annonce->id){
            $annonce->etat = "Archivé";
            $annonce->save();
    
            return response()->json('Annonce archivé avec succès', 200);
        }else{
            return response()->json('Vous ne pouvez pas archivé cette annonce', 403);
        }
       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


}
