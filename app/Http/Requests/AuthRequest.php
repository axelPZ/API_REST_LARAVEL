<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AuthRequest extends FormRequest
{
    // poner en true
    public function authorize()
    {
        return true;
    }

  // SE AGREGAN LAS REGLAS DE VALIDACION
    public function rules()
    {
        return [
            'usr_email'     => 'required|email',
            'usr_password'  => 'min:5|max:16',
        ];
    }

    // AGREGAMOS LOS MENSAJES DE ERROR, DE ACUERDO A SU REGLA
    public function messages()
    {
        return [
            'usr_email.required' => 'El correo es obligatorio',
            'usr_password.required' => 'La contraseña es obligatoria',
            'usr_password.min' => 'La contraseña debe de tener al menos 5 caracters',
            'usr_password.max' => 'La contraseña debe de tener un maximo de 16 caracters',
        ];
    }

     // SE LE CAMBIA EL NOMBRE A LOS ATRIBUTOS
     public function attributes()
     {
         return [
             'usr_email' => 'Correo electronico',
             'usr_password' => 'Contraseña',
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
