<?php

use Illuminate\Database\Seeder;
use App\Http\Models\Semestre;

class SemestresTableSeeder extends Seeder
{

    public function run()
    {
        Semestre::create([
            'ano' 		=> 2018,
            'etapa' 	=> 1,
            'status' 	=> 1,
            'inicio'	=> "2018-05-21",
            'metade'	=> "2018-08-23",
            'fim'		=> "2018-11-07",
            'tipo'      => "CONVENCIONAL"
        ]);

        Semestre::create([
            'ano'       => 2018,
            'etapa'     => 2,
            'status'    => 1,
            'inicio'    => "2018-07-25",
            'metade'    => "2018-10-04",
            'fim'       => "2018-12-18",
            'tipo'      => "REGULAR"
        ]);
    }
}
