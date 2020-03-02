<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UsuarioRequest extends FormRequest
{
    public function authorize(){
        return true;
    }

    public function rules()
    {
        $user = $this->route('usuario');

        return [
            'email'                     => ['required', Rule::unique('usuario')->ignore($user),'string','email','max:160'],
            'password'                  => 'required|string|min:6',
            'acesso'                    => 'required|integer|min:1',
            'username'                  => 'required|string|min:8',
            'abreviatura'               => ['required', Rule::unique('usuario')->ignore($user),'string','min:2'],
            'password_confirmation'     => 'required|same:password'
        ];
    }

        public function messages()
    {
        return [
            'username.required'                 =>'O nome do usuário é obrigatório',
            'username.string'                   =>'O nome do usuário tem que ser uma palavra',
            'username.min'                      =>'O nome do usuário deve possuir ao menos 8 letras',
            'email.required'                    =>'O E-mail é obrigatório',
            'email.string'                      =>'O E-mail tem que ser texto',
            'email.email'                       =>'O E-mail deve ser um E-mail válido',
            'email.unique'                      =>'O E-mail já está em uso',
            'email.max'                         =>'O E-mail não pode ser maior que 160 letras',
            'password.required'                 =>'A senha é obrigatória',
            'password.string'                   =>'A senha tem que ser uma palavra',
            'password.min'                      =>'A senha deve possuir ao menos 6 caracteres',
            'acesso.required'                   =>'Selecione um tipo de usuário',
            'acesso.integer'                    =>'O tipo de usuário tem que ser um número',
            'acesso.min'                        =>'Selecione um tipo de usuário',
            'abreviatura.required'              =>'A abreviatura é obrigatória',
            'abreviatura.string'                =>'A abreviatura tem que ser uma palavra',
            'abreviatura.unique'                =>'A abreviatura já está em uso',
            'abreviatura.min'                   =>'A abreviatura deve possuir ao menos 2 letras',
            'password_confirmation.required'    =>'A senha de confirmação está vazia',
            'password_confirmation.same'        =>'A senha de confirmação não condiz com a senha digitada',
        ];
    }
}