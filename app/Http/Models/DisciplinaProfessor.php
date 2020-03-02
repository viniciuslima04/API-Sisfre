<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class DisciplinaProfessor extends Model{
	
    protected $table = 'disciplina_professor';

    protected $fillable = [ 'disciplina_id', 'professor_id','turma_id', 'updated_at','created_at' ];

 	protected $guarded = [ 'id' ];
}
