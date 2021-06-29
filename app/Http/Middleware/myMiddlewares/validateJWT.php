<?php

namespace App\Http\Middleware\myMiddlewares;

use Closure;
use Illuminate\Http\Request;

use Firebase\JWT\JWT;
use Illuminate\Support\Facades\DB;
use App\Models\User; // importamos el modelo

class validateJWT
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
        // obtener el token desde los header
        $token = $request->header('x-token');

        if( !empty( $token )){

            $token = str_replace('"','', $token);
            $llave = env('SECRETORPRIVATEKEY', 'smtp'); // obtengo la llave del JWT de los .env
            $mesaje = '';

            try{

                $decoded = JWT::decode($token, $llave, ['HS256']);

                $user = User::where('id', $decoded->id)->first();

                if( isset( $user ) && is_object( $user ) ){

                    config(['user.id' => $user['id']]);

                    //$request->user = $user; // agrego el usuario a la request
                    return $next($request);

                }else{

                    $mesaje = 'no existe el usuario';
                }

            }catch( \UnexpectedValueException $e ){

                $mesaje = $e->getMessage();

            }catch( \DomainException $e ){

                $mesaje = $e->getMessage();
            }
        }else{

            $mesaje = 'token no valido';
        }

        return response()->json(
            [
                'status' => 'error',
                'message'  =>  $mesaje
            ],400);
    }


}
