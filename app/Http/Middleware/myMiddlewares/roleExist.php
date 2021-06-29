<?php

namespace App\Http\Middleware\myMiddlewares;

use Closure;
use Illuminate\Http\Request;
use App\Models\Role;

class roleExist
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $data = $request->json()->all();
        $result = Role::where('role_name', '=', strtoupper( $data['usr_role']) )
                        ->first();

        if( isset( $result ) && is_object( $result ) ){

         return $next($request);
        }else{

            $roles = Role::all();
            return response()->json([
                'mensaje'  =>  'Role no admitido',
                'roles admitidos' => $roles
            ],404);
        }
    }
}
