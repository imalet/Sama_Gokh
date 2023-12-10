<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vote\AjouterVoteRequest;
use App\Http\Requests\Vote\ModifierVoteRequest;
use App\Http\Resources\VoteResource;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return VoteResource::collection(Vote::all());
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
    public function store(AjouterVoteRequest $request)
    {
        $newData = new Vote();
        $newData->user_id = auth()->user()->id;
        $newData->statut = $request->statut;
        $newData->projet_id = $request->projet_id;
        $newData->date_de_cloture = $request->date_de_cloture;

        if ($newData->save()) {
            return response()->json(["Message"=>"Insertion d'un vote Reussi"],200);
        }
        return response()->json(["Message"=>"Insertion d'un vote Echoué"],422);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $vote = Vote::findOrFail($id);
        return $vote;
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
    public function update(ModifierVoteRequest $request, string $id)
    {
        $vote = Vote::findOrFail($id);
        $vote->user_id = $request->user_id;
        $vote->statut = $request->statut;
        $vote->projet_id = $request->projet_id;
        $vote->date_de_cloture = $request->date_de_cloture;

        if ($vote->save()) {
            return response()->json(["Message"=>"Modification d'un vote Reussi"],200);
        }
        return response()->json(["Message"=>"Modification d'un vote Echoué"],422);
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
