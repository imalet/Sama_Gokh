<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Projet\AjouterProjetRequest;
use App\Http\Requests\Projet\ModifierProjetRequest;
use App\Http\Resources\ProjetResource;
use App\Models\EtatProjet;
use App\Models\Projet;
use App\Models\Role;
use App\Models\TypeProjet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use openApi\Annotations as OA;

class ProjetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
 * @OA\Get(
 *     path="/projets",
 *     summary="Obtenir la liste des projets",
 *     tags={"Projets"},
 *     @OA\Response(
 *         response=200,
 *         description="Liste des projets",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/ProjetResource")
 *         )
 *     ),
 *     security={}
 * )
 */
    public function index()
    {
        return ProjetResource::collection(Projet::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $id)
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
 * @OA\Post(
 *     path="/projets",
 *     summary="Créer un nouveau projet",
 *     tags={"Projets"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"titre", "description", "image", "couts", "delai"},
 *             @OA\Property(property="titre", type="string", example="Titre du projet"),
 *             @OA\Property(property="description", type="string", example="Description du projet"),
 *             @OA\Property(property="image", type="string", format="binary", description="Image du projet"),
 *             @OA\Property(property="couts", type="integer", example=10000),
 *             @OA\Property(property="delai", type="string", example="2023-12-31"),
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Projet créé avec succès",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/ProjetResource")
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Échec de l'insertion",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 @OA\Property(property="message", type="string", example="Échec de l'insertion")
 *             )
 *         )
 *     ),
 *     security={}
 * )
 */

    public function store(AjouterProjetRequest $request)
    {
        $newData = new Projet();
        $newData->titre = $request->titre;
        $newData->description = $request->description;
        if($request->file('image')){
            $file = $request->file('image');
            $fileName = date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('public/images'), $fileName);
            $newData['image'] = $fileName;
        }
        $newData->couts = $request->couts;
        $newData->delai = $request->delai;
        $newData->user_id = auth()->user()->id;
        // $newData->etat = $request->etat;
        // $userConnecte = auth()->user()->id;
        // dd($userConnecte);
        $roleIdUserConnecte = auth()->user()->role_id;
        // dd($roleIdUserConnecte);
        if(Role::where('id',$roleIdUserConnecte)->get()->first()->id === $roleIdUserConnecte){
            // dd('ok');
            if(Role::where('id',$roleIdUserConnecte)->get()->first()->nom == "Citoyen"){
                // dd('ok');
                $newData->type_projet_id = TypeProjet::where('nom', "Citoyen")->get()->first()->id;
            }elseif(Role::where('id',$roleIdUserConnecte)->first()->nom == "AdminCommune"){
                // dd('ok');
                 $newData->type_projet_id = TypeProjet::where('nom', "Communal")->get()->first()->id;;
               
            }
            
         }
        // $newData->type_projet_id = $request->type_projet_id;
         $newData->etat_projet_id = EtatProjet::where("statut", "En cours")->get()->first()->id;

        if ($newData->save()) {
            return response()->json(['message' => 'Insertion réussie'], 200);
         }

        return response()->json(['message' => 'Échec de l\'insertion'], 422);
    }

    /**
     * Display the specified resource.
     */
        /**
     * @OA\Post(
     *     path="/projets",
     *     summary="Créer un nouveau projet",
     *     tags={"Projets"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"titre", "description", "image", "couts", "delai"},
     *             @OA\Property(property="titre", type="string", example="Titre du projet"),
     *             @OA\Property(property="description", type="string", example="Description du projet"),
     *             @OA\Property(property="image", type="string", format="binary", description="Image du projet"),
     *             @OA\Property(property="couts", type="integer", example=10000),
     *             @OA\Property(property="delai", type="string", example="2023-12-31 13:00"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Projet créé avec succès",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/ProjetResource")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Échec de l'insertion",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="message", type="string", example="Échec de l'insertion")
     *             )
     *         )
     *     ),
     *     security={}
     * )
     */
    public function show(string $id)
    {
        $projet = Projet::findOrFail($id);
        return $projet;
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
    public function update(ModifierProjetRequest $request, string $id)
    {

        $projet = Projet::findOrFail($id);
        if(Role::where("nom", "AdminCommune")->get()->first()->id == auth()->user()->role_id && 
        TypeProjet::where("id",$projet->type_projet_id)->get()->first()->nom == "Communal"){
            // dd("Ok");
            $projet->titre = $request->titre;
            $projet->description = $request->description;
            $projet->couts = $request->couts;
            $projet->delai = $request->delai;
            if ($projet->save()) {
                    return response()->json('Modification du projet réussie', 200);
            }
            }elseif(Role::where("nom", "Citoyen")->get()->first()->id == auth()->user()->role_id && 
            TypeProjet::where("id",$projet->type_projet_id)->get()->first()->nom == "Citoyen"){
                // dd("Ok");
                $projet->titre = $request->titre;
                $projet->description = $request->description;
                $projet->couts = $request->couts;
                $projet->delai = $request->delai;
                if ($projet->save()) {
                        return response()->json('Modification du projet réussie', 200);
                }
            }else{
            return response()->json('Vous ne pouvez pas modifier ce projet', 403);
      }
       
        // $projet->image = $request->image;
       
        
        // $projet->etat = $request->etat;
        // $projet->type_projet_id = $request->type_projet_id;
        // $projet->etat_projet_id = $request->etat_projet_id;

        // 

        return response('BAD Update', 200);
    }

    /**
     * Archieve the specified resource from storage.
     */
        /**
     * @OA\Put(
     *     path="/projets/{id}",
     *     summary="Modifier un projet existant",
     *     tags={"Projets"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du projet à modifier",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"titre", "description", "couts", "delai"},
     *             @OA\Property(property="titre", type="string", example="Nouveau titre"),
     *             @OA\Property(property="description", type="string", example="Nouvelle description"),
     *             @OA\Property(property="couts", type="integer", example=15000),
     *             @OA\Property(property="delai", type="string", example="2024-01-31 13:00"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Modification réussie du projet",
     *         @OA\JsonContent(
     *             type="string",
     *             example="Modification du projet réussie"
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Vous ne pouvez pas modifier ce projet",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="message", type="string", example="Vous ne pouvez pas modifier ce projet")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Projet non trouvé",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="message", type="string", example="Projet non trouvé")
     *             )
     *         )
     *     ),
     *     security={}
     * )
     */
    public function archiver(string $id)
    {

        $projet = Projet::findOrFail($id);
        if(Role::where("nom", "AdminCommune")->get()->first()->id == auth()->user()->role_id && 
        TypeProjet::where("id",$projet->type_projet_id)->get()->first()->nom == "Communal"){
            $projet->etat = false;
            $projet->save();
            return response()->json('Projet archiver avec succès', 200);
        }elseif(Role::where("nom", "Citoyen")->get()->first()->id == auth()->user()->role_id && 
        TypeProjet::where("id",$projet->type_projet_id)->get()->first()->nom == "Citoyen"){
            $projet->etat = false;
            $projet->save();
            return response()->json('Projet archiver avec succès', 200);
        }
        else{
            return response()->json('Vous ne pouvez pas archiver ce projet', 403);
        }
        
    }
}
