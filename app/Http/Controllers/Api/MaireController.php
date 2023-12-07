<?php

namespace App\Http\Controllers\Api;
use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\EditMaireRequest;
use App\Http\Requests\CreateMaireRequest;

class MaireController extends Controller
{
    public function index()
    {
      try{
        return response()->json([
          'status_code' => 200,
          'status_message' =>'maire a été recupéré',
          'data'=> User::all(),
          ]);
      }
    
    Catch(Exception $e){
      return response()->json($e);
    }
    
    
  }
    public function store(CreateMaireRequest $request)
  {
    try{
$maire= new User();
$maire->nom =$request->nom;
$maire->prenom=$request->prenom;
$maire->age=$request->age;
$maire->email=$request->email;
$maire->password=$request->password;
$maire->telephone=$request->telephone;
$maire->etat=$request->etat;
$maire->username=$request->username;
$maire->CNI=$request->CNI;
$maire->sexe=$request->sexe;
$maire->role_id=$request->role_id;
$maire->save();

return response()->json([
'status_code' => 200,
'status_message' =>'Maire a été ajouté',
'data'=>$maire
]);
  }catch(Exception $e){
    return response()->json($e);
  }
 } 
 public function update(EditMaireRequest $request, $id)
 {
  try{
$maire = User::find($id);
$maire->nom =$request->nom;
$maire->prenom=$request->prenom;
$maire->age=$request->age;
$maire->email=$request->email;
$maire->password=$request->password;
$maire->telephone=$request->telephone;
$maire->etat=$request->etat;
$maire->username=$request->username;
$maire->CNI=$request->CNI;
$maire->sexe=$request->sexe;
$maire->role_id=$request->role_id;
$maire->save();

return response()->json([
  'status_code' => 200,
  'status_message' =>'Miare a été modifié',
  'data'=>$maire
  ]);
    }catch(Exception $e){
      return response()->json($e);
    }
   }  

   public function archiver($id)
   {
    
    try{
    $maire = User::find($id);
    $maire->etat='inactif';
    $maire->save();
    
    return response()->json([
      'status_code' => 200,
      'status_message' =>'Maire a été archivé',
      'data'=>$maire
      ]);
        }catch(Exception $e){
          return response()->json($e);
        }
       } 
 
}
