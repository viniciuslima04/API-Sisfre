<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

use App\Http\Models\Falta;
use App\Http\Models\Anteposicao;
use App\Http\Models\Reposicao;
use App\Http\Models\Semestre;

class GraficoController extends Controller{

    public function __construct(){
    	$this->middleware('coord');
    }

    public function index(){
        $anos = RelatorioController::anos();
    	return view('grafico.index',compact('anos'));
    }

	public function faltas(Request $req){
        $semestre   		= Semestre::find($req->input('semestre'));
        $curso      		= auth()->user()->professor->curso->id;
        $download 			= false;
        $semestreFormatado  = $semestre->ano.'.'.$semestre->etapa.' - '.$semestre->tipo;
        $where =    [ 
                        ['turma.curso_id','=',$curso],
                        ['semestre.id','=',$semestre->id],
                        ['falta.situacao','!=','ESP'],
                        ['falta.situacao','!=','NEG'],
                    ];

		$faltas 			= $this->busca_faltas_graphics($where);
		
		if($faltas->isEmpty()){
            return redirect()->route('grafico.index')
            ->withInput()
            ->with('error','Não existe dados para a elaboração dos gráficos do semestre: '.$semestreFormatado);
		}
		
		$faltas 			= $faltas->sortBy('professor');
        $faltasGerais 		= $this->faltas_curso($faltas);
        $faltasIndividuais 	=  $this->faltas_individuais($faltas);

        if($req->has('download')){
            $download = true;
        }

        return View('grafico.create-falta',compact('faltasGerais', 'faltasIndividuais', 'semestre', 'download'));
	}

	public function faltas_curso($faltas){
		$falta = array();

		if($faltas->isNotEmpty()){

			$falta['total'] = $faltas->sum('qtd');
			$falta['pagas'] = $faltas->where('situacao','=','PAGA_T')->sum('qtd') + $faltas->where('situacao','=','PAGA_P')->sum('qtd') + $this->verifica_vencidas($faltas->where('situacao','=','VENC'));
			$falta['nopagas'] = $falta['total'] - $falta['pagas'];
		}

		return $falta;
	}

	public function faltas_individuais($faltas){
		$falta = array();

		if($faltas->isNotEmpty()){
			foreach ($faltas->groupBy('professor') as $professor => $faltas) {
				$falta[$professor]['total'] = $faltas->sum('qtd');
				$falta[$professor]['pagas'] = $faltas->where('situacao','=','PAGA_T')->sum('qtd') + $faltas->where('situacao','=','PAGA_P')->sum('qtd') + $this->verifica_vencidas($faltas->where('situacao','=','VENC'));
				$falta[$professor]['nopagas'] = $falta[$professor]['total'] - $falta[$professor]['pagas'];
			}
		}
		return $falta;
	}

	public function busca_faltas_graphics($where){
        return Falta::with('reposicoes','anteposicoes')
        ->join('funcionario', 'funcionario.id', '=', 'falta.funcionario_id')
        ->join('usuario', 'usuario.id', '=', 'funcionario.usuario_id')
        ->join('disciplina', 'disciplina.id', '=', 'falta.disciplina_id')
        ->join('professor', 'professor.id', '=', 'falta.professor_id')
        ->join('turma', 'turma.id', '=', 'falta.turma_id')
        ->join('semestre', 'semestre.id', '=', 'turma.semestre_id')
        ->join('usuario AS u', 'u.id', '=', 'professor.usuario_id')
        ->select('usuario.username AS funcionario', 'falta.*', 'disciplina.nome AS disciplina','turma.descricao AS turma','u.username AS professor')
        ->where($where)
        ->orderBy('falta.dia','DESC')
        ->get();
	}

	public function verifica_vencidas($faltas){
		$soma = 0;

		foreach ($faltas as $falta) {
			$anteposicao = $falta->anteposicoes;
			$reposicao 	 = $falta->reposicoes;

			if($anteposicao->isNotEmpty() || $reposicao->isNotEmpty() ){
				$soma = $soma + 1;
			}
			else{
				$soma = $soma + 2;	
			}
		}

		return $soma;
	}
}