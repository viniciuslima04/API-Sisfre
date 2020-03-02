<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FaltaRequest extends FormRequest
{
    public function authorize(){
        return true;
    }

    public function rules()
    {

        return [
            'curso'                      => 'required|integer|min:1',
            'turma'                      => 'required|integer|min:1',
            'professor'                  => 'required|integer|min:1',
            'disciplina'                 => 'required|integer|min:1',
            'qtd'                        => 'required|integer|min:1',
            'dia'                        => 'required|date',
        ];
    }

        public function messages()
    {
        return [
            'curso.required'         =>'O curso é obrigatório',
            'curso.integer'          =>'O curso tem que ser um valor númerico',
            'curso.min'              =>'Selecione o curso',
            'professor.required'     =>'O professor é obrigatório',
            'professor.integer'      =>'O professor tem que ser um valor númerico',
            'professor.min'          =>'Selecione o professor',
            'turma.required'         =>'A turma é obrigatória',
            'turma.integer'          =>'A turma tem que ser um valor númerico',
            'turma.min'              =>'Selecione a turma',
            'disciplina.required'    =>'A disciplina é obrigatória',
            'disciplina.integer'     =>'A disciplina tem que ser um valor númerico',
            'disciplina.min'         =>'Selecione a disciplina',
            'qtd.required'           =>'A quantidade de falta é obrigatória',
            'qtd.integer'            =>'A quantidade de falta tem que ser um valor númerico',
            'qtd.min'                =>'Selecione a quantidade de faltas',
            'dia.required'           =>'Informe o dia que a falta ocorreu',
            'dia.date'               =>'O dia da falta tem que ser uma data válida'
        ];
    }
}