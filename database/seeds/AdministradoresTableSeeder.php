<?php

use Illuminate\Database\Seeder;
use App\Http\Models\Administrador;

class AdministradoresTableSeeder extends Seeder
{

    public function run()
    {
          Administrador::create([
            'usuario_id' => 1
        ]);
    }
}
