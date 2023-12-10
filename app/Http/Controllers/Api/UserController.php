<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditCitizenRequest;
use App\Http\Requests\LogUserRequest;
use App\Http\Requests\resetPasswordRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index()
    {
        return UserResource::collection(User::all());
    }

    public function show($id){
        return UserResource::collection(User::find($id));
    }

    public function register(UserRegisterRequest $request)
    {
        // dd('ok');
        try {
            // $request->validate($this->rules(), $this->messages());
            //  dd($request);
            $user = new User();
            $user->role_id = $request->role_id;
            $user->nom = $request->nom;
            $user->prenom = $request->prenom;
            // $user->age = $request->age;
            $user->email = $request->email;
            $user->password = Hash::make($request->password, [
                'rounds' => 12
            ]);;
            $user->telephone = $request->telephone;
            $user->username = $request->username;
            $user->CNI = $request->CNI;
            $user->sexe = $request->sexe;
            $user->commune_id = $request->commune_id;
            // dd($user);
            $user->save();
            // dd('ok');
            return response()->json([
                'status_code' => 200,
                'status_message' => "Utilisateur enregistré",
                'user' => $user
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }
    public function login(LogUserRequest $request)
    {
        if (auth()->attempt($request->only(['username', 'password']))) {

            $user = auth()->user();
            if ($user->etat ==  "actif") {
                //  dd($user);
                $token = $user->createToken('SESAM_OUVRE_TOI')->plainTextToken;
                return response()->json([
                    'status_code' => 200,
                    'status_message' => "Utilisateur connecté",
                    'user' => $user,
                    'token' => $token
                ]);
            } else {
                return response()->json([
                    'status_code' => 200,
                    'status_message' => "Ce compte n'existe plus"
                ]);
            }
        } else {
            return response()->json([
                'status_code' => 403,
                'status_message' => "Informations non valide",
            ]);
        }
    }
    public function logout(LogUserRequest $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'status_code' => 200,
            'status_message' => "Utilisateur déconnecté avec succès",

        ]);
    }
    public function update(EditCitizenRequest $request, User $user)
    {
        // dd($user);
        try {
            $user->role_id = auth()->user()->role_id;
            $user->nom = $request->nom;
            $user->prenom = $request->prenom;
            $user->age = $request->age;
            $user->email = $request->email;

            $user->telephone = $request->telephone;
            $user->username = $request->username;
            $user->CNI = $request->CNI;
            $user->sexe = $request->sexe;
            // dd($user);
            if ($user->id == auth()->user()->id) {
                $user->save();
                return response()->json([
                    'status_code' => 200,
                    'status_message' => "Modification du compte enregistré",
                    'user' => $user
                ]);
            } else {
                return response()->json([
                    'status_code' => 422,
                    'status_message' => "Vous ne pouvez pas modifier ce compte",
                ]);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }
    public function archive(User $user)
    {
        try {

            // dd($user);
            if ($user->id == auth()->user()->id) {
                $user->etat = "inactif";
                $user->save();
                return response()->json([
                    'status_code' => 200,
                    'status_message' => "La désactivation du compte est réussie"
                ]);
            } else {
                return response()->json([
                    'status_code' => 422,
                    'status_message' => "Vous ne pouvez pas désactiver ce compte",
                ]);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }
    public function resetPassword(resetPasswordRequest $request)
    {
        try {
            // dd('ok');
            if ($request->telephone || $request->email) {
                // dd('ok');
                $email = $request->email;
                $telephone = $request->telephone;
                if (User::where('telephone', $telephone)->get()->first()) {
                    $user = User::where('telephone', $telephone)->get()->first();
                    // dd($user->id);
                    $user->password = $request->password;
                    $user->save();
                    return response()->json([
                        'status_code' => 200,
                        'status_message' => "Le mot de passe  du compte a été réinitialisé"
                    ]);
                } elseif (User::where('email', $email)->get()->first()) {
                    $user = User::where('email', $email)->get()->first();
                    $user->password = $request->password;
                    $user->save();
                    return response()->json([
                        'status_code' => 200,
                        'status_message' => "Le mot de passe  du compte a été réinitialisé"
                    ]);
                } else {
                    return response()->json([
                        'status_code' => 403,
                        'status_message' => "Identifiants invalides"
                    ]);
                }
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }
}
