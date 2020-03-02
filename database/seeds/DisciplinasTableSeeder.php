<?php

use Illuminate\Database\Seeder;
use App\Http\Models\Disciplina;

class DisciplinasTableSeeder extends Seeder
{
    public function run()
    {
        // S1 DE SISTEMAS DE INFORMAÇÃO
        Disciplina::create([
            'nome' 			=> 	'CÁLCULO I',
            'sigla'         =>  'CALCI'
        ]);

        Disciplina::create([
            'nome' 			=> 	'FUNDAMENTOS DE SISTEMAS DE INFORMAÇÃO',
            'sigla'         =>  'FSIN'
        ]);

        Disciplina::create([
            'nome' 			=> 	'INGLÊS INSTRUMENTAL',
            'sigla'         =>  'INGI'
        ]);

        Disciplina::create([
            'nome' 			=> 	'LÓGICA MATEMÁTICA',
            'sigla'         =>  'LOGM'
        ]);

        Disciplina::create([
            'nome' 			=> 	'PROBABILIDADE E ESTATÍSTICA',
            'sigla'         =>  'PRES'
        ]);

        Disciplina::create([
            'nome' 			=> 	'TECNOLOGIAS WEB',
            'sigla'         =>  'TWEB'
        ]);

        // S2 DE SISTEMAS DE INFORMAÇÃO

        Disciplina::create([
            'nome' 			=> 	'ARQUITETURA DE COMPUTADORES',
            'sigla'         =>  'ARQC'
        ]);

        Disciplina::create([
            'nome' 			=> 	'INTRODUÇÃO À ADMINISTRAÇÃO',
            'sigla'         =>  'INTA'
        ]);

        Disciplina::create([
            'nome' 			=> 	'LÓGICA E LINGUAGEM DE PROGRAMAÇÃO',
            'sigla'         =>  'LLPR'
        ]);

        Disciplina::create([
            'nome' 			=> 	'METODOLOGIA DO TRABALHO CIENTIFÍCO',
            'sigla'         =>  'MTC'
        ]);

        Disciplina::create([
            'nome' 			=> 	'REDES DE COMPUTADORES I',
            'sigla'         =>  'REDC1'
        ]);

        // S3 DE SISTEMAS DE INFORMAÇÃO
    }
}
