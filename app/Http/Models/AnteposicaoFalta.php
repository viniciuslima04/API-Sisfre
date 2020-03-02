<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class AnteposicaoFalta extends Model{
	
    protected $table = 'anteposicao_falta';

    protected $fillable = [ 'falta_id', 'anteposicao_id', 'updated_at','created_at' ];

 	protected $guarded = [ 'id' ];
}
