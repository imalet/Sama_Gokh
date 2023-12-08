<?php

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\MaireResource;
use Illuminate\Support\Facades\Route;
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
