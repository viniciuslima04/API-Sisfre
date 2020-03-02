<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Reposicao extends Model{
	
    protected $table = 'reposicao';

    protected $fillable = [ 
	     'dia', 'qtd', 'obs', 'situacao', 'falta_id'
     ];

 	protected $guarded = [ 'id' ];

    public function falta(){
    	return $this->belongsTo(Falta::class);
    }
}