<?php

namespace App\Http\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\meuResetDeSenha;

class Usuario extends Authenticatable{
    
    use Notifiable;

    protected $table = 'usuario';

    protected $fillable = [
        'email', 'password','acesso','username','abreviatura'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $guarded = [ 'id' ];
    
    public function professor(){
        return $this->hasOne(Professor::class);
    }

    public function funcionario(){
        return $this->hasOne(Funcionario::class);
    }

    public function administrador(){
        return $this->hasOne(Administrador::class);
    }

    public function sendPasswordResetNotification($token){
        $this->notify(new meuResetDeSenha($token));
    }
}