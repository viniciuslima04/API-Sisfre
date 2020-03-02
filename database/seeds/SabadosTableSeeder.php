<?php

use Illuminate\Database\Seeder;
use App\Http\Models\SabadoLetivo;

class SabadosTableSeeder extends Seeder
{

    public function run()
    {
         SabadoLetivo::create([
            'referente'     => 'SEXTA',
            'data'          => "2018-08-18"
        ]);

         SabadoLetivo::create([
            'referente'     => 'SEGUNDA',
            'data'          => "2018-10-06"
        ]);
    }
}