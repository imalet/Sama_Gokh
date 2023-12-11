<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateVilleRequest;
use App\Http\Requests\UpdateVilleRequest;
use App\Models\Ville;
use Exception;
use Illuminate\Http\Request;
use openApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Endpoint de villes",
 *     version="1.0.0",
 *     description="Le endpoint de  toutes les actions concernant villes"
 * )
 */

class VilleController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    /**
     * @OA\Get(
     *     path="/api/villes",
     *     summary="Récupérer la liste des villes",
     *     description="Récupère la liste des villes avec pagination et possibilité de recherche par nom.",
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Numéro de page (par défaut à 5)",
     *         @OA\Schema(type="integer", default=5)
     *     ),
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Terme de recherche pour filtrer les villes par nom",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Liste des villes",
     *         @OA\JsonContent(
     *             @OA\Property(property="statut_message", type="string", example="Toutes les villes ont été récupérées."),
     *             @OA\Property(property="statut_code", type="integer", example=200),
     *             @OA\Property(property="current_page", type="integer"),
     *             @OA\Property(property="last_page", type="integer"),
     *             @OA\Property(property="items", type="array", @OA\Items())
     *         )
     *     ),
     *     @OA\Response(response="500", description="Erreur interne du serveur")
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
     *     path="/api/villes",
     *     summary="Insérer des villes dans la base de données",
     *     description="Ajoute une nouvelle ville à la base de données.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="nom", type="string", description="Nom de la nouvelle ville")
     *         )
     *     ),
     *     @OA\Response(response="200", description="Ville enregistrée avec succès", @OA\JsonContent(
     *         @OA\Property(property="statut_code", type="integer", example=200),
     *         @OA\Property(property="statut_message", type="string", example="Nouvelle ville ajoutée avec succès"),
     *         @OA\Property(property="ville", type="object", ref="#/components/schemas/Ville")
     *     )),
     *     @OA\Response(response="422", description="Erreur de validation des données"),
     *     @OA\Response(response="500", description="Erreur interne du serveur")
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
     *     path="/api/villes/detail/{id}",
     *     summary="Afficher les informations d'une ville précise",
     *     description="Récupère les informations d'une ville spécifiée par son ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la ville",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Les informations de la ville.", @OA\JsonContent(
     *         @OA\Property(property="statut_code", type="integer", example=200),
     *         @OA\Property(property="statut_message", type="string", example="Informations de la ville récupérées avec succès"),
     *         @OA\Property(property="ville", type="object", ref="#/components/schemas/Ville")
     *     )),
     *     @OA\Response(response="404", description="Ville non trouvée"),
     *     @OA\Response(response="500", description="Erreur interne du serveur")
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
     * @OA\Put(
     *     path="/api/villes/update/{ville}",
     *     summary="Modifie les informations d'une ville précise.",
     *     description="Modifie les informations d'une ville spécifiée par son ID.",
     *     @OA\Parameter(
     *         name="ville",
     *         in="path",
     *         required=true,
     *         description="ID de la ville à modifier",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="nom", type="string", description="Nouveau nom de la ville")
     *         )
     *     ),
     *     @OA\Response(response="200", description="Les informations de la ville ont été modifiées.", @OA\JsonContent(
     *         @OA\Property(property="statut_code", type="integer", example=200),
     *         @OA\Property(property="statut_message", type="string", example="Le nom de la ville a été modifié avec succès"),
     *         @OA\Property(property="ville", type="object", ref="#/components/schemas/Ville")
     *     )),
     *     @OA\Response(response="404", description="Ville non trouvée"),
     *     @OA\Response(response="422", description="Erreur de validation des données"),
     *     @OA\Response(response="500", description="Erreur interne du serveur")
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
