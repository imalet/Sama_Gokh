<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TypeProjet\AjouterTypeProjetRequest;
use App\Http\Requests\TypeProjet\ModifierTypeProjetRequest;
use App\Http\Resources\TypeProjetResource;
use App\Models\TypeProjet;
use Illuminate\Http\Request;
use Mockery\Matcher\Type;

class TypeProjetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
        /**
     * @OA\Get(
     *     path="/liste/type/projet",
     *     summary="Récupérer tous les types de projets",
     *     tags={"Types de Projets"},
     *     @OA\Response(
     *         response=200,
     *         description="Liste de tous les types de projets",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/TypeProjet")
     *         )
     *     )
     * )
     */
    public function index()
    {
        return TypeProjet::all();
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
     *     path="/type/projet/ajouter",
     *     summary="Ajouter un nouveau type de projet",
     *     tags={"Types de Projets"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nom"},
     *             @OA\Property(property="nom", type="string", example="Nouveau Type Projet")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Ajout du type de projet réussi",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="Message", type="string", example="Ajout du Type Projet Reussi"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Ajout du type de projet échoué",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="Message", type="string", example="Ajout du Type Projet Echoué"),
     *             )
     *         )
     *     ),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     */
    public function store(AjouterTypeProjetRequest $request)
    {
        $type_projet = new TypeProjet();
        $type_projet->nom = $request->nom;

        if ($type_projet->save()) {
            return response()->json(["Message"=>"Ajout du Type Projet Reussi"],200);
        }

        return response()->json(["Message"=>"Ajout du Type Projet Echoué"],422);
    }

    /**
     * Display the specified resource.
     */

    // public function show(string $id)
    // {
    //     $type_projet = TypeProjet::findOrFail($id);
    //     return $type_projet;
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
        /**
     * @OA\Put(
     *     path="/type/projet/modifier/{type_projet_id}",
     *     summary="Modifier un type de projet existant",
     *     tags={"Types de Projets"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du type de projet à modifier",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nom"},
     *             @OA\Property(property="nom", type="string", example="Nouveau Nom du Type Projet")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Modification du type de projet réussie",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="Message", type="string", example="Modification du Type Projet Reussi"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Modification du type de projet échouée",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="Message", type="string", example="Modification du Type Projet Echoué"),
     *             )
     *         )
     *     ),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     */
    public function update(ModifierTypeProjetRequest $request, string $id)
    {

        $type_projet = TypeProjet::findOrFail($id);
        $type_projet->nom = $request->nom;

        if ($type_projet->save()) {
            return response()->json(["Message"=>"Modification du Type Projet Reussi"],200);
        }

        return response()->json(["Message"=>"Modification du Type Projet Echoué"],422);

    }

    /**
     * Remove the specified resource from storage.
     */
        /**
     * @OA\Delete(
     *     path="/type/projet/supprimer/{type_projet_id}",
     *     summary="Supprimer un type de projet existant",
     *     tags={"Types de Projets"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du type de projet à supprimer",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Suppression du type de projet réussie",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="Message", type="string", example="Suppression Type Projet OK"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Type de projet non trouvé",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="Message", type="string", example="Type de projet non trouvé"),
     *             )
     *         )
     *     ),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     */
    public function destroy(string $id)
    {
        $type_projet = TypeProjet::findOrFail($id);

        $type_projet->delete();

        return response('Suppression Type Projet OK', 200);
    }
}
