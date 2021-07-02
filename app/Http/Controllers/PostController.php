<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Requests\PostRequest;
use App\Models\Category;
use Exception;

class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware( 'validateJWT', [ 'except' => [ 'index', 'show' ] ] );
        $this->middleware( 'isAdminRole', [ 'only'   => ['destroy'] ] );
    }

   // TODOS LOS POST
    public function index()
    {
        $posts = Post::all()->load('category');

        return response()->json([
            'Post' => $posts
        ], 201);
    }

   // AGREGAR POST
    public function store(PostRequest $request)
    {

        $data = $request->json()->all();
        $userId = config('user.id');

        $category = Category::where('id', $data['pst_cateId'])->first();

        if( !isset( $category )){
            return response()->json([
                'message' => 'no existe la categoria, con el id: '.$data['pst_cateId'],
            ], 404);
        }

        $post = new Post();
        $post->pst_title =strtoupper( $data['pst_title'] );
        $post->pst_content = $data['pst_content'];
        $post->pst_cateId = $data['pst_cateId'];
        $post->pst_userId = $userId;
        $post->save();

        return response()->json([
            'message' => 'Se agrego correctamente el Post',
            'data' => $post
        ], 200);
    }

   // POST POR ID
    public function show($id)
    {
        try{

            $post = Post::findOrFail( $id );
            return response()->json([
                'data' => $post
            ], 200);

        }catch( Exception $e){

            return response()->json([
                'message' => 'No se encontro ningun post con id: '.$id
            ], 404);

        }
    }

    // EDITAR POST
    public function update(PostRequest $request, $id)
    {
            $data = $request->json()->all();
            unset( $data['deleted_at'] );
            unset( $data['created_at'] );
            unset( $data['pst_userId'] );

            $userId = config('user.id');



        try{

            $idUserPost = Post::where('id', $id)->first('pst_userId');

            if( $idUserPost['pst_userId'] != $userId ){
                return response()->json([
                    'message' => 'El usuario no es duenio del post'
                ],400);
            }

            $data[ 'pst_title' ] = strtoupper( $data[ 'pst_title'] );
            $updatePost = Post::findOrFail( $id )->update( $data );
            $post = Post::findOrFail( $id );

            return response()->json([
                'message' => 'El Post se a actualizado correctamente',
                'post' => $post
            ], 201);

        }catch( Exception $e){

            return response()->json([
                'error' => 'No se pudo actualizar el post',
                'cusas' => 'No existe ningun post con el id '.$id
            ],400);
        }

    }

   // ELIMINAR POST
    public function destroy($id)
    {
        try{

            $postDelete = Post::findOrFail( $id )->delete();
            return response()->json([
                'message' => 'Se elimino el post correctamente'
            ],200);

        }catch( Exception $e){

            return response()->json([
                'error' => 'No se pudo actualizar el post',
                'cusas' => 'No existe ningun post con el id '.$id
            ],400);
        }
    }
}
