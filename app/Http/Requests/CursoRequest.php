<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CursoRequest extends FormRequest
{
    public function authorize(){
        return true;
    }

    public function rules()
    {

        return [
            'nome'                      => 'required|string|min:4',
            'sigla'                     => 'required|string|min:2',
            'tipo'                      => 'required|integer|min:1',
            'duracao'                   => 'required|integer|min:4|max:10'
        ];
    }

        public function messages()
    {
        return [
            'nome.required'         =>'O nome do curso é obrigatório',
            'nome.string'           =>'O nome do curso deve ser uma palavra',
            'nome.min'              =>'O nome do curso deve possuir ao menos 4 letras',
            'sigla.required'        =>'A sigla do curso é obrigatória',
            'sigla.string'          =>'A sigla do curso deve ser uma palavra',
            'sigla.min'             =>'A sigla do curso deve possuir ao menos 2 letras',
            'tipo.required'         =>'Selecione o tipo do curso',
            'tipo.integer'          =>'O tipo do curso tem que ser um valor númerico',
            'tipo.min'              =>'Selecione o tipo do curso',
            'duracao.required'      =>'A duração do curso é obrigatória',
            'duracao.integer'       =>'A duração do curso tem que ser um valor númerico',
            'duracao.min'           =>'A duração do curso miníma é 4 semestres',
            'duracao.max'           =>'A duração do curso máxima é 10 semestres'
        ];
    }
}