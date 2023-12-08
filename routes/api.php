<?php

use App\Http\Controllers\Api\CommuneController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\VilleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
