<?php
namespace App\helpers;

use Firebase\JWT\JWT;

class generateJWT{

    public function createJwt( $user='' ){

        // obtengo la llave del JWT de los .env
        $llave = env('SECRETORPRIVATEKEY', 'smtp');

        // llenar el token
        $token = array(
            'id'    => $user['id'],
            'iat'    => time(), //el tiempo que se creo el token
            'exp'    => time() + ( 1 * 12 * 60 * 60) //dias * horas * minutos * segundos = semana|el tiempo que va a cabar el token y se abra que hacer uno nuevo
        );

        //crear token
            $jwt = JWT::encode($token, $llave, 'HS256'); //el token, clave(clave unica), codificador

        return $jwt;
    }

}
