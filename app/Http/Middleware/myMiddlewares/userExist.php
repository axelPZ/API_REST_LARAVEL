<?php

namespace App\Http\Middleware\myMiddlewares;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class userExist
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
        $id = $request->user;
        $result = User::where('id', $id)->first();

        if( isset( $result ) && is_object( $result ) ){

            return $next($request);
        }else{

            return response()->json([
                'mensaje'  =>  'sin resultados, con el id: '.$id
            ],404);
        }
    }
}
