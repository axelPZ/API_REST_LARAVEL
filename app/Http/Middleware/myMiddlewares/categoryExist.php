<?php

namespace App\Http\Middleware\myMiddlewares;

use Closure;
use Illuminate\Http\Request;

use App\Models\Category;
use Exception;

class categoryExist
{

    public function handle(Request $request, Closure $next)
    {
        $id = $request->category;
        $result = Category::where('id', $id)->first();

        if( isset( $result ) && is_object( $result ) ){

            return $next($request);
        }else{

            return response()->json([
                'mensaje'  =>  'No se encontro ninguna categoria con el id: '.$id
            ],404);
        }
    }
}
