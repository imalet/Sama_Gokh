<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Role;
use Exception;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // return 'Liste des rôles';
        try {
          
        $query = Role::query();
        $perPage = 6; 
        $page = $request->input('page', 5);
        $search = $request->input('search');

        if ($search) {
            $query = $query->whereRaw("nom LIKE '%". $search . "%'");
        }
        
        $totalRole = $query->count();

        $resultat = $query->offset(($page -6) *$perPage)->limit($page)->get(); 
        

            return response()->json([
            'statut_message'=> 'Toutes les villes on été récupérées.',
            'statut_code'=>200,
            // 'statut_code'=> Ville::all() ,
            'current_page' => $page,
            'last_page' =>ceil($totalRole / $perPage),
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
    public function store(CreateRoleRequest $request)
    {
        // dd($request);
        
       try{

        $role = new Role();

        $role->nom = $request->nom;

        $role->save();

        return response()->json([
            'statut_code'=>200,
            'statut_message'=>'Nouveau rôle ajouté avec succès',
            'statut_code'=> $role ,
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
    // public function update(UpdateRoleRequest $request, $id)
    // {
     
    //     $role = Role::find($id);
    //     $role->nom = $request->nom;
    //     $role->update();
    //     // dd($role);
    // }

    public function update(UpdateRoleRequest $request, Role $role)
    {
      try{
        $role->nom = $request->nom;
        $role->update();
        // return 'updated';
        
        return response()->json([
            'statut_code'=>200,
            'statut_message'=>'Le rôle a été modifié avec succès',
            'statut_code'=> $role ,
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
