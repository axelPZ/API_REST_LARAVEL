<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Post;

class SearchController extends Controller
{
    public function search( Request $request ){


        $collection = $request->collection;
        $term = $request->term;

        $results = [];

        switch( $collection ){

            case 'users':
                $results =  $this->searchUser( $term  );
            break;

            case 'categories':
                $results =  $this->searchCategories( $term  );
            break;

            case 'posts':
                $results =  $this->searchPost( $term  );
            break;

            default:
                return response()->json( [
                    'mensaje' => ' coleccion no programada aun'
                ],500);
            break;
        }

        return response()->json(
            [
                'message' => 'resultados',
                'total' => $results[1],
                'result' => $results[0]
            ],400);
    }

    // BUSCAR USUARIO
    public function searchUser( $term = '' ){

        // trae a los usuarios omitiendo a los que estan eliminados
        $result = User::where(function ( $query ) use ( $term ){

                $query->where('usr_email','LIKE', "%$term%");

            })->orWhere(function ($query) use ( $term ) {

                $query->where('usr_name','LIKE', "%$term%");

            })->orWhere(function ($query) use ( $term ) {
                $query->where('usr_surname','LIKE', "%$term%");

            })->get();



        $count = sizeof( $result );
        return array( $result, $count );
    }



    // BUSCAR POST
    public function searchPost( $termino = '' ){

        $result = Post::where('pst_title', 'LIKE', "%$termino%")->get();
        $count = sizeof( $result );
        return array( $result, $count );
    }

    // BUSCAR CATEGORIA
    public function searchCategories( $termino = '' ){

        $result = Category::where('cat_name', 'LIKE', "%$termino%")->get();
        $count = sizeof( $result );
        return array( $result, $count );

    }
}
