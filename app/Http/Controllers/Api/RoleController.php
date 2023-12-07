<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRegisterRequest;

class RoleController extends Controller
{
    public function register(RoleRegisterRequest $request){
        $role = new Role();
        $role->nom = $request->nom;
        $role->save();
        
    }
}
