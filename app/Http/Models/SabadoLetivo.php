<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class SabadoLetivo extends Model{
	
    protected $table = 'sabado_letivo';

    protected $fillable = [ 
	     'data','referente'
     ];

 	protected $guarded = [ 'id' ];

}