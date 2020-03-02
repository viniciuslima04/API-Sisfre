<?php

use Illuminate\Database\Seeder;
use App\Http\Models\Feriado;

class FeriadosTableSeeder extends Seeder
{

    public function run()
    {
        Feriado::create([
            'nome'          => 'FÉRIAS',
            'data'          => "2018-07-02",
            'final'         => "2018-07-24",
            'tipo'          => 2
        ]);

        Feriado::create([
            'nome'          => 'CORPUS CHRISTI',
            'data'          => "2018-05-31",
            'tipo'          => 1
        ]);

        Feriado::create([
            'nome'          => 'PADROEIRO DO CEDRO',
            'data'          => "2018-06-24",
            'tipo'          => 1
        ]);

        Feriado::create([
            'nome'          => 'INDEPENDÊNCIA DO BRASIL',
            'data'          => "2018-09-07",
            'tipo'          => 1
        ]);

        Feriado::create([
            'nome'          => 'PADROEIRA DO BRASIL',
            'data'          => "2018-10-12",
            'tipo'          => 1
        ]);

        Feriado::create([
            'nome'          => 'DIA DE FINADOS',
            'data'          => "2018-11-02",
            'tipo'          => 1
        ]);
    }
}