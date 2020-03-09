<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use PDF;

use Illuminate\Support\Carbon;
use App\Http\Models\Falta;
use App\Http\Models\Anteposicao;
use App\Http\Models\Reposicao;
use App\Http\Models\Semestre;
use App\Http\Models\Professor;

class ApiRelatorioController extends Controller{
  
    public function professoresApi(Request $req){

        $dia        = $req->input('dia');
        $turno      = $req->input('turno');

        $between    = $this->getAulas($turno);

        $aulas = DB::select('select distinct(d.id), d.nome as disciplina,
            c.nome as curso, t.descricao as turma, p.id as professor_id, u.username as professor_nome  
            FROM aula a
            INNER JOIN disciplina d ON d.id = a.disciplina_id
            INNER JOIN turma t ON t.id = a.turma_id
            INNER JOIN semestre s ON s.id = t.semestre_id
            INNER JOIN curso c ON c.id = t.curso_id
            INNER JOIN disciplina_professor dp ON dp.disciplina_id = d.id
            INNER JOIN professor p ON p.id = dp.professor_id
            INNER JOIN usuario u ON u.id = p.usuario_id 
            WHERE t.id = dp.turma_id and a.dia = :dia and 
            a.posicao BETWEEN :min and :max and s.status = 1 ORDER BY u.username, d.nome ASC', 
            ['dia' => $dia, 'min' => $between[0], 'max' => $between[1]]);

        $aulas = collect($aulas);

        if($aulas->isEmpty()){
            return response()->json(['error','Não existe dados para a elaboração do relatório dos professores nesse dia e turno']);
        }

        return response()->json($aulas, 200);
    }

    public function getAulas($turno){
        if($turno == 'M'){
            return [1, 4];
        }
        else if($turno == 'T'){
            return [5, 8]; 
        }
        else if($turno == 'N'){
            return [9, 12]; 
        }
    }
}