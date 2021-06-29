<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CategoryRequest extends FormRequest
{
    // siempre estar en true
    public function authorize()
    {
        return true;
    }

    // GREGAMOS LAS VALIDACIONES DE LOS CAMPOS
    public function rules()
    {
        return [
            'cat_name' => 'required|alpha|unique:categories'
        ];
    }

    // AGREGAMOS LOS MENSAJES DE ERROR, DE ACUERDO A SU REGLA
    public function messages()
    {
        return [

            'cat_name.required' => 'EL nombre de la categoria es obligatorio',
            'cat_name.alpha'    => 'En el nombre de la categoria solo se haceptan letras',
            'cat_name.unique'    => 'Ya existe una categoria con ese nombre',
        ];
    }

     // SE LE CAMBIA EL NOMBRE A LOS ATRIBUTOS
     public function attributes()
     {
         return [
             'cat_name' => 'Nombre de la categoria',
         ];
     }

     // CON ESTE METODO SE DEVUELVE LA RESPUESTA HTTP, sin esta funcion nos redireccionaria a la pagina principal y como es un ajax, seria un gran error
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
        'errors' => $validator->errors(),
        ], 422));
    }
}
