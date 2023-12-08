<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCommuneRequest;
use App\Http\Requests\UpdateCommuneRequest;
use App\Models\Commune;
use Exception;
use Illuminate\Http\Request;

class CommuneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       try {

        $query = Commune::query();
        $perPage = 6; 
        $page = $request->input('page', 1);
        $search = $request->input('search');

        if ($search) {
            $query = $query->whereRaw("nom LIKE '%". $search . "%'");
        }
        
        $totalCommune = $query->count();

        $resultat = $query->offset(($page -6) *$perPage)->limit($page)->get(); 
        

            return response()->json([
            'statut_message'=> 'Toutes les communes on été récupérées.',
            'statut_code'=>200,
            'current_page' => $page,
            'last_page' =>ceil($totalCommune / $perPage),
            'items' => $resultat 
        ]);

        } catch(Exception $e) {
            response()->json($e);   
        }
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
    public function store(CreateCommuneRequest $request)
    {
        // dd($request);
        
       try{

        $commune = new Commune();

        $commune->nom = $request->nom;
        $commune->image = $request->image;
        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $commune['image'] = $filename;
        }
        $commune->nombreCitoyen = $request->nombreCitoyen;
        $commune->user_id = $request->user_id;

        $commune->save();

        return response()->json([
            'statut_code'=>200,
            'statut_message'=>'Nouvelle commune ajoutée avec succès',
            'statut_code'=> $commune ,
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

    public function update(UpdateCommuneRequest $request, Commune $commune)
    {
      try{
        $commune->nom = $request->nom;
        $commune->image = $request->image;
        $commune->nombreCitoyen = $request->nombreCitoyen;
        $commune->user_id = $request->user_id;
        $commune->update();
        return response()->json([
            'statut_message'=>'Le nom de la commune a été modifiée avec succès',
            'statut_code'=>200,
            'statut_code'=> $commune ,
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
