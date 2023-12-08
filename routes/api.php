<?php

use App\Http\Controllers\Api\CommuneController;
use App\Http\Controllers\Api\RoleController;
// use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\VilleController;
use App\Http\Resources\CommuneResource;
use App\Http\Resources\RoleResource;
use App\Http\Resources\VilleResource;
use App\Models\Commune;
use App\Models\Role;
use App\Models\Ville;
// use App\Http\Controllers\Api\RoleController;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\MaireResource;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Resources\AdmincommuneResource;
use App\Http\Controllers\Api\MaireController;
use App\Http\Controllers\Api\AdmincommuneController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
// Les Routes de création de comptes utilisateurs et de création de roles
Route::post('/register', [UserController::class, 'register']);
Route::post('register/role', [RoleController::class, 'register']);
//La Routes de connexion  d'un utilisateur
Route::post('/login', [UserController::class, 'login']);

// Lien qui permet aux applications clients(Angular, React, Node ...) de se connecter 

// Route::get('link', function(){
//     return 'Here is the link.';
// });

// Les Routes de Roles 

// Afficher Liste Role 
Route::get('roles', [RoleController::class, 'index']);

// Ajouter un role dans la base de données 
Route::post('/role/store',[RoleController::class,'store'])->name("role.add"); 

// Modifier un role 
Route::put('/role/update/{role}',[RoleController::class,'update'])->name("role.update");

// ----------------------------------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------------

// Les Routes de Villes 
// Afficher Liste Villes 
Route::get('villes', [VilleController::class, 'index']);

// Ajouter une ville dans la base de données 
Route::post('/ville/store',[VilleController::class,'store'])->name("ville.add"); 

// Modifier une ville 
Route::put('/ville/update/{ville}',[VilleController::class,'update'])->name("ville.update");


// ----------------------------------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------------

// Les Routes de communes
// Afficher Liste communes 
Route::get('communes', [CommuneController::class, 'index']);

// Ajouter une commune dans la base de données 
Route::post('/commune/store',[CommuneController::class,'store'])->name("commune.add"); 

// Modifier une commune 
Route::put('/commune/update/{commune}',[CommuneController::class,'update'])->name("commune.update");

// Test Ajouter User
Route::post('/user/store',[UserController::class,'store']); 

// Collection Ville
Route::get('/ressource/villes', function(){
    $villes = Ville::all();
    return VilleResource::collection($villes);
});

// Collection commune
Route::get('/ressource/communes', function(){
    $communes = Commune::all();
    return CommuneResource::collection($communes);
});

// Collection rôle
Route::get('/ressource/roles', function(){
    $roles = Role::all();
    return RoleResource::collection($roles);
});
 
//Collection resource Admincommune
Route::get('projet/resourceadmincommune',function(){
    $admincommune=User::all();
    return AdmincommuneResource::collection($admincommune);
});
//pour achiver admin_commune
Route::put('admin_commune/archive/{id}',[AdmincommuneController::class, 'archiver']);
//pour modifier admin_commune
 Route::put('admin_commune/edit/{id}',[AdmincommuneController::class,'update']);
//ajouter admin_commune
Route::post('admin_commune/create',[AdmincommuneController::class,'store']);
//lister admin_commune
Route::get('admin_commune/lister',[AdmincommuneController::class, 'index']);


//Collection resource Maire
Route::get('projet/resourcemaire',function(){
    $maire=User::all();
    return MaireResource::collection($maire);
    
});
//lister maire
Route::get('maire/lister',[MaireController::class, 'index']);

//ajouter maire
Route::post('maire/create',[MaireController::class,'store']);
//pour modifier Maire
Route::put('maire/edit/{id}',[MaireController::class,'update']);

//pour achiver maire
Route::put('maire/archive/{id}',[MaireController::class, 'archiver']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
 //Changer mon mot de passe []
 Route::put('/reset/password', [UserController::class, 'resetPassword']);
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
//     //la route de deconnexion
//     Route::post('/logout', [UserController::class, 'logout']);
// });
Route::middleware(['auth:sanctum', 'role:SuperAdmin'])->group(function(){
   //la route de deconnexion
     Route::post('/logout', [UserController::class, 'logout']);
});

Route::middleware(['auth:sanctum', 'role:Citoyen'])->group(function(){

  //la gestion du profil d'un citoyen : 
  //Modifier les informations de profils du  compte du citoyen
  Route::put('/edit/citizen/{user}', [UserController::class, 'update']);
  //Archiver leFs informations un compte citoyen
  Route::put('/archive/citizen/{user}', [UserController::class, 'archive']);
 

  //la route de deconnexion
Route::post('/logout', [UserController::class, 'logout']);

});