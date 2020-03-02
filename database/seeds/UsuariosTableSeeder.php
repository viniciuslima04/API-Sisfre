<?php

use Illuminate\Database\Seeder;
use App\Http\Models\Usuario;

class UsuariosTableSeeder extends Seeder
{

    public function run()
    {
        Usuario::create([
            'password' => bcrypt('ADMIN'),
            'email' => 'admin@gmail.com',
            'acesso' => '4',
            'username' => 'ADMIN',
            'abreviatura' => 'AD'
        ]);
    }
}
