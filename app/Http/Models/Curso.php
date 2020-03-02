<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model{
  
    protected $table = 'curso';

    protected $fillable = [ 
       'nome', 'sigla', 'tipo','duracao'
     ];

  protected $guarded = [ 'id' ];


    public function coordenador(){
      return $this->hasOne(Professor::class);
    }

    public function turmas(){
      return $this->hasMany(Turma::class);
    }

    public function disciplinas(){
        return $this->belongsToMany(Disciplina::class)->withPivot(['periodo','aula_semanal','carga_horaria', 'optativa'])->withTimestamps();
    }

    public function optativas(){
        return $this->hasMany(Optativa::class);
    }
    
}