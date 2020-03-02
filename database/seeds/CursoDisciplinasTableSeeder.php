<?php

use Illuminate\Database\Seeder;
use App\Http\Models\CursoDisciplina;

class CursoDisciplinasTableSeeder extends Seeder
{

    public function run()
    {
         CursoDisciplina::create([
            'disciplina_id' => 	1,
            'curso_id' 		=> 	1,
            'periodo'       =>  1,
            'carga_horaria' =>  80,
            'aula_semanal'  =>  4
        ]);

         CursoDisciplina::create([
            'disciplina_id' => 	2,
            'curso_id'      =>  1,
            'periodo'       =>  1,
            'carga_horaria' =>  80,
            'aula_semanal'  =>  4
        ]);

         CursoDisciplina::create([
            'disciplina_id' => 	3,
            'curso_id'      =>  1,
            'periodo'       =>  1,
            'carga_horaria' =>  40,
            'aula_semanal'  =>  2
        ]);

         CursoDisciplina::create([
            'disciplina_id' => 	4,
            'curso_id'      =>  1,
            'periodo'       =>  1,
            'carga_horaria' =>  40,
            'aula_semanal'  =>  2
        ]);

         CursoDisciplina::create([
            'disciplina_id' => 	5,
            'curso_id'      =>  1,
            'periodo'       =>  1,
            'carga_horaria' =>  80,
            'aula_semanal'  =>  4
        ]);

         CursoDisciplina::create([
            'disciplina_id' => 	6,
            'curso_id'      =>  1,
            'periodo'       =>  1,
            'carga_horaria' =>  80,
            'aula_semanal'  =>  4
        ]);

         CursoDisciplina::create([
            'disciplina_id' => 	7,
            'curso_id'      =>  1,
            'periodo'       =>  2,
            'carga_horaria' =>  80,
            'aula_semanal'  =>  4
        ]);

         CursoDisciplina::create([
            'disciplina_id' => 	8,
            'curso_id'      =>  1,
            'periodo'       =>  2,
            'carga_horaria' =>  40,
            'aula_semanal'  =>  2
        ]);

         CursoDisciplina::create([
            'disciplina_id' => 	9,
            'curso_id'      =>  1,
            'periodo'       =>  2,
            'carga_horaria' =>  12,
            'aula_semanal'  =>  6
        ]);

         CursoDisciplina::create([
            'disciplina_id' => 	10,
            'curso_id'      =>  1,
            'periodo'       =>  2,
            'carga_horaria' =>  80,
            'aula_semanal'  =>  4
        ]);

         CursoDisciplina::create([
            'disciplina_id' => 	11,
            'curso_id'      =>  1,
            'periodo'       =>  2,
            'carga_horaria' =>  80,
            'aula_semanal'  =>  4
        ]);
    }
}
