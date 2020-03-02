<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Administrador extends Model{
	
    protected $table = 'administrador';

    protected $fillable = [ 'usuario_id', 'updated_at','created_at' ];

 	protected $guarded = [ 'id' ];


    public function usuario(){
    	return $this->belongsTo(Usuario::class);
    }
}