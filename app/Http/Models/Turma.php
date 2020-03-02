<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Turma extends Model{
    
    protected $table = 'turma';

    protected $fillable = [ 
         'descricao', 'periodo', 'turno', 'semestre_id', 'curso_id',
     ];

    protected $guarded = [ 'id' ];

    public function semestre(){
        return $this->belongsTo(Semestre::class);
    }

    public function curso(){
        return $this->belongsTo(Curso::class);
    }

    public function aulas(){
        return $this->hasMany(Aula::class);
    }

    public function optativas(){
        return $this->hasMany(Optativa::class);
    }

    public function faltas(){
        return $this->hasMany(Falta::class);
    }

    public function anteposicoes(){
        return $this->hasMany(Anteposicao::class)->withTimestamps();
    }
}