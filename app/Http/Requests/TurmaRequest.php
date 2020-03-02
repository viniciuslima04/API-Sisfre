<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TurmaRequest extends FormRequest
{
    
    public function authorize(){
        return true;
    }

    public function rules()
    {

        return [
            'periodo'     => 'required|integer|min:1',
            'turno'       => ['required', Rule::in(['D', 'M', 'T', 'N']),'string','max:1'],
            'semestre'    => 'required|integer|min:1'
        ];
    }

    public function messages()
    {
        return [
            'periodo.required'      =>'O periodo é obrigatório',
            'periodo.integer'       =>'O periodo tem que ser um número',
            'periodo.min'           =>'O periodo deve possuir ao menos 1 número',
            'turno.required'        =>'O turno é obrigatório',
            'turno.string'          =>'O turno tem que ser uma palavra',
            'turno.in'              =>'O turno não é válido',
            'turno.max'             =>'O turno não pode ser maior que 1 letra',
            'semestre.required'     =>'O semestre da turma é obrigatório',
            'semestre.integer'      =>'Selecione o semestre',
            'semestre.min'          =>'Selecione um semestre antes'
        ];
    }
}