<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\LogUserRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRegisterRequest;

class UserController extends Controller
{
    
    
    public function register(UserRegisterRequest $request){
        // dd('ok');
        try{
            // $request->validate($this->rules(), $this->messages());
            //  dd($request);
            $user = new User();
            $user->role_id = $request->role_id;
            $user->nom = $request->nom;
            $user->prenom = $request->prenom;
            $user->age = $request->age;
            $user->email = $request->email;
            $user->password = Hash::make($request->password, [
                'rounds' =>12
            ]) ;;
            $user->telephone = $request->telephone;
            $user->username = $request->username;
            $user->CNI = $request->CNI;
            $user->sexe = $request->sexe;
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
            //  dd($user);
            $token = $user->createToken('SESAM_OUVRE_TOI')->plainTextToken;
            return response()->json([
                'status_code'=>200,
                'status_message'=> "Utilisateur connecté", 
                'user'=> $user,
                'token'=> $token
            ]);
        }else{
            return response()->json([
                'status_code'=>403,
                'status_message'=> "Informations non valide", 
            ]);
        }
    }
    public function logout(LogUserRequest $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'status_code'=>200,
            'status_message'=> "Utilisateur déconnecté avec succès", 
            
        ]);
    }
}
