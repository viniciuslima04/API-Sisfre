<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Aula extends Model{
    
    protected $table = 'aula';

    protected $fillable = [ 
         'dia', 'inicio', 'disciplina_id', 'turma_id'
     ];

    protected $guarded = [ 'id' ];

    public function disciplina(){
        return $this->belongsTo(Disciplina::class);
    }

    public function turma(){
        return $this->belongsTo(Turma::class);
    }
}