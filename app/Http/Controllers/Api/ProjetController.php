<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Projet\AjouterProjetRequest;
use App\Http\Requests\Projet\ModifierProjetRequest;
use App\Http\Resources\ProjetResource;
use App\Models\Projet;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ProjetResource::collection(Projet::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $id)
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AjouterProjetRequest $request)
    {
        $newData = new Projet();
        $newData->titre = $request->titre;
        $newData->description = $request->description;
        $newData->image = $request->image;
        $newData->couts = $request->couts;
        $newData->delai = $request->delai;
        $newData->etat = $request->etat;
        $userConnecte = auth()->user()->id;
        $roleIdUserConnecte = User::find($userConnecte)->first()->role_id;

        if (Role::where('id', $roleIdUserConnecte)->first()->id === $roleIdUserConnecte) {
            // dd('ok');
            if (Role::where('id', $roleIdUserConnecte)->first()->nom == "Citoyen") {
                $newData->type_projet_id = 2;
            } elseif (Role::where('id', $roleIdUserConnecte)->first()->nom == "AdminCommune") {
                $newData->type_projet_id = 1;
            }
        }
        // $newData->type_projet_id = $request->type_projet_id;
        $newData->etat_projet_id = true;

        if ($newData->save()) {
            return response()->json(['message' => 'Insertion réussie'], 200);
        }

        return response()->json(['message' => 'Échec de l\'insertion'], 422);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $projet = Projet::findOrFail($id);
        return $projet;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ModifierProjetRequest $request, string $id)
    {

        $projet = Projet::findOrFail($id);

        $projet->titre = $request->titre;
        $projet->description = $request->description;
        $projet->image = $request->image;
        $projet->couts = $request->couts;
        $projet->delai = $request->delai;
        $projet->etat = $request->etat;
        $projet->type_projet_id = $request->type_projet_id;
        $projet->etat_projet_id = $request->etat_projet_id;

        if ($projet->save()) {
            return response('Update Ok', 200);
        }

        return response('BAD Update', 200);
    }

    /**
     * Archieve the specified resource from storage.
     */
    public function archiver(string $id, string $etat)
    {

        $projet = Projet::findOrFail($id);
        $projet->etat = $etat;
        $projet->save();

        return response('Archiver OK', 200);
    }
}
