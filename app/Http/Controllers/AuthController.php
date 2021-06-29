<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Models\User;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login( AuthRequest $request ){

        $data = $request->json()->all();
        $email = strtoupper( $data['usr_email'] );
        $password = hash( 'sha256', $data['usr_password']);

        $user = User::where('usr_email', '=', $email)
                    ->where('usr_password', '=', $password)
                    ->first();

        if( empty( $user )  ){
            return response()->json([
                'message' => 'No se encontro ningun usuario'
            ], 404);
        }

         $newJwt = new \generateJWT(); // llamamos el helper que genera el JWT
         $jwt = $newJwt->createJwt( $user );

        return response()->json([
                'user'  =>  $user,
                'token' => $jwt
            ], 200);
    }
}
