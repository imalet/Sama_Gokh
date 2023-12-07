<?php

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

// Les Routes de Rôles 

// Afficher Liste Role 
Route::get('roles', [RoleController::class, 'index']);

// Ajouter un role dans la base de données 
Route::post('/role/store',[RoleController::class,'store'])->name("role.add"); 

// Modifier un role 
Route::put('/role/update/{role}',[RoleController::class,'update'])->name("role.edit");

// ----------------------------------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------------

// Les Routes de Villes 
// Afficher Liste Villes 
Route::get('villes', [VilleController::class, 'index']);

// Ajouter un ville dans la base de données 
Route::post('/ville/store',[VilleController::class,'store'])->name("ville.add"); 

// Modifier un ville 
Route::put('/ville/update/{ville}',[VilleController::class,'update'])->name("ville.edit");



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
