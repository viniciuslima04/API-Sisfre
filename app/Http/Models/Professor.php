<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Professor extends Model{
    
    protected $table = 'professor';

    protected $fillable = [ 'curso_id', 'usuario_id', 'updated_at','created_at' ];

    protected $guarded = [ 'id' ];

    public function usuario(){
        return $this->belongsTo(Usuario::class);
    }

    public function curso(){
        return $this->belongsTo(Curso::class);
    }

    public function faltas(){
        return $this->hasMany(Falta::class);
    }

    public function disciplinas(){
        return $this->belongsToMany(Disciplina::class)->withTimestamps();
    }

    public function anteposicoes(){
        return $this->hasMany(Anteposicao::class)->withTimestamps();
    }
}