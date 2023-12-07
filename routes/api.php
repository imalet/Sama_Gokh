<?php

use App\Http\Controllers\Api\RoleController;
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

// Afficher Liste Role 
Route::get('roles', [RoleController::class, 'index']);

// Ajouter un role dans la base de données 
Route::post('/role/store',[RoleController::class,'store'])->name("role.add"); 

// Modifier un role 
Route::put('/role/{id}/update',[RoleController::class,'update'])->name("role.edit");



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
