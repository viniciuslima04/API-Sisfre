<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UsuarioRequest;
use App\Http\Requests\SemestreRequest;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Http\Models\Usuario;
use App\Http\Models\Professor;
use App\Http\Models\Funcionario;
use App\Http\Models\Administrador;
use App\Http\Models\Disciplina;
use App\Http\Models\Curso;
use App\Http\Models\Semestre;
use App\Http\Models\Turma;

class AjaxController extends Controller
{
    private $user;
    private $disciplina;
    private $curso;
    private $turma;
    private $semestre;
    private $professor;


    public function __construct(Turma $turma,Usuario $user, Disciplina $disciplina, Curso $curso, Semestre $semestre, Professor $professor){
        $this->middleware('coord', ['only' => ['getDisciplinas', 'getDisciplinasOptativas']]);
        $this->middleware('func', ['only' => ['getTurmas','getProfessores', 'getDisciplinasProfessores']]);
        $this->middleware('admin', ['only' => ['getSemestres', 'associaCurso']]);

        $this->user         = $user;
        $this->disciplina   = $disciplina;
        $this->semestre     = $semestre;
        $this->curso        = $curso;
        $this->turma        = $turma;
        $this->professor    = $professor;

    }


    // ********************* CADASTRAR DISCIPLINA - ADMINISTRADOR *********************


    // RECUPERA A QUANTIDADE DE SEMESTRES DE UM CURSO
    public function getSemestres(Request $req){
        if($req->ajax()){
            $curso = $this->curso->find($req->get('curso_id'));

            $data = view('disciplina.periodo',compact('curso'))->render();
            return response()->json(['options'=>$data]);
        }

    }
    // RECUPERA OS CURSOS CADASTRADOS NO SISTEMA, COM A RESPECTIVA QUANTIDADE
    public function associaCurso(Request $req){
        if($req->ajax()){
            $quantidade = $req->get('quantidade');
            $cursos = $this->curso->orderBy('nome', 'ASC')->get();

            $data = view('disciplina.cursos',compact('cursos', 'quantidade'))->render();
            return response()->json(['options'=>$data]);
        }
    }


    // ********************* MONTAR HORÁRIO - COORDENADOR *********************


    // RECUPERA TODAS AS DISCIPLINAS DE DETERMINADA TURMA
    public function getDisciplinas(Request $req){
        
        if($req->ajax()){
  
            $turma = $this->turma->find($req->get('turma_id'));

            if($turma->aulas->isEmpty()){

                $where  =   [
                                ['curso_disciplina.periodo','=', $turma->periodo],
                                ['curso.id','=',$turma->curso->id],
                                ['curso_disciplina.optativa','=', 2]
                            ];

                $disciplinas = DB::table('disciplina')
                ->join('curso_disciplina', 'disciplina.id', '=', 'curso_disciplina.disciplina_id')
                ->join('curso', 'curso.id', '=', 'curso_disciplina.curso_id')
                ->select('disciplina.*', 'curso_disciplina.aula_semanal')
                ->where($where)
                ->orderBy('disciplina.nome', 'ASC')
                ->get();

                if($turma->optativas->isNotEmpty()){
                    foreach ($turma->optativas as $optativa) {
                        $where2  =   [
                                        ['curso_disciplina.periodo','=', $turma->periodo],
                                        ['curso.id','=',$turma->curso->id],
                                        ['disciplina.id','=',$optativa->disciplina->id]
                                    ];
                        $disciplina = DB::table('disciplina')
                        ->join('curso_disciplina', 'disciplina.id', '=', 'curso_disciplina.disciplina_id')
                        ->join('curso', 'curso.id', '=', 'curso_disciplina.curso_id')
                        ->select('disciplina.*', 'curso_disciplina.aula_semanal')
                        ->where($where2)
                        ->get();

                        $disciplinas = $disciplinas->merge($disciplina);                    
                    }
                }

                $disciplinas = $disciplinas->sortBy('nome');

                $professores = DB::table('usuario')
                ->join('professor', 'usuario.id','=', 'professor.usuario_id')
                ->orderBy('usuario.username')
                ->get();

                $total_aulas = $disciplinas->sum('aula_semanal');

                $data = view('horario.tabelaTurma',compact('disciplinas','professores','turma','total_aulas'))->render();
                return response()->json(['options'=>$data]);
            }
        }

    } 

    // ********************* CADASTRAR FALTA - FUNCIONÁRIO *********************


    // RECUPERA TODAS AS TURMAS DE DETERMINADO CURSO
    public function getTurmas(Request $req){
        if($req->ajax()){
            $curso_id       = $req->get('curso_id');
            $whereSemestre[]  = ['status','=',1];
            $semestreAtivos = SemestreController::busca_semestres($whereSemestre);
            
            if(empty($semestreAtivos)){
                return response()->json(['response' => "Não há semestres ativos!!"],404);
            }
            
            $where =  [['curso.id','=',$curso_id], ['semestre.status','=',1] ];

            $turmas = TurmaController::busca_turmas($where);

            if($turmas->isEmpty()){
                return response()->json(['response' => "Não há turmas para esse curso!!"],404);
            }

            $data = view('falta.selectTurma',compact('turmas'))->render();

            return response()->json(['options'=>$data]);
        }
    }

    // RECUPERA TODOS OS PROFESSORES DE DETERMINADA TURMA
    public function getProfessores(Request $req){

        if($req->ajax()){
            $turma = $this->turma->find($req->get('turma_id'));


            $professores = DB::table('professor')
            ->join('disciplina_professor', 'professor.id', '=', 'disciplina_professor.professor_id')
            ->join('disciplina', 'disciplina.id', '=', 'disciplina_professor.disciplina_id')
            ->join('usuario', 'usuario.id', '=', 'professor.usuario_id')
            ->select('professor.*','usuario.username')
            ->where([
                ['disciplina_professor.turma_id','=',$turma->id]
            ])->distinct()->orderBy('usuario.username', 'ASC')->get();

            $data = view('falta.selectProfessor',compact('professores'))->render();

            return response()->json(['options'=>$data]);
        }
    }

    // RECUPERA TODAS AS DISCIPLINAS DE DETERMINADO PROFESSOR EM DETERMINADA TURMA
    public function getDisciplinasProfessores(Request $req){

        if($req->ajax()){

            $disciplinas = DB::table('disciplina')
            ->join('disciplina_professor', 'disciplina.id', '=', 'disciplina_professor.disciplina_id')
            ->join('professor', 'professor.id', '=', 'disciplina_professor.professor_id')
            ->select('disciplina.*')
            ->where([
                ['disciplina_professor.professor_id','=',$req->get('professor_id')],
                ['disciplina_professor.turma_id','=',$req->get('turma_id')],
            ])->distinct()->orderBy('disciplina.nome', 'ASC')->get();

            $data = view('falta.selectDisciplina',compact('disciplinas'))->render();

            return response()->json(['options'=>$data]);
        }
    }


    // ********************* GERAR RELATÓRIOS/ GRÁFICOS *********************


    // RECUPERA TODOS OS SEMESTRES DO ANO PASSADO COMO PARÂMETRO
    public function getSemestresAno(Request $req){

        if($req->ajax()){

            $semestres = DB::table('semestre')
            ->select('semestre.*')
            ->where('semestre.ano','=',$req->get('ano') )
            ->distinct()
            ->orderBy('semestre.ano', 'DESC', 'semestre.etapa','DESC', 'semestre.tipo', 'ASC')->get();

            $data = view('relatorio.selectSemestre',compact('semestres'))->render();

            return response()->json(['options'=>$data]);
        }
    }


    // RECUPERA TODOS OS PROFESSORES DO SEMESTRE E DO CURSO PASSADO COMO PARÂMETRO
    public function getProfessoresSemestre(Request $req){

        if($req->ajax()){
            $curso          = $req->get('curso');
            $semestre       = $req->get('semestre');
            $where          =   [
                                    ['semestre.id','=',$semestre],
                                    ['curso.id','=', $curso]
                                ];

            $professores    = DB::table('usuario')
            ->join('professor', 'usuario.id', '=', 'professor.usuario_id')
            ->join('disciplina_professor', 'professor.id', '=', 'disciplina_professor.professor_id')
            ->join('disciplina', 'disciplina.id', '=', 'disciplina_professor.disciplina_id')
            ->join('curso_disciplina', 'disciplina.id', '=', 'curso_disciplina.disciplina_id')
            ->join('curso', 'curso.id', '=', 'curso_disciplina.curso_id')
            ->join('turma', 'turma.curso_id', '=', 'curso.id')
            ->join('semestre', 'semestre.id', '=', 'turma.semestre_id')
            ->select('usuario.*', 'professor.id as professor_id')
            ->where($where)
            ->distinct()
            ->orderBy('usuario.username', 'ASC')->get();

            $data = view('relatorio.selectProfessor',compact('professores'))->render();

            return response()->json(['options'=>$data]);
        }
    }

    // ********************* CADASTRAR TURMA - COORDENADOR *********************

    public function getDisciplinasOptativas(Request $req){
        if($req->ajax()){
            $quantidade = $req->get('quantidade');
            $where  =   [
                            ['curso_disciplina.periodo','=', $req->get('periodo')],
                            ['curso.id','=', $req->get('curso_id')],
                            ['curso_disciplina.optativa','=', 1]
                        ];

            $disciplinasOptativas = TurmaController::get_optativas_da_turma($where);

            if($quantidade != 0){
                $data = view('turma.selectOptativa',compact('disciplinasOptativas','quantidade'))->render();

                return response()->json(['options'=>$data]);  
            }

            return response()->json(['options'=>$disciplinasOptativas->count()]);  
        }
    }
}