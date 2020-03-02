<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model{

    protected $table = 'funcionario';

    protected $fillable = [ 'usuario_id', 'updated_at','created_at' ];

 	protected $guarded = [ 'id' ];

    public function usuario(){
    	return $this->belongsTo(Usuario::class);
    }

    public function faltas(){
   		return $this->hasMany(Falta::class);
    }
}
