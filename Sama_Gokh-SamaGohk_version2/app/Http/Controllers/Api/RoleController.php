<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRegisterRequest;
use App\Http\Resources\RoleResource;

class RoleController extends Controller
{

    public function index(RoleRegisterRequest $request){
        return response("OK TOP",200);
    }

    public function store(RoleRegisterRequest $request){
        $role = new Role();
        $role->nom = $request->nom;
        $role->save();
    }
}
