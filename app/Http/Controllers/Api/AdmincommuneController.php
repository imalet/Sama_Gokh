<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
use App\Http\Controllers\Controller;
use App\Http\Requests\EditAdmincommuneRequest;
use App\Http\Requests\CreateAdmincommuneRequest;
use App\Http\Requests\ArchiveAdmincommuneRequest;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(title="endpointadmincommune", version="0.1")
 */

class AdmincommuneController extends Controller
{

/**
 * @OA\Get(
  *     path="/api/admin_commune/lister",
  *     summary="Récupérer la liste des administrateurs de commune",
  *     description="Cette API renvoie la liste de tous les administrateurs de commune enregistrés dans la base de données.",
 *     @OA\Response(response=200, description="Liste des admincommunes")
 * )
 */

  public function index()
  {
    try {
      return response()->json([
        'status_code' => 200,
        'status_message' => 'admincommune a été recupéré',
        'data' => User::all(),
      ]);
    } catch (Exception $e) {
      return response()->json($e);
    }
  }

/**
 
*@OA\Post(
*path="admin_commune/create",
*summary="ajouter les admincommunes dans la base de données",
*@OA\Response(response="200", description="l'inscription des admincommunes")
*)
*/
  public function store(CreateAdmincommuneRequest $request)
  {
    try {
      $admincommune = new User();
      $admincommune->nom = $request->nom;
      $admincommune->prenom = $request->prenom;
      $admincommune->email = $request->email;
      $admincommune->password = $request->password;
      $admincommune->telephone = $request->telephone;
      // $admincommune->etat = $request->etat;
      $admincommune->username = $request->username;
      $admincommune->CNI = $request->CNI;
      $admincommune->sexe = $request->sexe;
      $idAdminCommune = Role::where("nom", "AdminCommune")->get()->first()->id;
      $admincommune->role_id = $idAdminCommune;
      
      $admincommune->commune_id = auth()->user()->commune_id;
      $admincommune->save();

      return response()->json([
        'status_code' => 200,
        'status_message' => 'admincommune a été ajouté',
        'data' => $admincommune
      ]);
    } catch (Exception $e) {
      return response()->json($e);
    }
  }
 

 /**
 
*@OA\Put(
*path="admin_commune/edit/{id}",
*summary="modifier les admincommunes insérés",
*@OA\Response(response="200", description="la modification des admincommunes")
*)
*/

  public function update(EditAdmincommuneRequest $request, $id)
  {
    try {
      $admincommune = User::find($id);
      if(Role::where("nom", "Maire")->get()->first()->id == auth()->user()->role_id && 
      Role::where("id",$admincommune->role_id)->get()->first()->nom == "AdminCommune"){
        // dd("ok");
        $admincommune->nom = $request->nom;
        $admincommune->prenom = $request->prenom;
        $admincommune->email = $request->email;
        $admincommune->password = $request->password;
        $admincommune->telephone = $request->telephone;
        $admincommune->username = $request->username;
        $admincommune->save();

      return response()->json([
        'status_code' => 200,
        'status_message' => 'admincommune a été modifié',
        'data' => $admincommune
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
 
*@OA\Put(
*path="admin_commune/archive/{id}",
*summary="archiver les admincommunes insérés",
*@OA\Response(response="200", description=" l'archivage d'admincommune")
*)
*/
  public function archiver($id)
  {

    try {
      $admincommune = User::find($id);
      if(Role::where("nom", "Maire")->get()->first()->id == auth()->user()->role_id && 
      Role::where("id",$admincommune->role_id)->get()->first()->nom == "AdminCommune"){
        $admincommune->etat = false;
        $admincommune->save();
        return response()->json([
          'status_code' => 200,
          'status_message' => 'admincommune a été archivé',
          'data' => $admincommune
        ]);
      }else{
        return response()->json([
          'status_message' => 'Vous ne pouvez archiver ce compte'
        ]);
      }
      

      
    } catch (Exception $e) {
      return response()->json($e);
    }
  }
}
