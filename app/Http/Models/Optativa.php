<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Optativa extends Model
{
    protected $table = 'optativa';

    protected $fillable = [ 
       'curso_id', 'disciplina_id', 'turma_id'
     ];

  	protected $guarded = [ 'id' ];

    public function turma(){
      return $this->belongsTo(Turma::class);
    }

    public function curso(){
      return $this->belongsTo(Curso::class);
    }

    public function disciplina(){
      return $this->belongsTo(Disciplina::class);
    }

}
