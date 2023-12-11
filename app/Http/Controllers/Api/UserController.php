<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\LogOutRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LogUserRequest;
use App\Http\Requests\EditCitizenRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\resetPasswordRequest;
use App\Models\Commune;
use App\Models\Ville;

class UserController extends Controller
{
    
    
    public function register(UserRegisterRequest $request){
        // dd('ok');
        try{
            // $request->validate($this->rules(), $this->messages());
            //  dd($request);
            $user = new User();
             $idCitoyen = Role::where("nom", "Citoyen")->get()->first()->id;
            // dd($idCitoyen);
            //$idCitoyen;
            $user->role_id = 6;
            $user->nom = $request->nom;
            $user->prenom = $request->prenom;
            // $user->age = $request->age;
            $user->email = $request->email;
            $user->password = Hash::make($request->password, [
                'rounds' =>12
            ]) ;;
            $user->telephone = $request->telephone;
            $user->username = $request->username;
            $user->CNI = $request->CNI;
            $user->sexe = $request->sexe;
            $villes = [
                "Dakar"=>["Yoff", "Ngor"],
                "Thiès"=>["Mbour", "Thiès Nord", "Fandène"],
            ];
            foreach($villes as $key=>$ville){

                 if( in_array($request->commune, $ville)){
                    //  dd(Commune::where("nom",$key)->get()->first());
                    //  Ville::where($key)->get()->first()->id
                    // dd();
                     $user->commune_id = Commune::where("nom", $request->commune)->get()->first()->id;
                 }
                // dd($key);
            }
           
            // dd($user);
            $user->save();
            // dd('ok');
            return response()->json([
                'status_code'=>200,
                'status_message'=> "Utilisateur enregistré",
                'user'=>$user
            ]);
        }catch(Exception $e){
            return response()->json($e);
        }
    }
    public function login(LogUserRequest $request){
        if(auth()->attempt($request->only(['username', 'password']))){

            $user = auth()->user();
            if($user->etat ==  true){
                //  dd($user);
            $token = $user->createToken('SESAM_OUVRE_TOI')->plainTextToken;
            return response()->json([
                'status_code'=>200,
                'status_message'=> "Utilisateur connecté", 
                'user'=> $user,
                'token'=> $token
            ]);
            }else {
                return response()->json([
                    'status_code'=>200,
                    'status_message'=> "Ce compte n'existe plus"
                ]);
            }
            
        }else{
            return response()->json([
                'status_code'=>403,
                'status_message'=> "Informations non valide", 
            ]);
        }
    }
    public function logout(LogOutRequest $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'status_code'=>200,
            'status_message'=> "Utilisateur déconnecté avec succès", 
            
        ]);
    }
    public function update(EditCitizenRequest $request, User $user){
        // dd($user);
        try{
            $user->role_id = auth()->user()->role_id;
            $user->nom = $request->nom;
            $user->prenom = $request->prenom;
            // $user->age = $request->age;
            $user->email = $request->email;
           
            $user->telephone = $request->telephone;
            $user->username = $request->username;
            $user->CNI = $request->CNI;
            $user->sexe = $request->sexe;
            // dd($user);
            if($user->id == auth()->user()->id){
                $user->save();
                return response()->json([
                    'status_code'=>200,
                    'status_message'=> "Modification du compte enregistré",
                    'user'=>$user
                ]);
            }  else {
                return response()->json([
                    'status_code'=>422,
                    'status_message'=> "Vous ne pouvez pas modifier ce compte",
                ]);
            }                       
            
        }catch(Exception $e){
            return response()->json($e);
        }
    }
    public function archive(Request $request, User $user){
        try{
            
            // dd($user);
            if($user->id == auth()->user()->id){
                $user->etat = false;
                $user->save();
                $request->user()->currentAccessToken()->delete();
                return response()->json([
                    'status_code'=>200,
                    'status_message'=> "La désactivation du compte est réussie"
                ]);
            }  else {
                return response()->json([
                    'status_code'=>422,
                    'status_message'=> "Vous ne pouvez pas désactiver ce compte",
                ]);
            }                       
            
        }catch(Exception $e){
            return response()->json($e);
        }
    }
    public function resetPassword(resetPasswordRequest $request){
        try{
            // dd('ok');
            if($request->telephone || $request->email){
                // dd('ok');
                $email = $request->email;
                $telephone = $request->telephone;
                if(User::where('telephone', $telephone)->get()->first()){
                    $user = User::where('telephone', $telephone)->get()->first();
                    // dd($user->id);
                    $user->password = $request->password;
                    $user->save();
                    return response()->json([
                                'status_code'=>200,
                               'status_message'=> "Le mot de passe  du compte a été réinitialisé"
                    ]);
                }elseif(User::where('email', $email)->get()->first()){
                    $user = User::where('email', $email)->get()->first();
                    $user->password = $request->password;
                    $user->save();
                    return response()->json([
                                'status_code'=>200,
                               'status_message'=> "Le mot de passe  du compte a été réinitialisé"
                    ]);
                }else{
                    return response()->json([
                        'status_code'=>403,
                       'status_message'=> "Identifiants invalides"
            ]);
                }
        }
           
        }catch(Exception $e){
            return response()->json($e);
        }
    }
}
