<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SemestreRequest extends FormRequest
{
    public function authorize(){
        return true;
    }

    public function rules()
    {

        return [
            'sem'                   => 'required|integer|min:1',
            'ano'                   => 'required|date_format:Y',
            'inicio'                => 'required|date',
            'meio'                  => 'required|date|after:inicio',
            'fim'                   => 'required|date|after:meio',
            'status'                => 'required|integer|min:0',
            'tipo'                  => 'required|string|min:7'

        ];
    }
        
    public function messages()
    {
        return [
            'sem.required'          =>'O semestre é obrigatório',
            'sem.integer'           =>'O semestre tem que ser um número',
            'sem.min'               =>'O semestre deve ser maior ou igual a 1',
            'ano.required'          =>'O ano é obrigatório',
            'ano.date_format'       =>'O formato do ano é inválido',
            'meio.required'         =>'A data do inicio da 2ª etapa é obrigatório',
            'meio.date'             =>'O formato da data do inicio da 2ª etapa é inválido',
            'meio.after'            =>'A data do inicio da 2ª etapa deve ser posterior a data de inicio do semestre',
            'inicio.required'       =>'A data do inicio do semestre é obrigatório',
            'inicio.date'           =>'O formato da data do inicio do semestre é inválido',
            'fim.required'          =>'A data do fim do semestre é obrigatório',
            'fim.date'              =>'O formato da data do fim do semestre é inválido',
            'fim.after'             =>'A data do fim do semestre deve ser posterior a data de inicio da 2ª etapa',
            'status.required'       =>'O status é obrigatório',
            'status.integer'        =>'O status tem que ser um número',
            'status.min'            =>'O status deve ser maior ou igual a 0',
            'tipo.required'         =>'Selecione o tipo do semestre',
            'tipo.string'           =>'O tipo deve ser uma palavra',
            'tipo.min'              => 'O tipo dever possuir no mínimo 7 letras'
        ];
    }
}