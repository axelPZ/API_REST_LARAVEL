<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;


class CategoryController extends Controller
{

    // CONSTRUCTOR para agregar los middleware
    public function __construct()
    {
        $this->middleware('existCategory',   ['except' => [ 'index', 'store' ] ] );
        $this->middleware('validateJWT', ['except' => [ 'index', 'show' ] ] );
        $this->middleware('isAdminRole', ['only' => [ 'destroy' ] ] );
    }

    // TODAS LAS CATEGORIAS
    public function index()
    {
        $categories = Category::all()->load('user'); //saca los datos de las categorias atravez del id guardado en post
        $count = sizeof( $categories );

        return response()->json([
            'total' => $count,
            'categories' =>  $categories
        ],200);
    }


    // GUARDAR UNA NUEVA CATEGORYA
    public function store(CategoryRequest $request)
    {
        $data = $request->json()->all();
        $userId =  config('user.id');    // obtengo el id del usario agregado al validar el JWT

        $category = new Category();
        $category->cat_name = strtoupper($data['cat_name']);
        $category->cat_userId = $userId;
        $category->save();

        return response()->json([
            'user' => $category,
        ],201);

    }

    //  MOSTRAR CATEGORIA POR ID
    public function show($category)
    {
        $category = Category::where('id', $category )->first()->load('user');
        return response()->json([
            'id' => $category
        ],200);
    }

    // EDITAR CATEGORIA
    public function update(CategoryRequest $request, $category)
    {

        $data = $request->json()->all();
        $userId = config('user.id');

        $idUserCategory = Category::where('id', $category)->first('cat_userId');

        if( $idUserCategory['cat_userId'] != $userId ){
            return response()->json([
                'message' => 'El usuario no es duenio de la categoria'
            ],400);
        }

        $updateUser = Category::where('id', $category)->update( [ 'cat_name' => strtoupper( $data[ 'cat_name'] ) ] );
        $category = Category::where('id', $category)->first();

        return response()->json([
            'message' => 'La categoria se actualizo correctamente',
            'category' => $category
        ], 200);
    }

   // ELIMINAR CATEGORIA
    public function destroy($category)
    {
        $deleteCategory = Category::find( $category )->delete();
        return response()->json([
            'message' => 'Categoria eliminada'
        ], 200);
    }
}
