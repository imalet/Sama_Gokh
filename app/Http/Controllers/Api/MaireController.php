<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\EditMaireRequest;
use App\Http\Requests\CreateMaireRequest;
use App\Models\Commune;

/**
 * @OA\Info(title="endpointmaire", version="0.1")
 */

class MaireController extends Controller
{

  /**
 * @OA\Get(
 *     path="/api/maire/lister",
 *     summary="Récupérer la liste des maires",
 *     description="Cette API renvoie la liste de tous les maires enregistrés dans la base de données.",
 *     tags={"Maire"},
 *     @OA\Response(
 *         response=200,
 *         description="Succès. La liste des maires a été récupérée avec succès.",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status_code", type="integer", example=200),
 *             @OA\Property(property="status_message", type="string", example="maire a été récupéré"),
 *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/User")),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Erreur interne du serveur. En cas d'échec lors de la récupération des maires.",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="string", example="Internal Server Error"),
 *         ),
 *     ),
 * )
 */
  public function index()
  {
    try {
      return response()->json([
        'status_code' => 200,
        'status_message' => 'maire a été recupéré',
        'data' => User::all(),
      ]);
    } catch (Exception $e) {
      return response()->json($e);
    }
  }

   /**
 * @OA\Post(
 *     path="/api/maire/create",
 *     summary="Ajouter un maire dans la base de données",
 *     tags={"Maire"},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Données du maire à ajouter",
 *         @OA\JsonContent(
 *             @OA\Property(property="nom", type="string", example="Nom du maire"),
 *             @OA\Property(property="prenom", type="string", example="Prénom du maire"),
 *             @OA\Property(property="email", type="string", format="email", example="exemple@domaine.com"),
 *             @OA\Property(property="password", type="string", example="MotDePasse123"),
 *             @OA\Property(property="telephone", type="string", example="0123456789"),
 *             @OA\Property(property="username", type="string", example="NomUtilisateur"),
 *             @OA\Property(property="CNI", type="string", example="1234567890"),
 *             @OA\Property(property="sexe", type="string", enum={"Masculin", "Féminin"}, example="Masculin"),
 *             @OA\Property(property="commune", type="string", example="Nom de la commune"),
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Succès. Le maire a été ajouté avec succès.",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status_code", type="integer", example=200),
 *             @OA\Property(property="status_message", type="string", example="Maire a été ajouté"),
 *             @OA\Property(property="data", ref="#/components/schemas/User"),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Erreur interne du serveur. En cas d'échec lors de l'ajout du maire.",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="string", example="Internal Server Error"),
 *         ),
 *     ),
 * )
 */
  public function store(CreateMaireRequest $request)
  {
    try {
      $maire = new User();
      $maire->nom = $request->nom;
      $maire->prenom = $request->prenom;
      $maire->email = $request->email;
      $maire->password = $request->password;
      $maire->telephone = $request->telephone;
      // $maire->etat = $request->etat;
      $maire->username = $request->username;
      $maire->CNI = $request->CNI;
      $maire->sexe = $request->sexe;
      $idRoleMaire = Role::where("nom", "Maire")->get()->first()->id;
      $maire->role_id = $idRoleMaire;
    //   $villes = [
    //     "Dakar"=>["Yoff", "Ngor"],
    //     "Thiès"=>["Mbour", "Thiès Nord"],
    // ];
      $communeId = Commune::where("nom", $request->commune)->get()->first()->id;
    
      $maire->commune_id = $communeId;
      $maire->save();

      return response()->json([
        'status_code' => 200,
        'status_message' => 'Maire a été ajouté',
        'data' => $maire
      ]);
    } catch (Exception $e) {
      return response()->json($e);
    }
  }

    /**
 * @OA\Put(
 *     path="/api/maire/edit/{id}",
 *     summary="Modifier le profil d'un maire",
 *     tags={"Maire"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID du maire à modifier",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         description="Données du maire à mettre à jour",
 *         @OA\JsonContent(ref="#/components/schemas/EditMaireRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Succès. Le profil du maire a été modifié avec succès.",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status_code", type="integer", example=200),
 *             @OA\Property(property="status_message", type="string", example="Le profil du Maire a été modifié"),
 *             @OA\Property(property="data", ref="#/components/schemas/User"),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Erreur interne du serveur. En cas d'échec lors de la modification du profil du maire.",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="string", example="Internal Server Error"),
 *         ),
 *     ),
 * )
 */
  public function update(EditMaireRequest $request, $id)
  {
    try {
      $maire = User::find($id);
      // dd(Role::where("id",$maire->role_id)->get()->first()->nom);
      if(Role::where("nom", "SuperAdmin")->get()->first()->id == auth()->user()->role_id && Role::where("id",$maire->role_id)->get()->first()->nom == "Maire"){
        // dd('ok');
          $maire->nom = $request->nom;
          $maire->prenom = $request->prenom;
          $maire->email = $request->email;
          $maire->password = $request->password;
          $maire->telephone = $request->telephone;
          $maire->username = $request->username;
          $maire->CNI = $request->CNI;
          $maire->sexe = $request->sexe;
          $maire->save();
      return response()->json([
        'status_code' => 200,
        'status_message' => "Le profil du Maire a été modifié",
        'data' => $maire
      ]);
      }else{
        return response()->json([
          'status_message' => 'Vous ne pouvez modifier ce compte'
        ]);
      }
      

     
    } catch (Exception $e) {
      return response()->json($e);
    }
  }
   /**
 * @OA\Put(
 *     path="/api/maire/archive/{id}",
 *     summary="Archiver un maire",
 *     tags={"Maire"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID du maire à archiver",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Succès. Le maire a été archivé avec succès.",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status_code", type="integer", example=200),
 *             @OA\Property(property="status_message", type="string", example="Maire a été archivé"),
 *             @OA\Property(property="data", ref="#/components/schemas/User"),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Erreur interne du serveur. En cas d'échec lors de l'archivage du maire.",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="string", example="Internal Server Error"),
 *         ),
 *     ),
 * )
 */

  public function archiver($id)

 
  {

    try {
      $maire = User::find($id);
      if(Role::where("nom", "SuperAdmin")->get()->first()->id == auth()->user()->role_id && Role::where("id",$maire->role_id)->get()->first()->nom == "Maire"){
        $maire->etat = false;
        $maire->save();

        return response()->json([
        'status_code' => 200,
        'status_message' => 'Maire a été archivé',
        'data' => $maire
        ]);
      }else {
        return response()->json([
          'status_message' => 'Vous ne pouvez archiver ce compte'
        ]);
      }
      
    } catch (Exception $e) {
      return response()->json($e);
    }
  }
}
