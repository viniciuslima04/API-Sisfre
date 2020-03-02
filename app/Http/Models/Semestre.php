<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Semestre extends Model{
  
  protected $table = 'semestre';

  protected $fillable = [ 
     'ano', 'etapa', 'inicio', 'metade', 'fim', 'status'
   ];

  protected $guarded = [ 'id' ];

  public function turmas(){
    return $this->hasMany(Turma::class);
  }

  public function sabados_letivo(){
    return $this->hasMany(SabadoLetivo::class);
  }

  public function feriados(){
    return $this->hasMany(Feriado::class);
  }
}
