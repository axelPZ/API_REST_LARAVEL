<?php

namespace App\Http\Middleware\myMiddlewares;

use Closure;
use Illuminate\Http\Request;

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
        $data = $request->user; // extraigo el usuario de la request que e ingresado en el middleware de validacion

        if( strstr($data['usr_role'], 'ADMIN_ROLE')){

            return $next($request);

        }else{
            return response()->json(
                [
                    'status' => 'error',
                    'message'  =>  'Usuario: '. $data['usr_name'] . ' sin permisos, para realizar esta accion'
                ],400);
        }
    }
}
