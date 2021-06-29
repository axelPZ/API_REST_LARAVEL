<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ImgRequest extends FormRequest
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
            'archivo' => 'required|image|mimes:jpg,jpeg,png,gif'
        ];
    }

    // AGREGAMOS LOS MENSAJES DE ERROR, DE ACUERDO A SU REGLA
    public function messages()
    {
        return [

            'archivo.required' => 'La imagen es requerida',
            'archivo.image'    => 'El archivo tiene que ser una imagen',
            'archivo.mimes'    => 'Solo se haceptan los siguientes tipos de imagen: jpg, jpeg, png, gif',
        ];
    }

     // SE LE CAMBIA EL NOMBRE A LOS ATRIBUTOS
     public function attributes()
     {
         return [
             'archivo' => 'Imagen',
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
