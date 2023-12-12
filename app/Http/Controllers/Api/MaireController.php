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

class MaireController extends Controller
{
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
      $maire->etat = $request->etat;
      $maire->username = $request->username;
      $maire->CNI = $request->CNI;
      $maire->sexe = $request->sexe;
      $maire->role_id = $request->role_id;
      $maire->commune_id = $request->commune_id;
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
      

     
      $maire->nom = $request->nom;
      $maire->prenom = $request->prenom;
      $maire->email = $request->email;
      $maire->password = $request->password;
      $maire->telephone = $request->telephone;
      $maire->etat = $request->etat;
      $maire->username = $request->username;
      $maire->CNI = $request->CNI;
      $maire->sexe = $request->sexe;
      $maire->role_id = $request->role_id;
      $maire->commune_id = $request->commune_id;
      $maire->save();

      return response()->json([
        'status_code' => 200,
        'status_message' => 'Miare a été modifié',
        'data' => $maire
      ]);
    } catch (Exception $e) {
      return response()->json($e);
    }
  }

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
      
      $maire->etat = 'inactif';
      $maire->save();

      return response()->json([
        'status_code' => 200,
        'status_message' => 'Maire a été archivé',
        'data' => $maire
      ]);
    } catch (Exception $e) {
      return response()->json($e);
    }
  }
}
