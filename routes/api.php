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
use App\Http\Resources\ProjetResource;
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

    // Afficher les details d'un role unique
    Route::get('role/detail/{id}', [RoleController::class, 'show'])->name('role.detail');

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

    // Afficher les details d'une ville unique
    Route::get('ville/detail/{id}', [VilleController::class, 'show'])->name('ville.detail');

    // Modifier une ville 
    Route::put('/ville/update/{ville}', [VilleController::class, 'update'])->name("ville.update");

    // Collection Ville
    Route::get('/ressource/villes', function () {
        $villes = Ville::all();
        return VilleResource::collection($villes);
    });

    // ----------------------------------------COMMUNE------------------------------------------------
    // Afficher Liste communes 
    Route::get('communes', [CommuneController::class, 'index']);

    // Ajouter une commune dans la base de données 
    Route::post('/commune/store', [CommuneController::class, 'store'])->name("commune.add");

    // Afficher les details d'une commune unique
    Route::get('commune/detail/{id}', [CommuneController::class, 'show'])->name('commune.detail');

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

    // Toutes les Types de Projet
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

    // -----------------------------------ACTION PROFIL SUPER ADMIN----------------------------------------

    //Afficher toutes les details de profils du compte du Super Admin
    Route::get('/superadmin/afficher/{id}', [UserController::class, 'show']);

    //Modifier les informations de profils du  compte du Super Admin
    Route::put('/superadmin/update/{user}', [UserController::class, 'update']);

    //Archiver les informations un compte Super Admin
    Route::put('/archive/superadmin/{user}', [UserController::class, 'archive']);
});

// ---------------------------------LES ACTIONS DU CITOYEN-------------------------------

Route::middleware(['auth:sanctum', 'role:Citoyen'])->group(function () {

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
    Route::post('/vote/ajouter', [VoteController::class, 'store'])->name('vote.ajouter');

    // ----------------------------------------ACTION PROFIL DU CITOYEN -----------------------------------------------

    //Afficher toutes les details de profils du compte du citoyen
    Route::get('/citizen/afficher/{id}', [UserController::class, 'show']);

    //Modifier les informations de profils du  compte du citoyen
    Route::put('/edit/citizen/{user}', [UserController::class, 'update']);

    //Archiver les informations un compte citoyen
    Route::put('/archive/citizen/{user}', [UserController::class, 'archive']);
});

// ---------------------------------LES ACTIONS DU MAIRE-------------------------------

Route::middleware(['auth:sanctum', 'role:Maire'])->group(function () {

    //Pour achiver admin_commune
    Route::put('admin_commune/archive/{id}', [AdmincommuneController::class, 'archiver']);
    //Afficher toutes les details de profils du compte du maire
    Route::get('/admin_commune/afficher/{id}', [UserController::class, 'show']);
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

    // ----------------------------------------ACTION PROFIL DU MAIRE -----------------------------------------------

    //Afficher toutes les details de profils du compte du maire
    Route::get('/maire/afficher/{id}', [UserController::class, 'show']);

    //Modifier les informations de profils du  compte du maire
    Route::put('/edit/maire/{user}', [UserController::class, 'update']);

    //Archiver les informations un compte maire
    Route::put('/archive/maire/{user}', [UserController::class, 'archive']);
});

//-----------------------------LES ACTIONS DE L'ADMIN COMMUNE---------------------------

Route::middleware(['auth:sanctum', 'role:AdminCommune'])->group(function () {


    // Inserer des donnees Annonce
    Route::post('/annonce/ajouter', [AnnonceController::class, 'store'])->name('annonces.ajouter');
    // Modifier des donnees Annonce
    Route::patch('/annonce/modifier/{annonce_id}', [AnnonceController::class, 'update'])->name('annonce.modifier');
    // Archiver des donnees Annonce
    Route::patch('/annonce/archiver/etat/{annonce_id}/{etat}', [AnnonceController::class, 'archiver'])->name('annonce.archiver');


    // Liste des Votes
    Route::get('/liste/vote', [VoteController::class, 'index'])->name('vote.lister');

    // Afficher les details d'un vote unique
    Route::get('/vote/detail/{id}', [CommentaireController::class, 'show'])->name('vote.detail');
    // Modification des Votes
    Route::patch('/vote/modification/{vote_id}', [VoteController::class, 'update'])->name('vote.modifier');
    // Supprimer des Votes
    Route::delete('/vote/supprimer/{vote_id}', [VoteController::class, 'destroy'])->name('vote.supprimer');


    // ----------------------------------------ACTION PROFIL DU ADMIN COMMUNE -----------------------------------------------

    //Afficher toutes les details de profils du compte du admin_commune
    Route::get('/admin_commune/afficher/{id}', [UserController::class, 'show']);

    //Modifier les informations de profils du  compte du admin_commune
    Route::put('/edit/admin_commune/{user}', [UserController::class, 'update']);

    //Archiver les informations un compte admin_commune
    Route::put('/archive/admin_commune/{user}', [UserController::class, 'archive']);
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
