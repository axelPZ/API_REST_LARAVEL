<?php

namespace App\Http\Middleware\myMiddlewares;

use Closure;
use Illuminate\Http\Request;

class validateCollection
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
        $collection = $request->collection;

        $allowedCollections = array(
            'users',
            'posts',
            'categories'
        );

        // validar colleccion
        if( !in_array( $collection, $allowedCollections) ) {
            return response()->json( [
                    'message' => 'coleccion no valida. colecciones validas: '.implode( ',', $allowedCollections)
                ],400);
        }

        return $next($request);
    }
}
