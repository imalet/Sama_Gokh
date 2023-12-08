<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TypeProjetResource;
use App\Models\TypeProjet;
use Illuminate\Http\Request;
use Mockery\Matcher\Type;

class TypeProjetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return TypeProjet::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $type_projet = new TypeProjet();
        $type_projet->nom = $request->nom;

        $type_projet->save();

        return response('Insertion Type Projet', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(Request $request, string $id)
    {

        $type_projet = TypeProjet::findOrFail($id);
        $type_projet->nom = $request->nom;

        $type_projet->save();

        return response('Modification Type Projet OK', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $type_projet = TypeProjet::findOrFail($id);

        $type_projet->delete();

        return response('Suppression Type Projet OK', 200);
    }
}
