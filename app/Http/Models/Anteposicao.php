<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Anteposicao extends Model{
    
    protected $table = 'anteposicao';

    protected $fillable = [ 
         'dia', 'qtd', 'disciplina_id', 'turma_id','professor_id','situacao','obs','gasta'
     ];

    protected $guarded = [ 'id' ];

    public function professor(){
        return $this->belongsTo(Professor::class);
    }   

    public function disciplina(){
        return $this->belongsTo(Disciplina::class);
    }   

    public function turma(){
        return $this->belongsTo(Turma::class);
    }

    public function faltas(){
        return $this->belongsToMany(Falta::class)->withTimestamps();
    }
}