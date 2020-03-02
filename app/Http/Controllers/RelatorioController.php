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

class RelatorioController extends Controller
{
    private $falta;
    private $reposicao;
    private $anteposicao;
    private $semestre;

    public function __construct(Falta $falta, Reposicao $reposicao, Anteposicao $anteposicao, Semestre $semestre){

        $this->middleware('coord', ['except' => ['indexFuncionario', 'professores', 'getAulas']]); 
        $this->middleware('func',  ['only'   => ['indexFuncionario', 'professores', 'getAulas']]);

        $this->falta        = $falta;
        $this->reposicao    = $reposicao;
        $this->anteposicao  = $anteposicao;
        $this->semestre     = $semestre;
    }

    public function index(){
        $anos = self::anos();
        return view('relatorio.index',compact('anos'));
    }

    public function faltas(Request $req){
        $semestre   = Semestre::find($req->input('semestre'));
        $semestreFormatado  = $semestre->ano.'.'.$semestre->etapa.' - '.$semestre->tipo;
        $curso      = auth()->user()->professor->curso->id;

        $where =    [ 
                        ['turma.curso_id','=',$curso],
                        ['semestre.id','=',$semestre->id]
                    ];

        if($req->has('professor')){
            $professor = Professor::find($req->get('professor')); 
            $where[]   = ['professor.id','=', $req->get('professor')];
        }  
              
        $faltas = Falta::with('reposicoes','anteposicoes')
                ->join('funcionario', 'funcionario.id', '=', 'falta.funcionario_id')
                ->join('usuario', 'usuario.id', '=', 'funcionario.usuario_id')
                ->join('disciplina', 'disciplina.id', '=', 'falta.disciplina_id')
                ->join('professor', 'professor.id', '=', 'falta.professor_id')
                ->join('turma', 'turma.id', '=', 'falta.turma_id')
                ->join('semestre', 'semestre.id', '=', 'turma.semestre_id')
                ->join('usuario AS u', 'u.id', '=', 'professor.usuario_id')
                ->select('usuario.username AS funcionario', 'falta.*', 'disciplina.nome AS disciplina','turma.descricao AS turma','u.username AS professor')
                ->where($where)
                ->orderBy('turma.descricao','ASC')
                ->orderBy('falta.dia','ASC')
                ->orderBy('u.username','ASC')
                ->orderBy('disciplina.nome','ASC')
                ->get();

        if($faltas->isEmpty()){
            if($req->has('professor')){
                return redirect()->route('relatorio.index')
                ->withInput()
                ->with('error','Não existe dados para a elaboração do relatório do professor: '.$professor->usuario->username.' no semestre: '.$semestreFormatado);    
            }
            return redirect()->route('relatorio.index')
            ->withInput()
            ->with('error','Não existe dados para a elaboração do relatório do semestre: '.$semestreFormatado);
        }

        $hoje = Carbon::now('America/Fortaleza');

        $arquivo = PDF::loadView('relatorio.create-falta',compact('faltas','semestre'))->setPaper('a4')->setOrientation('landscape')->setOption('footer-right','Pagina [page] de [toPage]')->setOption('footer-left' ,'Documento gerado pelo sistema SISFRE. Em '.$hoje->format('d/m/Y').' as '.$hoje->format('H:i:s'))->setOption('footer-font-size', 8);

        if($req->has('download')){
            return $arquivo->download('relatorio-faltas-'.auth()->user()->professor->curso->nome.'.pdf');
        }
        return $arquivo->stream();
    }

    public function anteposicoes(Request $req){
        $semestre   = Semestre::find($req->input('semestre'));
        $semestreFormatado  = $semestre->ano.'.'.$semestre->etapa.' - '.$semestre->tipo;
        $curso      = auth()->user()->professor->curso->id;

        $where =    [ 
                        ['turma.curso_id','=',$curso],
                        ['semestre.id','=',$semestre->id]
                    ];

        if($req->has('professor')){
            $professor = Professor::find($req->get('professor'));
            $where[]   = ['professor.id','=', $req->get('professor')];
        }   

        $anteposicoes = DB::table('anteposicao')
                ->join('anteposicao_falta','anteposicao.id','=', 'anteposicao_falta.anteposicao_id')
                ->join('falta', 'falta.id', '=', 'anteposicao_falta.falta_id')
                ->join('funcionario', 'funcionario.id', '=', 'falta.funcionario_id')
                ->join('usuario', 'usuario.id', '=', 'funcionario.usuario_id')
                ->join('disciplina', 'disciplina.id', '=', 'falta.disciplina_id')
                ->join('professor', 'professor.id', '=', 'falta.professor_id')
                ->join('turma', 'turma.id', '=', 'falta.turma_id')
                ->join('semestre', 'semestre.id', '=', 'turma.semestre_id')
                ->join('usuario AS u', 'u.id', '=', 'professor.usuario_id')
                ->select('usuario.username AS funcionario', 'falta.*', 'disciplina.nome AS disciplina','turma.descricao AS turma','u.username AS professor', 'anteposicao.situacao AS situacaoAnt')
                ->where($where)
                ->orderBy('turma.descricao','ASC')
                ->orderBy('falta.dia','ASC')
                ->orderBy('u.username','ASC')
                ->orderBy('disciplina.nome','ASC')
                ->get();

        if($anteposicoes->isEmpty()){
            if($req->has('professor')){
                return redirect()->route('relatorio.index')
                ->withInput()
                ->with('error','Não existe dados para a elaboração do relatório do professor: '.$professor->usuario->username.' no semestre: '.$semestreFormatado);    
            }
            return redirect()->route('relatorio.index')
            ->withInput()
            ->with('error','Não existe dados para a elaboração do relatório do semestre: '.$semestreFormatado);
        }

        $hoje = Carbon::now('America/Fortaleza');

        $arquivo = PDF::loadView('relatorio.create-anteposicao',compact('anteposicoes','semestre'))->setPaper('a4')->setOrientation('landscape')->setOption('footer-right','Pagina [page] de [toPage]')->setOption('footer-left' ,'Documento gerado pelo sistema SISFRE. Em '.$hoje->format('d/m/Y').' as '.$hoje->format('H:i:s'))->setOption('footer-font-size', 8);

        if($req->has('download')){
            return $arquivo->download('relatorio-anteposicoes-'.auth()->user()->professor->curso->nome.'.pdf');
        }
        return $arquivo->stream();
    }

    public function reposicoes(Request $req){
        $semestre   = Semestre::find($req->input('semestre'));
        $semestreFormatado  = $semestre->ano.'.'.$semestre->etapa.' - '.$semestre->tipo;
        $curso      = auth()->user()->professor->curso->id;

        $where =    [ 
                        ['turma.curso_id','=',$curso],
                        ['semestre.id','=',$semestre->id]
                    ];

        if($req->has('professor')){
            $professor = Professor::find($req->get('professor'));
            $where[]   = ['professor.id','=', $req->get('professor')];
        }    

        $reposicoes = DB::table('reposicao')
                ->join('falta', 'falta.id', '=', 'reposicao.falta_id')
                ->join('funcionario', 'funcionario.id', '=', 'falta.funcionario_id')
                ->join('usuario', 'usuario.id', '=', 'funcionario.usuario_id')
                ->join('disciplina', 'disciplina.id', '=', 'falta.disciplina_id')
                ->join('professor', 'professor.id', '=', 'falta.professor_id')
                ->join('turma', 'turma.id', '=', 'falta.turma_id')
                ->join('semestre', 'semestre.id', '=', 'turma.semestre_id')
                ->join('usuario AS u', 'u.id', '=', 'professor.usuario_id')
                ->select('usuario.username AS funcionario', 'falta.*', 'disciplina.nome AS disciplina','turma.descricao AS turma','u.username AS professor', 'reposicao.situacao AS situacaoRep')
                ->where($where)
                ->orderBy('turma.descricao','ASC')
                ->orderBy('falta.dia','ASC')
                ->orderBy('u.username','ASC')
                ->orderBy('disciplina.nome','ASC')
                ->get();

        if($reposicoes->isEmpty()){
            if($req->has('professor')){
                return redirect()->route('relatorio.index')
                ->withInput()
                ->with('error','Não existe dados para a elaboração do relatório do professor: '.$professor->usuario->username.' no semestre: '.$semestreFormatado);    
            }
            return redirect()->route('relatorio.index')
            ->withInput()
            ->with('error','Não existe dados para a elaboração do relatório do semestre: '.$semestreFormatado);
        }

        $hoje = Carbon::now('America/Fortaleza');

        $arquivo = PDF::loadView('relatorio.create-reposicao',compact('reposicoes','semestre'))->setPaper('a4')->setOrientation('landscape')->setOption('footer-right','Pagina [page] de [toPage]')->setOption('footer-left' ,'Documento gerado pelo sistema SISFRE. Em '.$hoje->format('d/m/Y').' as '.$hoje->format('H:i:s'))->setOption('footer-font-size', 8);
        
        if($req->has('download')){
            return $arquivo->download('relatorio-reposicoes-'.auth()->user()->professor->curso->nome.'.pdf');
        }
        return $arquivo->stream();
    }

    public static function anos(){
        return DB::table('semestre')
            ->select('semestre.ano')
            ->distinct()
            ->orderBy('semestre.ano','DESC')
            ->get();
    }



    public function indexFuncionario(){

        return view('relatorio.funcionarioIndex');
    }

    public function professores(Request $req){
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
            return redirect()->route('relatorio.index.funcionario')
            ->withInput()
            ->with('error','Não existe dados para a elaboração do relatório dos professores nesse dia e turno');
        }

        $hoje = Carbon::now('America/Fortaleza');

        $arquivo = PDF::loadView('relatorio.funcionarioRelatorio',compact('aulas','turno','dia','hoje'))->setPaper('a4')->setOrientation('portrait')->setOption('footer-right','Pagina [page] de [toPage]')->setOption('footer-left' ,'Documento gerado pelo sistema SISFRE. Em '.$hoje->format('d/m/Y').' as '.$hoje->format('H:i:s'))->setOption('footer-font-size', 8);
        
        if($req->has('download')){
            return $arquivo->download('relatorio-professores-'.auth()->user()->username.'.pdf');
        }
        return $arquivo->stream();
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