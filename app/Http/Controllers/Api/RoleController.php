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
use openApi\Annotations as OA; 

/**
 * @OA\Info(
 *     title="Endpoint des rôles",
 *     version="1.0.0",
 *     description="Le endpoint de  toutes les actions concernant villes"
 * )
 */
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
/**
 * @OA\Get(
 *     path="/api/roles",
 *     summary="Récupérer la liste des rôles",
 *     description="Récupère la liste des rôles avec pagination et possibilité de recherche par nom.",
 *     @OA\Parameter(
 *         name="page",
 *         in="query",
 *         description="Numéro de page",
 *         @OA\Schema(type="integer", default=5)
 *     ),
 *     @OA\Parameter(
 *         name="search",
 *         in="query",
 *         description="Terme de recherche pour filtrer les rôles par nom",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(response="200", description="Toutes les rôles ont été récupérées."),
 *     @OA\Response(response="500", description="Erreur interne du serveur")
 * )
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
    /**
 * @OA\Post(
 *     path="/api/role/store",
 *     summary="Récupérer la liste des rôles",
 *     description="Récupère la liste des rôles avec pagination et possibilité de recherche par nom.",
 *     @OA\Parameter(
 *         name="page",
 *         in="query",
 *         description="Numéro de page",
 *         @OA\Schema(type="integer", default=5)
 *     ),
 *     @OA\Parameter(
 *         name="search",
 *         in="query",
 *         description="Terme de recherche pour filtrer les rôles par nom",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(response="200", description="Toutes les rôles ont été récupérées."),
 *     @OA\Response(response="500", description="Erreur interne du serveur")
 * )
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
    /**
 * @OA\Get(
 *     path="/api/role/detail/{id}'",
 *     summary="Afficher les détails d'un rôle",
 *     description="Récupère les détails d'un rôle spécifié par son ID.",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID du rôle",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(response="200", description="Détails du rôle"),
 *     @OA\Response(response="404", description="Rôle non trouvé"),
 *     @OA\Response(response="500", description="Erreur interne du serveur")
 * )
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

     /**
 * @OA\Put(
 *     path="/api/role/update/{role}",
 *     summary="Modifier un rôle existant",
 *     description="Modifie les détails d'un rôle existant spécifié par son ID.",
 *     @OA\Parameter(
 *         name="role",
 *         in="path",
 *         required=true,
 *         description="ID du rôle à modifier",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="nom", type="string", description="Nouveau nom du rôle")
 *         )
 *     ),
 *     @OA\Response(response="200", description="Le nom du rôle a été modifié avec succès"),
 *     @OA\Response(response="404", description="Rôle non trouvé"),
 *     @OA\Response(response="422", description="Erreur de validation des données"),
 *     @OA\Response(response="500", description="Erreur interne du serveur")
 * )
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
