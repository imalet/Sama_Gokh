<?php

use App\Http\Controllers\Api\AnnonceController;
use App\Http\Controllers\Api\CommentaireController;
use App\Http\Controllers\Api\EtatProjetController;
use App\Http\Controllers\Api\ProjetController;
use App\Http\Controllers\Api\TypeProjetController;
use App\Http\Controllers\Api\VoteController;
use App\Models\TypeProjet;
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


// Tous les projets
Route::get('/liste/projets', [ProjetController::class, 'index'])->name('projets.lister');
// Inserer des donnees Projet
Route::post('/projet/ajouter', [ProjetController::class, 'store'])->name('projet.ajouter');
// Afficher un projet unique
Route::get('/detail/projet/{id}', [ProjetController::class, 'show'])->name('projets.detail');
// Modifier des donnees Projet
Route::patch('/projet/modifier/{projet_id}', [ProjetController::class, 'update'])->name('projet.modifier');
// Archiver des donnees Projet
Route::patch('/projet/archiver/etat/{projet_id}/{etat}', [ProjetController::class, 'archiver'])->name('projet.archiver');


// Toutes les Annonces des communes
Route::get('/liste/annonces', [AnnonceController::class, 'index'])->name('annonces.lister');
// Inserer des donnees Annonce
Route::post('/annonce/ajouter', [AnnonceController::class, 'store'])->name('annonces.ajouter');
// Afficher un projet unique
Route::get('/detail/annonce/{id}', [AnnonceController::class, 'show'])->name('annonce.detail');
// Modifier des donnees Projet
Route::patch('/annonce/modifier/{annonce_id}', [AnnonceController::class, 'update'])->name('annonce.modifier');
// Archiver des donnees Projet
Route::patch('/annonce/archiver/etat/{annonce_id}/{etat}', [AnnonceController::class, 'archiver'])->name('annonce.archiver');


// Toutes les Etat Projet
Route::get('/liste/etat/projet', [EtatProjetController::class, 'index'])->name('etat.projet.lister');
// Inserer un Etat Projet
Route::post('/etat/projet/ajouter', [EtatProjetController::class, 'store'])->name('etat.projet.ajouter');
// Afficher les details d'un Etat Projet unique
Route::get('etat/projet/detail/{id}', [EtatProjetController::class, 'show'])->name('etat.projet.detail');
// Modifier un Etat Projet
Route::patch('/etat/projet/modifier/{etatprojet_id}', [EtatProjetController::class, 'update'])->name('etat.projet.modifier');
// Supprimer un Etat Projet
Route::delete('/etat/projet/supprimer/{etatprojet_id}', [EtatProjetController::class, 'destroy'])->name('etat.projet.supprimer');


// Toutes les Type Projet
Route::get('/liste/type/projet', [TypeProjetController::class, 'index'])->name('type.projet.lister');
// Inserer un Etat Projet
Route::post('/type/projet/ajouter', [TypeProjetController::class, 'store'])->name('type.projet.ajouter');
// Afficher les details d'un Type Projet unique
Route::get('/type/projet/detail/{id}', [TypeProjetController::class, 'show'])->name('type.projet.detail');
// Modifier un Etat Projet
Route::patch('/type/projet/modifier/{type_projet_id}', [TypeProjetController::class, 'update'])->name('type.projet.modifier');
// Supprimer un Etat Projet
Route::delete('/type/projet/supprimer/{type_projet_id}', [TypeProjetController::class, 'destroy'])->name('type.projet.supprimer');


//Lister les Commentaires Annonce
Route::get('/liste/commentaires/annonces', [CommentaireController::class, 'index'])->name('commentaires.lister');
// Inserer un Etat Projet
Route::post('/commentaires/ajouter/{annonce_id}/{user_id}', [CommentaireController::class, 'store'])->name('commentaires.ajouter');
// Afficher les details d'un Commentaire unique
Route::get('/commentaire/detail/{id}', [CommentaireController::class, 'show'])->name('commentaire.detail');
// Modifier un Commentaires Annonce
Route::patch('/commentaire/modifier/{commentaire_id}', [CommentaireController::class, 'update'])->name('commentaires.modifier');
// Archiver un Commentaires Annonce
Route::patch('/commentaire/archiver/{commentaire_id}/{etat}', [CommentaireController::class, 'archiver'])->name('commentaires.archiver');


// Liste des Votes
Route::get('/liste/vote', [VoteController::class, 'index'])->name('vote.lister');
// Modification des Votes
Route::post('/vote/ajouter', [VoteController::class, 'store'])->name('vote.ajouter');
// Afficher les details d'un vote unique
Route::get('/vote/detail/{id}', [CommentaireController::class, 'show'])->name('vote.detail');
// Modification des Votes
Route::patch('/vote/modification/{vote_id}', [VoteController::class, 'update'])->name('vote.modifier');
// Supprimer des Votes
Route::delete('/vote/supprimer/{vote_id}', [VoteController::class, 'destroy'])->name('vote.supprimer');