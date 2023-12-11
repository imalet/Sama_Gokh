<?php

namespace App\Http\Controllers\Api;

use App\Models\Vote;
use App\Models\Projet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Vote\AjouterVoteRequest;
use App\Http\Requests\Vote\ModifierVoteRequest;

class VoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Vote::all();
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
         *     path="/vote/ajouter/{projet}",
         *     summary="Enregistrer un nouveau vote pour un projet",
         *     tags={"Votes"},
         *     @OA\Parameter(
         *         name="projet",
         *         in="path",
         *         required=true,
         *         description="ID du projet pour lequel le vote est enregistré",
         *         @OA\Schema(type="integer")
         *     ),
         *     @OA\RequestBody(
         *         required=true,
         *         @OA\JsonContent(
         *             required={"scrutin"},
         *             @OA\Property(property="scrutin", type="string", example="Pour"),
         *         )
         *     ),
         *     @OA\Response(
         *         response=200,
         *         description="Votre vote a été enregistré",
         *         @OA\JsonContent(
         *             type="array",
         *             @OA\Items(
         *                 @OA\Property(property="message", type="string", example="Votre vote a été enregistré")
         *             )
         *         )
         *     ),
         *     @OA\Response(
         *         response=422,
         *         description="Vous avez déjà voté",
         *         @OA\JsonContent(
         *             type="array",
         *             @OA\Items(
         *                 @OA\Property(property="message", type="string", example="Vous avez déjà voté")
         *             )
         *         )
         *     ),
         *     security={}
         * )
         */
    public function store(AjouterVoteRequest $request, Projet $projet)
    {
        $newData = new Vote();
        //  dd('ok');
       $newData->user_id = auth()->user()->id;
       $newData->scrutin = $request->scrutin;
       $newData->projet_id = $projet->id;
       if(!Vote::where("user_id", auth()->user()->id)){
        $newData->save();
        return response()->json(['message'=>'Votre vote a été enregistré']);
       }else{
        return response()->json(['message'=>'Vous avez déjà voté']);
       }

    }

    /**
     * Display the specified resource.
     */
        /**
     * @OA\Post(
     *     path="/vote/detail/{id}",
     *     summary="Affichage des détails spécifiques ",
     *     tags={"Votes"},
     *     @OA\Parameter(
     *         name="projet",
     *         in="path",
     *         required=true,
     *         description="ID du projet pour lequel le vote est enregistré",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"scrutin"},
     *             @OA\Property(property="scrutin", type="string", example="Pour"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Votre vote a été enregistré",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="message", type="string", example="Votre vote a été enregistré")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Vous avez déjà voté",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="message", type="string", example="Vous avez déjà voté")
     *             )
     *         )
     *     ),
     *     security={}
     * )
     */


    public function show(string $id)
    {
        $vote = Vote::findOrFail($id);
        return $vote;
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
    

    // public function update(ModifierVoteRequest $request, string $id)
    // {
    //     $vote = Vote::findOrFail($id);
    //     $vote->user_id = $request->user_id;
    //     $vote->statut = $request->statut;
    //     $vote->projet_id = $request->projet_id;
    //     $vote->date_de_cloture = $request->date_de_cloture;

    //     if ($vote->save()) {
    //         return response()->json(["Message"=>"Modification d'un vote Reussi"],200);
    //     }
    //     return response()->json(["Message"=>"Modification d'un vote Echoué"],422);
    // }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(string $id)
    // {
    //     $vote = Vote::findOrFail($id);
    //     $vote->delete();

    //     return response('Supression Vote OK', 200);

    // }
}
