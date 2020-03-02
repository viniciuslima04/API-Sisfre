<?php

use Illuminate\Database\Seeder;
use App\Http\Models\Funcionario;

class FuncionariosTableSeeder extends Seeder
{

    public function run()
    {
          Funcionario::create([
            'usuario_id' => 6
        ]);
    }
}
