<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UploadsController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


// RUTAS DEL USUARIO
Route::apiResource('/user', UserController::class)->middleware('api');

// RUTA DE LOGIN
Route::post('/auth', [AuthController::class, 'login'])->middleware('api');

// RUTA DE BUSCAR
Route::get('/search/{collection}/{term}', [ SearchController::class, 'search'])->middleware('api', 'collectionExist');

// SUBIR IMAGEN
Route::post('/uploads/{collection}/{id}', [ UploadsController::class, 'upload'])->middleware('api', 'collectionExist');

// SERVIR LA IMAGEN
Route::get('/uploads/{collection}/{id}', [UploadsController::class, 'getImg'])->middleware('api', 'collectionExist');

// RUTAS DE LAS CATEGORIAS
Route::apiResource('/category', CategoryController::class)->middleware('api');
