<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Falta extends Model{
    
    protected $table = 'falta';

    protected $fillable = [ 
         'dia', 'qtd', 'validade', 'obs', 'situacao', 'disciplina_id', 'turma_id',
         'funcionario_id', 'professor_id', 'updated_at', 'created_at'
     ];

    protected $guarded = [ 'id' ];

    public function professor(){
        return $this->belongsTo(Professor::class);
    }

    public function funcionario(){
        return $this->belongsTo(Funcionario::class);
    }

    public function disciplina(){
        return $this->belongsTo(Disciplina::class);
    }

    public function turma(){
        return $this->belongsTo(Turma::class);
    }

    public function anteposicoes(){
        return $this->belongsToMany(Anteposicao::class)->withTimestamps();
    }

    public function reposicoes(){
        return $this->hasMany(Reposicao::class);
    }

}