<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Projet\AjouterProjetRequest;
use App\Http\Requests\Projet\ModifierProjetRequest;
use App\Http\Resources\ProjetResource;
use App\Models\EtatProjet;
use App\Models\Projet;
use App\Models\Role;
use App\Models\TypeProjet;
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
        if($request->file('image')){
            $file = $request->file('image');
            $fileName = date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('public/images'), $fileName);
            $newData['image'] = $fileName;
        }
        $newData->couts = $request->couts;
        $newData->delai = $request->delai;
        $newData->user_id = auth()->user()->id;
        // $newData->etat = $request->etat;
        // $userConnecte = auth()->user()->id;
        // dd($userConnecte);
        $roleIdUserConnecte = auth()->user()->role_id;
        // dd($roleIdUserConnecte);
        if(Role::where('id',$roleIdUserConnecte)->get()->first()->id === $roleIdUserConnecte){
            // dd('ok');
            if(Role::where('id',$roleIdUserConnecte)->get()->first()->nom == "Citoyen"){
                // dd('ok');
                $newData->type_projet_id = TypeProjet::where('nom', "Citoyen")->get()->first()->id;
            }elseif(Role::where('id',$roleIdUserConnecte)->first()->nom == "AdminCommune"){
                // dd('ok');
                 $newData->type_projet_id = TypeProjet::where('nom', "Communal")->get()->first()->id;;
               
            }
            
         }
        // $newData->type_projet_id = $request->type_projet_id;
         $newData->etat_projet_id = EtatProjet::where("statut", "En cours")->get()->first()->id;

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
        if(Role::where("nom", "AdminCommune")->get()->first()->id == auth()->user()->role_id && 
        TypeProjet::where("id",$projet->type_projet_id)->get()->first()->nom == "Communal"){
            // dd("Ok");
            $projet->titre = $request->titre;
            $projet->description = $request->description;
            $projet->couts = $request->couts;
            $projet->delai = $request->delai;
            if ($projet->save()) {
                    return response()->json('Modification du projet réussie', 200);
            }
            }elseif(Role::where("nom", "Citoyen")->get()->first()->id == auth()->user()->role_id && 
            TypeProjet::where("id",$projet->type_projet_id)->get()->first()->nom == "Citoyen"){
                // dd("Ok");
                $projet->titre = $request->titre;
                $projet->description = $request->description;
                $projet->couts = $request->couts;
                $projet->delai = $request->delai;
                if ($projet->save()) {
                        return response()->json('Modification du projet réussie', 200);
                }
            }else{
            return response()->json('Vous ne pouvez pas modifier ce projet', 403);
      }
       
        // $projet->image = $request->image;
       
        
        // $projet->etat = $request->etat;
        // $projet->type_projet_id = $request->type_projet_id;
        // $projet->etat_projet_id = $request->etat_projet_id;

        // 

        return response('BAD Update', 200);
    }

    /**
     * Archieve the specified resource from storage.
     */
    public function archiver(string $id, string $etat)
    {

        $projet = Projet::findOrFail($id);
        if(Role::where("nom", "AdminCommune")->get()->first()->id == auth()->user()->role_id && 
        TypeProjet::where("id",$projet->type_projet_id)->get()->first()->nom == "Communal"){
            $projet->etat = false;
            $projet->save();
            return response()->json('Projet archiver avec succès', 200);
        }elseif(Role::where("nom", "Citoyen")->get()->first()->id == auth()->user()->role_id && 
        TypeProjet::where("id",$projet->type_projet_id)->get()->first()->nom == "Citoyen"){
            $projet->etat = false;
            $projet->save();
            return response()->json('Projet archiver avec succès', 200);
        }
        else{
            return response()->json('Vous ne pouvez pas archiver ce projet', 403);
        }
        
    }
}
