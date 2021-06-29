<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    // GREGAMOS LAS VALIDACIONES DE LOS CAMPOS
    public function rules()
    {
        switch ($this->method()) {

            case 'POST':
                return [
                    'usr_name'      => 'required|alpha',
                    'usr_surname'   => 'nullable|alpha',
                    'usr_email'     => 'required|email|unique:users',
                    'usr_password'  => 'min:5|max:16',
                    'usr_role'  => 'required'
                ];
                break;


            case 'PUT':
                return [
                    'usr_name'      => 'required|alpha',
                    'usr_surname'   => 'nullable|alpha',
                    'usr_password'  => 'nullable|min:5|max:16',
                    'usr_role'  => 'required'
                ];
                break;

        }
    }

    // AGREGAMOS LOS MENSAJES DE ERROR, DE ACUERDO A SU REGLA
    public function messages()
    {
        return [
            'usr_name.required' => 'El nombre es obligatorio',
            'usr_name.alpha' => 'El nombre solo puede tener letras',
            'usr_surname.alpha' => 'El apellido solo puede tener letras',
            'usr_surname.alpha' => 'El apellido solo requiere letras',
            'usr_email.required' => 'El correo es obligatorio',
            'usr_email.unique' => 'El correo ya existe',
            'usr_password.required' => 'La contraseña es obligatoria',
            'usr_password.min' => 'La contraseña debe de tener al menos 5 caracters',
            'usr_password.max' => 'La contraseña debe de tener un maximo de 16 caracters',
        ];
    }

    // SE LE CAMBIA EL NOMBRE A LOS ATRIBUTOS
    public function attributes()
    {
        return [
            'usr_name' => 'Nombre de usuario',
            'usr_surname' => 'Apellido de usuario',
            'usr_email' => 'Correo electronico',
            'usr_password' => 'Contraseña',
            'usr_role' => 'Role'
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
