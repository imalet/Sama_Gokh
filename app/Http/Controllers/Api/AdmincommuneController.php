<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\EditAdmincommuneRequest;
use App\Http\Requests\CreateAdmincommuneRequest;


class AdmincommuneController extends Controller
{
 
 public function store(CreateAdmincommuneRequest $request)
  {
    try{
$admincommune= new User();
$admincommune->nom=$request->nom;
$admincommune->prenom=$request->prenom;
$admincommune->age=$request->age;
$admincommune->email=$request->email;
$admincommune->password=$request->password;
$admincommune->telephone=$request->telephone;
$admincommune->etat=$request->etat;
$admincommune->username=$request->username;
$admincommune->CNI=$request->CNI;
$admincommune->sexe=$request->sexe;
$admincommune->role_id=$request->role_id;
$admincommune->save();

return response()->json([
'status_code' => 200,
'status_message' =>'admincommune a été ajouté',
'data'=>$admincommune
]);
  }catch(Exception $e){
    return response()->json($e);
  }
 }  

 public function update(EditAdmincommuneRequest $request, $id)
 {
  try{
$admincommune = User::find($id);
$admincommune->nom =$request->nom;
$admincommune->prenom=$request->prenom;
$admincommune->age=$request->age;
$admincommune->email=$request->email;
$admincommune->password=$request->password;
$admincommune->telephone=$request->telephone;
$admincommune->etat=$request->etat;
$admincommune->username=$request->username;
$admincommune->CNI=$request->CNI;
$admincommune->sexe=$request->sexe;
$admincommune->role_id=$request->role_id;
$admincommune->save();

return response()->json([
  'status_code' => 200,
  'status_message' =>'admincommune a été modifié',
  'data'=>$admincommune
  ]);
    }catch(Exception $e){
      return response()->json($e);
    }
   }  

 }

