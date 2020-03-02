<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class CursoDisciplina extends Model{
	
    protected $table = 'curso_disciplina';

    protected $fillable = [ 'disciplina_id', 'curso_id','periodo','carga_horaria', 'aula_semanal','updated_at','created_at' ];

 	protected $guarded = [ 'id' ];
}