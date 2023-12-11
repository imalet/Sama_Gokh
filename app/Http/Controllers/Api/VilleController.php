<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateVilleRequest;
use App\Http\Requests\UpdateVilleRequest;
use App\Models\Ville;
use Exception;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(title="endpoint de Villes", version="0.1")
 */

class VilleController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    /**
     * @OA\Get(
     *     get="/api/villes",
     *     summary="Afficher la liste des villes",
     *     @OA\Response(response="200", description=" La liste des villes récupérées.")
     * )   
     */

     
    public function index(Request $request)
    {
        try {

            $query = Ville::query();
            $perPage = 6;
            $page = $request->input('page', 5);
            $search = $request->input('search');

            if ($search) {
                $query = $query->whereRaw("nom LIKE '%" . $search . "%'");
            }

            $totalVille = $query->count();

            $resultat = $query->offset(($page - 6) * $perPage)->limit($page)->get();


            return response()->json([
                'statut_message' => 'Toutes les villes ont été récupérées.',
                'statut_code' => 200,
                // 'statut_code'=> Ville::all() ,
                'current_page' => $page,
                'last_page' => ceil($totalVille / $perPage),
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
     *     post="/api/ville/store",
     *     summary="Insérer des villes dans la base de données",
     *     @OA\Response(response="200", description=" Ville enregistrée avec succès.")
     * )   
     */

    public function store(CreateVilleRequest $request)
    {

        try {

            $ville = new Ville();

            $ville->nom = $request->nom;

            $ville->save();

            return response()->json([
                'statut_code' => 200,
                'statut_message' => 'Nouvelle ville ajoutée avec succès',
                'statut_code' => $ville,
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
     *     get="/api/ville/detail/{id}",
     *     summary="Afficher les informations d'une ville précise",
     *     @OA\Response(response="200", description=" Les information de la ville.")
     * )   
     */
    public function show(string $id)
    {
        $ville = Ville::findOrFail($id);
        return $ville;
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
     * @OA\Get(
     *     get="/api/ville/update/{ville}",
     *     summary="Modifie les informations d'une ville précise",
     *     @OA\Response(response="200", description="Les information de la ville ont été modifiés.")
     * )   
     */

    public function update(UpdateVilleRequest $request, Ville $ville)
    {
        try {
            $ville->nom = $request->nom;
            $ville->update();
            // return 'updated';
            // $ville->save();
            return response()->json([
                'statut_code' => 200,
                'statut_message' => 'Le nom de la ville a été modifiée avec succès',
                'statut_code' => $ville,
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
