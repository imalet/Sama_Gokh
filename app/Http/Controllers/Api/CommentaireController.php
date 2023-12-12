<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Commentaire\AjouterCommentaireRequest;
use App\Http\Requests\Commentaire\ModifierCommentaireRequest;
use App\Http\Resources\CommentaireResource;
use App\Models\Commentaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
        /**
     * @OA\Get(
     *     path="/commentaires",
     *     summary="Récupérer tous les commentaires",
     *     tags={"Commentaires"},
     *     @OA\Response(
     *         response=200,
     *         description="Liste de tous les commentaires",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/CommentaireResource")
     *         )
     *     ),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     */
    public function index()
    {
        return CommentaireResource::collection(Commentaire::all());
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
     *     path="/commentaires/ajouter/{annonce_id}",
     *     summary="Ajouter un commentaire à une annonce",
     *     tags={"Commentaires"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'annonce à laquelle ajouter un commentaire",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"contenu"},
     *             @OA\Property(property="contenu", type="string", example="Contenu du commentaire")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Insertion de commentaire réussie",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="Message", type="string", example="Insertion de Commentaire")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Insertion de commentaire échouée",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="Message", type="string", example="Insertion Echoué")
     *             )
     *         )
     *     ),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     */
    public function store(AjouterCommentaireRequest $request, $id)
    {
        $newData = new Commentaire();
        $newData->annonce_id = $id;
        $newData->contenu = $request->contenu;
        $newData->user_id = auth()->user()->id;
    }
    public function store(AjouterCommentaireRequest $request)
    {
        $newData = new Commentaire();
        $newData->annonce_id = $request->annonce_id;
        $newData->contenu = $request->contenu;
        $newData->user_id = Auth::user()->id;
        // $newData->user_id = $request->user_id;

        if ($newData->save()) {
            return response()->json(["Message"=>"Insertion de Commentaire"],200);
        }

        return response()->json(["Message"=>"Insertion Echoué"],422);

        
    }

    /**
     * Display the specified resource.
     */
        /**
     * @OA\Get(
     *     path="/commentaire/detail/{id}",
     *     summary="Récupérer un commentaire par son ID",
     *     tags={"Commentaires"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du commentaire à récupérer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Commentaire récupéré avec succès",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Commentaire")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Commentaire non trouvé",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="message", type="string", example="Commentaire non trouvé")
     *             )
     *         )
     *     ),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     */
    public function show(string $id)
    {
        $commentaire = Commentaire::findOrFail($id);
        return $commentaire;
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
 *     path="/commentaire/modifier/{commentaire_id}",
 *     summary="Mettre à jour un commentaire par son ID",
 *     tags={"Commentaires"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID du commentaire à mettre à jour",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"contenu"},
 *             @OA\Property(property="contenu", type="string", example="Nouveau contenu du commentaire")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Commentaire sauvegardé avec succès",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 @OA\Property(property="message", type="string", example="Commentaire sauvegardé")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Vous ne pouvez pas modifier ce commentaire",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 @OA\Property(property="message", type="string", example="Vous ne pouvez pas modifier ce commentaire")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Commentaire non trouvé",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 @OA\Property(property="message", type="string", example="Commentaire non trouvé")
 *             )
 *         )
 *     ),
 *     security={
 *         {"bearerAuth": {}}
 *     }
 * )
 */
    public function update(ModifierCommentaireRequest $request, string $id)
    {
        $commentaire = Commentaire::findOrFail($id);
        // dd($commentaire);
        // dd(auth()->user()->id);
        if(auth()->user()->id == $commentaire->user_id){
            // dd("ok");
            $commentaire->contenu = $request->contenu;
            $commentaire->save();
            return response()->json('Commentaire sauvegardé', 200);
        }else{
            return response()->json('Vous ne pouvez pas modifier ce commentaire', 403);
        }
    }

        // 
        
    public function update(ModifierCommentaireRequest $request, string $id)
    {
        $commentaire = Commentaire::findOrFail($id);
        $commentaire->contenu = $request->contenu;

        $commentaire->save();
        return response('update Commentaire OK', 200);
    }

    /**
     * Remove the archieve resource from storage.
     */
    /**
 * @OA\Put(
 *     path="/commentaire/archiver/{commentaire_id}",
 *     summary="Archiver un commentaire par son ID",
 *     tags={"Commentaires"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID du commentaire à archiver",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Commentaire archivé avec succès",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 @OA\Property(property="message", type="string", example="Commentaire archivé avec succès")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Vous ne pouvez pas archiver ce commentaire",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 @OA\Property(property="message", type="string", example="Vous ne pouvez pas archiver ce commentaire")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Commentaire non trouvé",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 @OA\Property(property="message", type="string", example="Commentaire non trouvé")
 *             )
 *         )
 *     ),
 *     security={
 *         {"bearerAuth": {}}
 *     }
 * )
 */


    public function archiver(string $id)
    {
        
        $commentaire = Commentaire::findOrFail($id);
        if(auth()->user()->id == $commentaire->user_id){
            $commentaire->etat = false;
            $commentaire->save();
    
            return response()->json('Archiver Commentaire OK', 200);
        }
    }
       
    // public function archiver(string $id, string $etat)
    // {
        
    //     $commentaire = Commentaire::findOrFail($id);
    //     $commentaire->etat = $etat;
    //     $commentaire->save();

    //     return response('Archiver Commentaire OK', 200);
    // }
}
