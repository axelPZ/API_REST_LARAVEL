<?php

namespace App\Http\Middleware\myMiddlewares;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class isAdminRole
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

        $id = config('user.id');
        $user = User::findOrFail( $id );

        if( strstr($user['usr_role'], 'ADMIN_ROLE')){

            return $next($request);

        }else{
            return response()->json(
                [
                    'status' => 'error',
                    'message'  =>  'Usuario: '. $user['usr_name'] . ' sin permisos, para realizar esta accion'
                ],400);
        }
    }
}
