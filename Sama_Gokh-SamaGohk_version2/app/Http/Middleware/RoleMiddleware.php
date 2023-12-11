<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Requests\LogUserRequest;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        $roleOnRoleTable = Role::find($request->user()->role_id);
        
        if($roleOnRoleTable->nom != $role ){
            return response()->json(['Message'=>"Desole, vous n'avez pas access"], 404);
        }
        return $next($request);
    }
}
