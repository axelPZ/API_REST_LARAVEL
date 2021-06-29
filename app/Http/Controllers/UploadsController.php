<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImgRequest;
use Illuminate\Http\Response;

class UploadsController extends Controller
{

    // SUBIR IMAGEN
    public function upload( ImgRequest $request ){

        // obtener datos de la request
        $file = $request->file('archivo');
        $collection = $request->collection;
        $id = $request->id;



          // validar el id
        $validateId = new \validateId();
        $result = $validateId->validateIdColeccion( $id, $collection );

        if( empty( $result ) ){
            return response()->json( [
                    'method'  =>  " $collection, con su id: $id, sin resultados"
                ], 400);
        }

        // guardar la img
        $saveImg =new \saveImg();
        $saveImgDB = $saveImg->saveImgDB( $id, $collection, $file);

        return response()->json(
            [
                'status' => 'success',
                'name' => $saveImgDB
            ], 200);
    }


    // CARGAR IMAGEN
    public function getImg( $collection, $id ){

         // validar el id
         $validateId = new \validateId();
         $result = $validateId->validateIdColeccion( $id, $collection );
         if( empty( $result ) ){
             return response()->json( [
                     'method'  =>  " $collection, con su id: $id, sin resultados"
                 ], 400);
         }


         // obtenemos la imagen dependiendo de la coleccion
         switch ( $collection ) {
            case 'users':
                $img = $result['usr_img'];
                break;

            case 'categories':
                $img = $result['cat_img'];
                break;

            case 'posts':
                $img = $result['pst_img'];
                break;

            default:
                $result = [];
                break;
        }

         //verificar s existw la imagen
        $isset = \Storage::disk('images')->exists($img);
        if( $isset ){

            $file = \Storage::disk('images')->get($img);
            return new Response($file, 200);
        }

         return response()->json(
            [
                'message'=>'no se encontro la imagen'
            ], 404);
    }
}
