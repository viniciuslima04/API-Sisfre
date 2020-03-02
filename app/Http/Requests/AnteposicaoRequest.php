<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnteposicaoRequest extends FormRequest
{
    public function authorize(){
        return true;
    }

    public function rules()
    {

        return [
            'arquivo'                    => 'required|file|mimes:pdf|max:2048',
            'qtd'                        => 'required|integer|min:1',
            'dia'                        => 'required|date',
            'turma'                      => 'required|integer|min:1',
            'disciplina'                 => 'required|integer|min:1'
        ];
    }

        public function messages()
    {
        return [
            'arquivo.required'       =>'A folha de reposição é obrigatória',
            'arquivo.max'            =>'O tamanho máximo do arquivo deve ser 2MB',
            'arquivo.mimes'          =>'O Arquivo deve está no formato .PDF',
            'qtd.required'           =>'A quantidade de falta é obrigatória',
            'qtd.integer'            =>'A quantidade de falta tem que ser um valor númerico',
            'qtd.min'                =>'Selecione a quantidade de faltas',
            'dia.required'           =>'Informe o dia que a reposição ocorreu',
            'dia.date'               =>'O dia da falta tem que ser uma data válida',
            'turma.required'         =>'Selecione a turma',
            'turma.integer'          =>'A turma tem que ser um valor númerico',
            'turma.min'              =>'Selecione a turma',
            'disciplina.required'    =>'Selecione a disciplina',
            'disciplina.integer'     =>'A disciplina tem que ser um valor númerico',
            'disciplina.min'         =>'Selecione a disciplina'
        ];
    }
}