<?php

use App\Http\Controllers\Api\RoleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

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
  //Archiver les informations un compte citoyen
  Route::put('/archive/citizen/{user}', [UserController::class, 'archive']);
 

  //la route de deconnexion
    Route::post('/logout', [UserController::class, 'logout']);
});
