<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Annonce;
use Illuminate\Http\Request;

class AnnonceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Annonce::all();
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
        $newData = new Annonce();
        $newData->titre = $request->titre;
        $newData->image = $request->image;
        $newData->description = $request->description;
        $newData->etat = $request->etat;
        $newData->user_id = 1;

        if ($newData->save()) {
            return response('Insertion Ok', 200);
        }

        return response('BAD Insert', 200);
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
        $annonce = Annonce::findOrFail($id);

        $annonce->titre = $request->titre;
        $annonce->image = $request->image;
        $annonce->description = $request->description;
        $annonce->etat = $request->etat;

        if ($annonce->save()) {
            return response('Update Ok', 200);
        }

        return response('BAD Update', 200);
    }

    /**
     * Archieve the specified resource from storage.
     */
    public function archiver(string $id)
    {
        return response('ARCHIVE', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


}
