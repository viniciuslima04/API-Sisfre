<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Feriado extends Model{
	
    protected $table = 'feriado';

    protected $fillable = [ 
	     'data', 'tipo', 'nome','final'
     ];

 	protected $guarded = [ 'id' ];
}
