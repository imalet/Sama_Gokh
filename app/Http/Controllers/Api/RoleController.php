<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Http\Requests\RoleRegisterRequest;
use App\Http\Resources\RoleResource;
use Exception;

class RoleController extends Controller
{

    // public function index(RoleRegisterRequest $request){
    //     return response("OK TOP",200);
    // }

    // public function store(RoleRegisterRequest $request){
    //     $role = new Role();
    //     $role->nom = $request->nom;
    //     $role->save();
    // }

     /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {

            $query = Role::query();
            $perPage = 6;
            $page = $request->input('page', 5);
            $search = $request->input('search');

            if ($search) {
                $query = $query->whereRaw("nom LIKE '%" . $search . "%'");
            }

            $totalRole = $query->count();

            $resultat = $query->offset(($page - 6) * $perPage)->limit($page)->get();


            return response()->json([
                'statut_message' => 'Toutes les roles on été récupérées.',
                'statut_code' => 200,
                'current_page' => $page,
                'last_page' => ceil($totalRole / $perPage),
                'items' => $resultat
            ]);
        } catch (Exception $e) {
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

        try {

            $role = new Role();

            $role->nom = $request->nom;

            $role->save();

            return response()->json([
                'statut_code' => 200,
                'statut_message' => 'Nouvelle role ajoutée avec succès',
                'statut_code' => $role,
            ]);
        } catch (Exception $e) {

            throw new \Exception($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role = Role::findOrFail($id);
        return $role;
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

    public function update(UpdateRoleRequest $request, Role $role)
    {
        try {
            $role->nom = $request->nom;
            $role->update();

            return response()->json([
                'statut_code' => 200,
                'statut_message' => 'Le nom de la role a été modifiée avec succès',
                'statut_code' => $role,
            ]);
        } catch (Exception $e) {

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
