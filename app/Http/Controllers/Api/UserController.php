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
use App\Models\Ville;

class UserController extends Controller
{
    
        /**
     * @OA\Post(
     *     path="/register",
     *     summary="Enregistrer un nouvel utilisateur",
     *     tags={"Utilisateurs"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nom", "prenom", "email", "password", "telephone", "username", "CNI", "sexe", "commune"},
     *             @OA\Property(property="nom", type="string", example="Doe"),
     *             @OA\Property(property="prenom", type="string", example="John"),
     *             @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="secret"),
     *             @OA\Property(property="telephone", type="string", example="123456789"),
     *             @OA\Property(property="username", type="string", example="johndoe"),
     *             @OA\Property(property="CNI", type="string", example="123456789"),
     *             @OA\Property(property="sexe", type="string", example="Homme"),
     *             @OA\Property(property="commune", type="string", example="Ngor"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Utilisateur enregistré",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="status_code", type="integer", example=200),
     *                 @OA\Property(property="status_message", type="string", example="Utilisateur enregistré"),
     *                 @OA\Property(property="user", ref="#/components/schemas/User")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur d'enregistrement de l'utilisateur",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="status_code", type="integer", example=422),
     *                 @OA\Property(property="status_message", type="string", example="Erreur d'enregistrement de l'utilisateur")
     *             )
     *         )
     *     ),
     *     security={}
     * )
     */
    public function register(UserRegisterRequest $request){
        
        try{
            // dd("ok");
            $user = new User();
            $idCitoyen = Role::where("nom", "Citoyen")->get()->first()->id;
            //  $idSuperAdmin = Role::where("nom", "SuperAdmin")->get()->first()->id;
            //  if($idSuperAdmin){
            //     $user->role_id = $idSuperAdmin;
            //  }else{
            //     $user->role_id = $idCitoyen;
            //  }
            $user->role_id = $idCitoyen;
            $user->nom = $request->nom;
            $user->prenom = $request->prenom;
            $user->email = $request->email;
            $user->password = Hash::make($request->password, [
                'rounds' =>12
            ]);
            $user->telephone = $request->telephone;
            $user->username = $request->username;
            $user->CNI = $request->CNI;
            $user->sexe = $request->sexe;
            $villes = [
                "Dakar"=>["Yoff", "Ngor"],
                "Diourbel"=>["Bambey"],
                "Fatick"=>["Diofior", "Diakhao"],
                "Kaffrine"=>["Diamagadio"],
                "Kaolack"=>["Kahone"],
                "Kédougou"=>["Fongolembi"],
                "Kolda"=>["Dinguiraye"],
                "Louga"=>["Coki"],
                "Matam"=>["Thilogne"],
                "Saint-Louis"=>["Richard Toll"],
                "Sedhiou"=>["Bambali"],
                "Tambacounda"=>["Missirah"],
                "Thiès"=>["Mbour", "Thiès Nord"],
                "Ziguinchor"=>["Niaguis"]
            ];
            foreach($villes as $key=>$ville){

                 if( in_array($request->commune, $ville)){
                     $user->commune_id = Ville::where("nom",$key)->get()->first()->id;
                 }
            }
        //    dd($user);
            
            $user->save();
            
            return response()->json([
                'status_code'=>200,
                'status_message'=> "Utilisateur enregistré",
                'user'=>$user
            ]);
        }catch(Exception $e){
            return response()->json($e);
        }
    }
        /**
     * @OA\Post(
     *     path="/login",
     *     summary="Connecter un utilisateur",
     *     tags={"Utilisateurs"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"username", "password"},
     *             @OA\Property(property="username", type="string", example="johndoe"),
     *             @OA\Property(property="password", type="string", format="password", example="secret"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Utilisateur connecté",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="status_code", type="integer", example=200),
     *                 @OA\Property(property="status_message", type="string", example="Utilisateur connecté"),
     *                 @OA\Property(property="user", ref="#/components/schemas/User"),
     *                 @OA\Property(property="token", type="string", example="Bearer {token}")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Informations non valides",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="status_code", type="integer", example=403),
     *                 @OA\Property(property="status_message", type="string", example="Informations non valides")
     *             )
     *         )
     *     ),
     *     security={}
     * )
     */
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
        /**
     * @OA\Post(
     *     path="/logout",
     *     summary="Déconnecter un utilisateur",
     *     tags={"Utilisateurs"},
     *     @OA\Response(
     *         response=200,
     *         description="Utilisateur déconnecté avec succès",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="status_code", type="integer", example=200),
     *                 @OA\Property(property="status_message", type="string", example="Utilisateur déconnecté avec succès")
     *             )
     *         )
     *     ),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     */
    public function logout(LogOutRequest $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'status_code'=>200,
            'status_message'=> "Utilisateur déconnecté avec succès", 
            
        ]);
    }
        /**
     * @OA\Put(
     *     path="/edit/citizen/{user}",
     *     summary="Modifier le compte utilisateur citoyen",
     *     tags={"Utilisateurs"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nom", "prenom", "email", "telephone", "username", "CNI", "sexe"},
     *             @OA\Property(property="nom", type="string", example="Doe"),
     *             @OA\Property(property="prenom", type="string", example="John"),
     *             @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
     *             @OA\Property(property="telephone", type="string", example="123456789"),
     *             @OA\Property(property="username", type="string", example="johndoe"),
     *             @OA\Property(property="CNI", type="string", example="123456789"),
     *             @OA\Property(property="sexe", type="string", example="Homme"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Modification du compte enregistré",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="status_code", type="integer", example=200),
     *                 @OA\Property(property="status_message", type="string", example="Modification du compte enregistré"),
     *                 @OA\Property(property="user", ref="#/components/schemas/User")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Vous ne pouvez pas modifier ce compte",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="status_code", type="integer", example=422),
     *                 @OA\Property(property="status_message", type="string", example="Vous ne pouvez pas modifier ce compte")
     *             )
     *         )
     *     ),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     */
    public function update(EditCitizenRequest $request, User $user){
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
        /**
     * @OA\Put(
     *     path="/archive/citizen/{user}",
     *     summary="Désactiver le compte utilisateur",
     *     tags={"Utilisateurs"},
     *     @OA\Response(
     *         response=200,
     *         description="La désactivation du compte est réussie",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="status_code", type="integer", example=200),
     *                 @OA\Property(property="status_message", type="string", example="La désactivation du compte est réussie")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Vous ne pouvez pas désactiver ce compte",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="status_code", type="integer", example=422),
     *                 @OA\Property(property="status_message", type="string", example="Vous ne pouvez pas désactiver ce compte")
     *             )
     *         )
     *     ),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     */
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
        /**
     * @OA\Post(
     *     path="/reset/password",
     *     summary="Réinitialiser le mot de passe",
     *     tags={"Utilisateurs"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"telephone", "email", "password"},
     *             @OA\Property(property="telephone", type="string", example="123456789"),
     *             @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="newpassword"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Le mot de passe du compte a été réinitialisé",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="status_code", type="integer", example=200),
     *                 @OA\Property(property="status_message", type="string", example="Le mot de passe du compte a été réinitialisé")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Identifiants invalides",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="status_code", type="integer", example=403),
     *                 @OA\Property(property="status_message", type="string", example="Identifiants invalides")
     *             )
     *         )
     *     )
     * )
     */
    public function resetPassword(resetPasswordRequest $request){
        try{
           
            if($request->telephone || $request->email){
                
                $email = $request->email;
                $telephone = $request->telephone;
                if(User::where('telephone', $telephone)->get()->first()){
                    $user = User::where('telephone', $telephone)->get()->first();
                    
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
