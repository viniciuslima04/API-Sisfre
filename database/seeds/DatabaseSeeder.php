<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        $this->call(UsuariosTableSeeder::class);
        $this->call(CursosTableSeeder::class);
        $this->call(AdministradoresTableSeeder::class);
        $this->call(SemestresTableSeeder::class);
        $this->call(SabadosTableSeeder::class);
        $this->call(FeriadosTableSeeder::class);
    }
}
