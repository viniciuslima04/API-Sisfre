<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeriadoRequest extends FormRequest
{

    public function authorize(){
        return true;
    }

    public function rules()
    {

        return [
            'nome'                      => 'required|string|max:160|min:6',
            'tipo'                      => 'required|integer|min:1',
            'inicio'                    => 'required|date'
        ];
    }

        public function messages()
    {
        return [
            'nome.required'          =>'O nome do feriado é obrigatório',
            'nome.string'            =>'O nome do feriado deve ser uma palavra',
            'nome.min'               =>'O nome do feriado deve possuir ao menos 6 caracteres',
            'nome.max'               =>'O nome do feriado não pode ultrapassar 160 caracteres',
            'tipo.required'          =>'Selecione o tipo do feriado',
            'tipo.integer'           =>'O tipo do feriado deve ser um valor númerico',
            'tipo.min'               =>'Selecione o tipo do feriado',
            'inicio.required'        =>'Informe o dia do feriado',
            'inicio.date'            =>'O dia do feriado deve ser uma data válida'
        ];
    }
}