<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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
//pour achiver admin_commune
Route::put('admin_commune/archive/{id}',[AdmincommuneController::class, 'archiver']);
//pour modifier admin_commune
 Route::put('admin_commune/edit/{id}',[AdmincommuneController::class,'update']);
//ajouter admin_commune
Route::post('admin_commune/create',[AdmincommuneController::class,'store']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
