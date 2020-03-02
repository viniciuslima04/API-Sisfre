<?php

use Illuminate\Database\Seeder;
use App\Http\Models\Professor;

class ProfessoresTableSeeder extends Seeder
{

    public function run()
    {
         Professor::create([
            'usuario_id' => 2,
            'curso_id' => 1
        ]);

         Professor::create([
            'usuario_id' => 3
        ]);

         Professor::create([
            'usuario_id' => 4
        ]);

         Professor::create([
            'usuario_id' => 5
        ]);

    }
}
