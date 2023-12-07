<?php

use App\Http\Controllers\Api\AnnonceController;
use App\Http\Controllers\Api\EtatProjetController;
use App\Http\Controllers\Api\ProjetController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Tous les projets des communes
Route::get('/liste/projets', [ProjetController::class, 'index'])->name('projets.lister');
// Inserer des donnees Projet
Route::post('/projet/ajouter', [ProjetController::class, 'store'])->name('projet.ajouter');
// Modifier des donnees Projet
Route::patch('/projet/modifier/{projet_id}', [ProjetController::class, 'update'])->name('projet.modifier');
// Supprimer des donnees Projet
Route::delete('/projet/supprimer/{projet_id}', [ProjetController::class, 'destroy'])->name('projet.supprimer');

// Toutes les Annonces des communes
Route::get('/liste/annonces', [AnnonceController::class, 'index'])->name('annonces.lister');
// Inserer des donnees Annonce
Route::post('/annonce/ajouter', [AnnonceController::class, 'store'])->name('annonces.ajouter');
// Modifier des donnees Projet
Route::patch('/annonce/modifier/{annonce_id}', [AnnonceController::class, 'update'])->name('annonce.modifier');

// Toutes les Etat Projet
Route::get('/liste/etat/projet', [EtatProjetController::class, 'index'])->name('etat.projet.lister');
// Inserer un Etat Projet
Route::post('/etat/projet/ajouter', [EtatProjetController::class, 'store'])->name('etat.projet.ajouter');
// Modifier un Etat Projet
Route::patch('/etat/projet/modifier/{etatprojet_id}', [EtatProjetController::class, 'update'])->name('etat.projet.modifier');
// Supprimer un Etat Projet
Route::delete('/etat/projet/supprimer/{etatprojet_id}', [EtatProjetController::class, 'destroy'])->name('etat.projet.supprimer');

//Ajouter un commentaires
