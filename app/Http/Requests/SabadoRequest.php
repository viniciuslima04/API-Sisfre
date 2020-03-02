<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SabadoRequest extends FormRequest
{
    public function authorize(){
        return true;
    }

    public function rules()
    {
        $sabado = $this->route('sabado');
        return [
            'tipo'                      => 'required|string|min:5|max:9',
            'inicio'                    => ['required', Rule::unique('sabado_letivo','data')->ignore($sabado),'date']
        ];
    }

        public function messages()
    {
        return [
            'tipo.required'          =>'O dia referente ao sábado letivo é obrigatório',
            'tipo.string'            =>'O dia referente ao sábado letivo deve ser uma palavra',
            'tipo.min'               =>'Selecione o dia referente ao sábado letivo',
            'tipo.max'               =>'Opção inválida!! Selecione o dia referente ao sábado letivo',
            'inicio.required'        =>'Informe o dia do sábado letivo',
            'inicio.date'            =>'O dia do sábado letivo deve ser uma data válida',
            'inicio.unique'          =>'Já existe um sábado letivo para esse dia',
        ];
    }
}