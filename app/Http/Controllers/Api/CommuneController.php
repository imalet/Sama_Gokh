<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCommuneRequest;
use App\Http\Requests\UpdateCommuneRequest;
use App\Models\Commune;
use Exception;
use Illuminate\Http\Request;
use openApi\Annotations as OA; 

/**
 * @OA\Info(
 *     title="Endpoint de communes",
 *     version="1.0.0",
 *     description="Le endpoint de  toutes les actions concernant villes"
 * )
 */
class CommuneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
/**
 * @OA\Get(
 *     path="/api/communes",
 *     summary="Récupérer la liste des communes",
 *     description="Récupère la liste des communes avec pagination et possibilité de recherche par nom.",
 *     @OA\Parameter(
 *         name="page",
 *         in="query",
 *         description="Numéro de page",
 *         @OA\Schema(type="integer", default=5)
 *     ),
 *     @OA\Parameter(
 *         name="search",
 *         in="query",
 *         description="Terme de recherche pour filtrer les communes par nom",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(response="200", description="Toutes les communes ont été récupérées."),
 *     @OA\Response(response="500", description="Erreur interne du serveur")
 * )
 */

    public function index(Request $request)
    {
        try {

            $query = Commune::query();
            $perPage = 6;
            $page = $request->input('page', 5);
            $search = $request->input('search');

            if ($search) {
                $query = $query->whereRaw("nom LIKE '%" . $search . "%'");
            }

            $totalCommune = $query->count();

            $resultat = $query->offset(($page - 6) * $perPage)->limit($page)->get();


            return response()->json([
                'statut_message' => 'Toutes les communes on été récupérées.',
                'statut_code' => 200,
                'current_page' => $page,
                'last_page' => ceil($totalCommune / $perPage),
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
 *     path="/api/commune/store",
 *     summary="Ajouter une nouvelle commune",
 *     description="Ajoute une nouvelle commune à la base de données.",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="nom", type="string", description="Nom de la commune"),
 *             @OA\Property(property="image", type="string", format="binary", description="Image de la commune"),
 *             @OA\Property(property="nombreCitoyen", type="integer", description="Nombre de citoyens dans la commune"),
 *             @OA\Property(property="ville_id", type="integer", description="ID de la ville associée à la commune")
 *         )
 *     ),
 *     @OA\Response(response="200", description="Nouvelle commune ajoutée avec succès"),
 *     @OA\Response(response="422", description="Erreur de validation des données"),
 *     @OA\Response(response="500", description="Erreur interne du serveur")
 * )
 */

    public function store(CreateCommuneRequest $request)
    {
        // dd($request);

        try {

            $commune = new Commune();

            $commune->nom = $request->nom;
            if ($request->file('image')) {
                $file = $request->file('image');
                $filename = date('YmdHi') . $file->getClientOriginalName();
                $file->move(public_path('images'), $filename);
                $commune['image'] = $filename;
            }
            $commune->nombreCitoyen = $request->nombreCitoyen;
            $commune->ville_id = $request->ville_id;

            $commune->save();

            return response()->json([
                'statut_message' => 'Nouvelle commune ajoutée avec succès',
                'statut_code' => 200,
                'statut_code' => $commune,
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
 *     path="/api/commune/detail/{id}",
 *     summary="Afficher les détails d'une commune",
 *     description="Récupère les détails d'une commune spécifiée par son ID.",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID de la commune",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(response="200", description="Détails de la commune"),
 *     @OA\Response(response="404", description="Commune non trouvée"),
 *     @OA\Response(response="500", description="Erreur interne du serveur")
 * )
 */

    public function show(string $id)
    {
        $commune = Commune::findOrFail($id);
        return $commune;
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
 *     path="/api/commune/update/{commune}",
 *     summary="Modifier une commune existante",
 *     description="Modifie les détails d'une commune existante spécifiée par son ID.",
 *     @OA\Parameter(
 *         name="commune",
 *         in="path",
 *         required=true,
 *         description="ID de la commune à modifier",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="nom", type="string", description="Nouveau nom de la commune"),
 *             @OA\Property(property="image", type="string", format="binary", description="Nouvelle image de la commune"),
 *             @OA\Property(property="nombreCitoyen", type="integer", description="Nouveau nombre de citoyens dans la commune"),
 *             @OA\Property(property="ville_id", type="integer", description="Nouvel ID de la ville associée à la commune")
 *         )
 *     ),
 *     @OA\Response(response="200", description="La commune a été modifiée avec succès"),
 *     @OA\Response(response="404", description="Commune non trouvée"),
 *     @OA\Response(response="422", description="Erreur de validation des données"),
 *     @OA\Response(response="500", description="Erreur interne du serveur")
 * )
 */

    public function update(UpdateCommuneRequest $request, Commune $commune)
    {
        // dd($commune);
        // dd($request);
        // dd($request->nom);
        try {
            $commune->nom = $request->nom;
            if ($request->file('image')) {
                $file = $request->file('image');
                $filename = date('YmdHi') . $file->getClientOriginalName();
                $file->move(public_path('images'), $filename);
                $commune['image'] = $filename;
            }
            $commune->nombreCitoyen = $request->nombreCitoyen;
            $commune->ville_id = $request->ville_id;
            //  dd($commune);
            $commune->save();

            return response()->json([
                'statut_message' => 'Le commune a été modifiée avec succès',
                'statut_code' => 200,
                'statut_code' => $commune,
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
