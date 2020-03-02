<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Disciplina extends Model{
    
    protected $table = 'disciplina';

    protected $fillable = [ 'nome', 'sigla', 'updated_at','created_at' ];

    protected $guarded = [ 'id' ];

    public function professores(){
        return $this->belongsToMany(Professor::class)->withTimestamps();
    }

    public function cursos(){
        return $this->belongsToMany(Curso::class)->withPivot(['periodo','aula_semanal','carga_horaria', 'optativa'])->withTimestamps();
    }

    public function faltas(){
        return $this->hasMany(Falta::class);
    }

    public function aulas(){
        return $this->hasMany(Aula::class);
    }

    public function anteposicoes(){
        return $this->hasMany(Anteposicao::class)->withTimestamps();
    }

    public function optativas(){
        return $this->hasMany(Optativa::class);
    }
}