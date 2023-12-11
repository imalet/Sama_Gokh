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
use App\Http\Controllers\Api\AnnonceController;
use App\Http\Controllers\Api\CommentaireController;
use App\Http\Controllers\Api\EtatProjetController;
use App\Http\Controllers\Api\ProjetController;
use App\Http\Controllers\Api\TypeProjetController;
use App\Http\Controllers\Api\VoteController;
use App\Models\TypeProjet;
use Illuminate\Http\Request;
use App\Http\Resources\MaireResource;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Resources\AdmincommuneResource;
use App\Http\Controllers\Api\MaireController;
use App\Http\Controllers\Api\AdmincommuneController;
use GuzzleHttp\Middleware;

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

// ---------------------------------LES ACTIONS DU SUPER ADMIN-------------------------------

Route::middleware(['auth:sanctum', 'role:SuperAdmin'])->group(function () {

    //-----------------------------------------ROLES-------------------------------------
    // Afficher Liste Role 
    Route::get('roles', [RoleController::class, 'index']);
    // Ajouter un role dans la base de données 
    Route::post('/role/store', [RoleController::class, 'store'])->name("role.add");
    // Modifier un role 
    Route::put('/role/update/{role}', [RoleController::class, 'update'])->name("role.update");

    // Collection rôle
    Route::get('/ressource/roles', function () {
        $roles = Role::all();
        return RoleResource::collection($roles);
    });

    // ----------------------------------------VILLE--------------------------------------------
    // Afficher Liste Villes 
    Route::get('villes', [VilleController::class, 'index']);
    // Ajouter une ville dans la base de données 
    Route::post('/ville/store', [VilleController::class, 'store'])->name("ville.add");
    // Modifier une ville 
    Route::put('/ville/update/{ville}', [VilleController::class, 'update'])->name("ville.update");

    // Collection Ville
    Route::get('/ressource/villes', function () {
        $villes = Ville::all();
        return VilleResource::collection($villes);
    });

    // ----------------------------------------COMMMUNE------------------------------------------------
    // Afficher Liste communes 
    Route::get('communes', [CommuneController::class, 'index']);
    // Ajouter une commune dans la base de données 
    Route::post('/commune/store', [CommuneController::class, 'store'])->name("commune.add");
    // Modifier une commune 
    Route::put('/commune/update/{commune}', [CommuneController::class, 'update'])->name("commune.update");
    // Test Ajouter User
    Route::post('/user/store', [UserController::class, 'store']);

    // Collection commune
    Route::get('/ressource/communes', function () {
        $communes = Commune::all();
        return CommuneResource::collection($communes);
    });

    // ----------------------------------------ETAT PROJET-----------------------------------------------------------------

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

    // ----------------------------------------TYPE PROJET----------------------------------------

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

    // ----------------------------------------MAIRE-----------------------------------------------

    //lister maire
    Route::get('maire/lister', [MaireController::class, 'index']);
    //ajouter maire
    Route::post('maire/create', [MaireController::class, 'store']);
    //pour modifier Maire
    Route::put('maire/edit/{id}', [MaireController::class, 'update']);
    //pour achiver maire
    Route::put('maire/archive/{id}', [MaireController::class, 'archiver']);

    //Collection resource Maire
    Route::get('projet/resourcemaire', function () {
        $maire = User::all();
        return MaireResource::collection($maire);
    });
});

// ---------------------------------LES ACTIONS DU CITOYEN-------------------------------

Route::middleware(['auth:sanctum', 'role:Citoyen'])->group(function () {

    //Modifier les informations de profils du  compte du citoyen
    Route::put('/edit/citizen/{user}', [UserController::class, 'update']);
    //Archiver les informations un compte citoyen
    Route::put('/archive/citizen/{user}', [UserController::class, 'archive']);

    //Lister les Commentaires Annonce
    Route::get('/liste/commentaires/annonces', [CommentaireController::class, 'index'])->name('commentaires.lister');
    // Inserer un Etat Projet
    Route::post('/commentaires/ajouter/{annonce_id}', [CommentaireController::class, 'store'])->name('commentaires.ajouter');
    // Afficher les details d'un Commentaire unique
    Route::get('/commentaire/detail/{id}', [CommentaireController::class, 'show'])->name('commentaire.detail');
    // Modifier un Commentaires Annonce
    Route::patch('/commentaire/modifier/{commentaire_id}', [CommentaireController::class, 'update'])->name('commentaires.modifier');
    // Archiver un Commentaires Annonce
    Route::patch('/commentaire/archiver/{commentaire_id}', [CommentaireController::class, 'archiver'])->name('commentaires.archiver');

    // AJouter des Votes
    Route::post('/vote/ajouter/{projet}', [VoteController::class, 'store'])->name('vote.ajouter');
});

// ---------------------------------LES ACTIONS DU MAIRE-------------------------------

Route::middleware(['auth:sanctum', 'role:Maire'])->group(function () {

    // ----------------------------------------ADMIN_COMMUNE----------------------------------

    //Pour achiver admin_commune
    Route::put('admin_commune/archive/{id}', [AdmincommuneController::class, 'archiver']);
    //pour modifier admin_commune
    Route::put('admin_commune/edit/{id}', [AdmincommuneController::class, 'update']);
    //ajouter admin_commune
    Route::post('admin_commune/create', [AdmincommuneController::class, 'store']);
    //lister admin_commune
    Route::get('admin_commune/lister', [AdmincommuneController::class, 'index']);

    //Collection resource Admincommune
    Route::get('projet/resourceadmincommune', function () {
        $admincommune = User::all();
        return AdmincommuneResource::collection($admincommune);
    });
});

//-----------------------------LES ACTIONS DE L'ADMIN COMMUNE---------------------------

Route::middleware(['auth:sanctum', 'role:AdminCommune'])->group(function () {


    // Inserer des donnees Annonce
    Route::post('/annonce/ajouter', [AnnonceController::class, 'store'])->name('annonces.ajouter');

    // Modifier des donnees Projet
    Route::patch('/annonce/modifier/{annonce_id}', [AnnonceController::class, 'update'])->name('annonce.modifier');
    // Archiver des donnees Projet
    Route::patch('/annonce/archiver/etat/{annonce_id}', [AnnonceController::class, 'archiver'])->name('annonce.archiver');


    // Liste des Votes
    Route::get('/liste/vote', [VoteController::class, 'index'])->name('vote.lister');

    // Afficher les details d'un vote unique
    Route::get('/vote/detail/{id}', [CommentaireController::class, 'show'])->name('vote.detail');
    // Modification des Votes
    Route::patch('/vote/modification/{vote_id}', [VoteController::class, 'update'])->name('vote.modifier');
    // Supprimer des Votes
    Route::delete('/vote/supprimer/{vote_id}', [VoteController::class, 'destroy'])->name('vote.supprimer');
});

// ---------------------------------LES ROUTES PUBLIC-------------------------------

// Les Routes de création de comptes utilisateurs
Route::post('/register', [UserController::class, 'register']);

//La Routes de connexion  d'un utilisateur
Route::post('/login', [UserController::class, 'login']);

// Toutes les Annonces des communes
Route::get('/liste/annonces', [AnnonceController::class, 'index'])->name('annonces.lister');

// Afficher un projet unique
Route::get('/detail/annonce/{id}', [AnnonceController::class, 'show'])->name('annonce.detail');

// Tous les projets
Route::get('/liste/projets', [ProjetController::class, 'index'])->name('projets.lister');

// Afficher un projet unique
Route::get('/detail/projet/{id}', [ProjetController::class, 'show'])->name('projets.detail');

//Changer mon mot de passe
Route::put('/reset/password', [UserController::class, 'resetPassword']);


// ---------------------------------LES ACTIONS COMMUN DES DIFFERENTS USERS CONNECTES-------------------------------

Route::middleware(['auth:sanctum'])->group(function () {

    // Inserer des donnees Projet
    Route::post('/projet/ajouter', [ProjetController::class, 'store'])->name('projet.ajouter');
    // Modifier des donnees Projet
    Route::patch('/projet/modifier/{projet_id}', [ProjetController::class, 'update'])->name('projet.modifier');
    // Archiver des donnees Projet
    Route::patch('/projet/archiver/etat/{projet_id}/{etat}', [ProjetController::class, 'archiver'])->name('projet.archiver');

    // Pour se deconnecter
    Route::post('/logout', [UserController::class, 'logout']);
});
