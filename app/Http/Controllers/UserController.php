<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{

    // CONSTRUCTOR para agregar los middleware
    public function __construct()
    {
        $this->middleware('existUser',   ['except' => [ 'index', 'store' ] ] );
        $this->middleware('validateJWT', ['except' => [ 'index', 'store', 'show' ] ] );
        $this->middleware('isAdminRole', ['only' => [ 'destroy' ] ] );
        $this->middleware('roleExist',   ['only' => [ 'store', 'update' ] ] );
    }

   // LISTAR TODOS LOS USUARIOS
    public function index()
    {
        $result = User::all();
        $count = sizeof( $result );

        return response()->json([
                'total' => $count,
                'posts'  =>  $result
            ],200);
    }

    /// GUARDAR NUEVO USUARIO
    public function store(UserRequest $request )
    {
        $data = $request->json()->all();
        $data['usr_password'] = hash( 'sha256', $data['usr_password']); // encriptar la password

        $user = new User();
        $user->usr_name = strtoupper($data['usr_name']);
        $user->usr_surname = strtoupper($data['usr_surname']);
        $user->usr_email = strtoupper($data['usr_email']);
        $user->usr_password = $data['usr_password'];
        $user->usr_role = strtoupper($data['usr_role']);
        $user->save();

        return response()->json([
            'users' => $user,
        ],201);
    }

    // MOSTRAR USUARIO POR ID
    public function show( $user )
    {
        $result = User::findOrFail( $user );
        return response()->json([
            'total' => $result,
        ],200);
    }

   // EDITAR USUARIO
    public function update(UserRequest $request, $user)
    {
        $data = $request->json()->all();

        // quitar los datas que no se van a actualizar
        unset( $data['id'] );
        unset( $data['usr_img'] );
        unset( $data['usr_estate'] );
        unset( $data['usr_email'] );
        unset( $data['created_at'] );

        $result = '';
        if( isset( $data['usr_password']) ){

            $data['usr_password'] = hash( 'sha256', $data['usr_password']); // encriptar la password
            $password = $data['usr_password'];
            $data = array_map('strtoupper', $data);
            $data['usr_password'] = $password;

            $user_update = User::findOrFail( $user )->update( $data );
            $result = User::findOrFail( $user );
        }else{

            unset( $data[ 'usr_password'] );
            $user_update = User::findOrFail( $user )->update( $data );
            $result = User::findOrFail( $user );

        }
        return response()->json([
                'method'  =>  $result
            ], 201);
    }

    // ELIMINAR USUARIO
    public function destroy( $user )
    {
        $user = User::find( $user )->delete();
        return response()->json([
            'message'  =>  'Usuario eliminado'
        ], 200);
    }
}
