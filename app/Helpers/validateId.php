<?php

namespace App\helpers;

use Illuminate\Support\Facades\DB;
use App\Models\User;
// use App\Models\Category;
// use App\Models\Post;

class validateId
{
    // validar si el rol existe en la DB
    public function validateIdColeccion( $id = 0, $modelo ){

        $result=[];

        switch ($modelo) {
            case 'users':
                $result = User::where('id', $id)->first();
                break;

            case 'categories':
                    //$result = Category::where('cat_id', $id)->first();
                break;

            case 'posts':
                    //$result = Post::where('pst_id', $id)->first();
                break;

            default:
                $result = [];
                break;
        }

        return $result;

    }
}
