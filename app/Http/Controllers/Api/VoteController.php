<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vote;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Vote::all();
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
        $newData = new Vote();
        $newData->user_id = $request->user_id;
        $newData->statut = $request->statut;
        $newData->projet_id = $request->projet_id;
        $newData->date_de_cloture = $request->date_de_cloture;

        $newData->save();

        return response('Insertion Vote OK', 200);
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
        $vote = Vote::findOrFail($id);
        $vote->user_id = $request->user_id;
        $vote->statut = $request->statut;
        $vote->projet_id = $request->projet_id;
        $vote->date_de_cloture = $request->date_de_cloture;

        $vote->save();

        return response('Modification Vote OK', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $vote = Vote::findOrFail($id);
        $vote->delete();

        return response('Supression Vote OK', 200);

    }
}
