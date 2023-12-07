<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateVilleRequest;
use App\Http\Requests\UpdateVilleRequest;
use App\Models\Ville;
use Exception;
use Illuminate\Http\Request;

class VilleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return 'Liste des villes';

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
    public function store(CreateVilleRequest $request)
    {
        // dd($request);
        
       try{

        $ville = new Ville();

        $ville->nom = $request->nom;

        $ville->save();

        return response()->json([
            'statut_code'=>200,
            'statut_message'=>'Nouvelle ville ajoutée avec succès',
            'statut_code'=> $ville ,
        ]);

       } catch(Exception $e) {

        throw new \Exception($e);
       }
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

    public function update(UpdateVilleRequest $request, Ville $ville)
    {
      try{
        $ville->nom = $request->nom;
        $ville->update();
        // return 'updated';
        // $ville->save();
        return response()->json([
            'statut_code'=>200,
            'statut_message'=>'Le nom de la ville a été modifiée avec succès',
            'statut_code'=> $ville ,
        ]);

      } catch(Exception $e) {
        
        return response()->json($e);
      };
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
