<?php

use Illuminate\Database\Seeder;
use App\Http\Models\Curso;

class CursosTableSeeder extends Seeder
{

    public function run()
    {
          Curso::create([
            'nome' => 'BACHARELADO EM SISTEMAS DE INFORMAÇÃO',
            'sigla' => 'SI',
            'tipo' => 'GRADUAÇÃO',
            'duracao' => 8
        ]);

          Curso::create([
            'nome' => 'LICENCIATURA EM MATEMÁTICA',
            'sigla' => 'MAT',
            'tipo' => 'GRADUAÇÃO',
            'duracao' => 8
        ]);

          Curso::create([
            'nome' => 'LICENCIATURA EM FÍSICA',
            'sigla' => 'FIS',
            'tipo' => 'GRADUAÇÃO',
            'duracao' => 8
        ]);

          Curso::create([
            'nome' => 'MECATRÔNICA INDUSTRIAL',
            'sigla' => 'MIN',
            'tipo' => 'GRADUAÇÃO',
            'duracao' => 7
        ]);

          Curso::create([
            'nome' => 'TÉCNICO MECÂNICA',
            'sigla' => 'TME',
            'tipo' => 'TÉCNICO',
            'duracao' => 4
        ]);

          Curso::create([
            'nome' => 'TÉCNICO ELETROTÉCNICA',
            'sigla' => 'TEL',
            'tipo' => 'TÉCNICO',
            'duracao' => 4
        ]);

          Curso::create([
            'nome' => 'INTEGRADO EM MECÂNICA',
            'sigla' => 'IME',
            'tipo' => 'INTEGRADO',
            'duracao' => 6

        ]);

          Curso::create([
            'nome' => 'INTEGRADO EM INFORMÁTICA',
            'sigla' => 'INF',
            'tipo' => 'INTEGRADO',
            'duracao' => 6
        ]);

          Curso::create([
            'nome' => 'INTEGRADO EM ELETROTÉCNICA',
            'sigla' => 'ELE',
            'tipo' => 'INTEGRADO',
            'duracao' => 6
        ]);
    }
}
