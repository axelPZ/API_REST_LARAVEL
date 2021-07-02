<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class PostRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    // AGREGAR LAS REGLAS
    public function rules()
    {
        return [
            'pst_title' => 'required|unique:posts',
            'pst_content' => 'required',
            'pst_cateId' => 'required'
        ];
    }

    // MENSAJES DE ERROR
    public function messages(){

        return [
            'pst_title.required' => 'El nombre del Post es requerido',
            'pst_title.unique' => 'El titulo del post ya existe',
            'pst_content.required' => 'El Contenido del Post el requerido',
            'pst_cateId.required' => 'El Id de la categoria es requerido'
        ];
    }

    // CAMBIAR EL NOMBRE DE LOS ATRIBUTOS
    public function attributes()
    {
        return [
            'pst_title' => 'Titulo del post',
            'pst_content' => 'Contenido del post',
            'pst_catId' => 'Id de la categoria'
        ];
    }

    // PARA QUE ENVIE A LOS MENSAJES DE ERROR EN FORMATO JSON
    public function failedValidation( Validator $validate) {
        throw new HttpResponseException(
            response()->json([
              'errors' => $validate->errors(),
            ], 402));
    }
}
