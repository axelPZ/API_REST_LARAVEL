<?php

namespace App\helpers;

use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Category;
use App\Models\Post;

class saveImg
{
    public function saveImgDB( $id, $coleccion, $archivo ){

        $img = '';
        $model = '';

        // se guarda la imagen en el servidor
        $archivo_name = time().$archivo->getClientOriginalName(); // nombre crear el nombre del arhivo
        $path = $archivo->storeAs($coleccion, $archivo_name, 'images');// 'coleccion' contiene el nombre de la carpeta dentro del disco.  'images' nombre del disco

        // se guarda la ruta de img en la DB dependiendo de la coleccion
        switch ($coleccion) {

            case 'users':

                $result = User::where('id', $id)->first('usr_img');
                $updateModel = User::where( 'id',$id )->update( ['usr_img' => $path ]  );
                $img = $result['usr_img'];

                $model = User::where('id', $id)->first();
                break;

            case 'categories':

                $result = Category::where('id', $id)->first('cat_img');
                $updateModel = Category::where( 'id',$id )->update( ['cat_img' => $path ]  );
                $img = $result['cat_img'];

                $model = Category::where('id', $id)->first();
                break;


            case 'posts':

                    $result = Post::where('id', $id)->first('pst_img');
                    $updateModel = Post::where( 'id',$id )->update( ['pst_img' => $path ]  );
                    $img = $result['pst_img'];

                    $model = Post::where('id', $id)->first();
                    break;

            default:
                $result = [];
                break;
        }

        // se borra la img que se habia guardado anteriomente
        $isset = \Storage::disk('images')->exists($img);
        if( $isset ){
            unlink( storage_path( 'app/images/'.$img ) );
        }

        return $model;

    }
}
