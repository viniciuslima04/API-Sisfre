<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Http\Models\Disciplina;
use App\Http\Models\Professor;
use App\Http\Models\Turma;
use App\Http\Models\Aula;
use App\Http\Models\Semestre;

use Carbon\Carbon;

class AulaController extends Controller
{
    private $disciplina;
    private $professor;
    private $turma;
    private $aula;
    private $curso_id;

    public function __construct(Disciplina $disciplina, Professor $professor, Turma $turma, Aula $aula, Semestre $semestre){
        $this->middleware('prof', ['only' => ['show_professor']]);
        $this->middleware('coord', ['except' => ['show_professor']]); 

        $this->professor    = $professor;
        $this->disciplina   = $disciplina;
        $this->turma        = $turma;
        $this->aula         = $aula;
        $this->semestre     = $semestre;
    }

    public function create($turma){
        $turma = $this->turma->find($turma);

        if(empty($turma)){
            return redirect()->route('turma.show')
            ->withInput()
            ->with('error','Ocorreu um erro ao montar o horário da turma: '.$turma->descricao);
        }

        return view('horario.create', compact('turma'));
    }

    public function store($turma, Request $req){

        $turma_id = $turma;

        if($turma_id >= 1){

            $turma = $this->turma->find($turma_id);


            // CADASTRAR AULAS NO BANCO DE DADOS

            $horarios = $req->input('horario');

            foreach ($horarios as $aulas => $aula) {
               foreach ($aula as $dia => $disciplina) {
                    if($disciplina != 0){
                        $aula = new Aula();
                        $aula->dia = $dia;
                        $aula->posicao = $aulas;
                        $aula->turma_id = $turma_id;
                        $aula->disciplina_id = $disciplina;
                        $inserido[] = $aula->save();
                    }
                }             
            }
            $aulas_inseridas = $this->inserido_removido($inserido, count($inserido));

       
            //ASSOCIAR PROFESSOR A DISCIPLINA

            $professores = $req->input('professor');

            foreach ($professores as $disciplina_id => $professor_id) {

                $disciplina = $this->disciplina->find($disciplina_id);
                $disciplina->professores()->attach($professor_id,['turma_id' => $turma_id]);
            }

            if($aulas_inseridas){
                return redirect()->route('turma.show')
                ->withInput()
                ->with('success','O horário da turma: '.$turma->descricao.' foi montado com sucesso!');
            }
        }
        else{
            return redirect()->route('horario.create')
            ->withInput()
            ->withErrors(['turma'=> 'Selecione uma turma antes de continuar']);    
        }
    }

    public function edit($turma){

        $turma = $this->turma->find($turma);

        if(empty($turma)){
            return redirect()->route('turma.show')
            ->withInput()
            ->with('error','Ocorreu um erro ao editar o horário da turma: '.$turma->descricao);
        }

        $disciplinas = $this->disciplinas_turma($turma);

        if(empty($disciplinas)){
            return redirect()->route('turma.show')
            ->withInput()
            ->with('error','Ocorreu um erro ao editar o horário da turma: '.$turma->descricao);
        }

        $professores = $this->professor->all();

        $total_aulas = $disciplinas->sum('aula_semanal');

        return view('horario.edit', compact('turma','professores','disciplinas', 'total_aulas'));
    }

    public function update($turma, Request $req){

        $turma_id = $turma;

        if($turma_id >= 1){

            $turma = $this->turma->find($turma_id);

            //DESASSOCIA OS PROFESSORES ANTIGOS DAS DISCIPLINAS

            $disciplinas_atuais =  $this->disciplinas_turma($turma);

            foreach ($disciplinas_atuais as $disciplina) {
                $disciplina = $this->disciplina->find($disciplina->id);
                $disciplina->professores()->wherePivot('turma_id','=',$turma->id)->detach();
            }

            $remove_aulas = $this->desassocia_aulas($turma);

            if($remove_aulas == true){
                $horarios = $req->input('horario');

                foreach ($horarios as $aulas => $aula) {
                   foreach ($aula as $dia => $disciplina) {
                        if($disciplina != 0){
                            $aula = new Aula();
                            $aula->dia = $dia;
                            $aula->posicao = $aulas;
                            $aula->turma_id = $turma_id;
                            $aula->disciplina_id = $disciplina;
                            $inserido[] = $aula->save();
                        }
                    }             
                }
                
                $aulas_novas = $this->inserido_removido($inserido, count($inserido));
                
                //ASSOCIA OS PROFESSORES NOVOS DAS DISCIPLINAS
                
                $professores = $req->input('professor');

                foreach ($professores as $disciplina_id => $professor_id) {
                    $disciplina = $this->disciplina->find($disciplina_id);
                    $disciplina->professores()->attach($professor_id,['turma_id' => $turma_id]);
                }

                if($aulas_novas){
                    return redirect()->route('turma.show')
                    ->withInput()
                    ->with('success','O horário da turma: '.$turma->descricao.' foi atualizado com sucesso!');
                }
            }
        }
        else{
            return redirect()->route('turma.show')
            ->withInput()
            ->with('error','Ocorreu um erro ao editar o horário da turma: '.$turma->descricao);  
        }
    }

    public function show($turma){
        
        $turma_id = $turma;

        if($turma_id >= 1){

            $turma = $this->turma->find($turma_id);
            $aulas = $this->aulas_turma($turma);
            return view('horario.show', compact('turma','aulas'));
        }
        else{
            return redirect()->route('turma.show')
            ->withInput()
            ->with('error','Ocorreu um erro ao visualizar o horário da turma: '.$turma->descricao);  
        }
    }

    public function show_professor(){
        $professor_id = auth()->user()->professor->id;
        $aulas = $this->aulas_professor($professor_id);

        return view('horario.showProfessor',compact('aulas'));
    }

    public function inserido_removido($vetor, $tamanho){
        for ($i = 0; $i < $tamanho ; $i++) {
            if($vetor[$i] == false){
                return false;
            }
        }
        return true;
    }

    public function desassocia_aulas($turma){

        foreach ($turma->aulas as $aula) {
            $removido[] = $aula->delete();
        }

        return $this->inserido_removido($removido,count($removido));
    }

    // FUNÇÃO QUE RETORNA AS DISCIPLINAS CADASTRADAS DE UMA TURMA E SEUS PROFESSORES
    public function disciplinas_turma($turma){
     $where =    [
                    ['curso_disciplina.periodo','=', $turma->periodo],
                    ['curso.id','=',$turma->curso->id],
                    ['disciplina_professor.turma_id','=',$turma->id],
                    ['curso_disciplina.optativa','=',2]
                ];

        $disciplinas = $this->get_disciplinas_turma($where);

        if($turma->optativas->isNotEmpty()){
            foreach ($turma->optativas as $optativa) {

                if($turma->aulas->where('disciplina_id','=', $optativa->disciplina_id)->isEmpty()){
                    $where[] = ['disciplina.id','=', $optativa->disciplina_id];

                    $disciplina = $this->get_disciplinas_turma($where);

                    if($disciplina->isEmpty()){
                        $where2[] = ['disciplina.id','=', $optativa->disciplina_id];
                        $disciplina = $this->get_disciplinas_optativas_turma($where2);
                        $disciplinas = $disciplinas->merge($disciplina);
                    }
                    else{
                        $disciplinas = $disciplinas->merge($disciplina); 
                    }
                }
            }
        }

        return $disciplinas->sortBy('nome')->unique();
    }

    public function get_disciplinas_turma($where){
        
        return DB::table('disciplina')
        ->join('curso_disciplina', 'disciplina.id', '=', 'curso_disciplina.disciplina_id')
        ->join('curso', 'curso.id', '=', 'curso_disciplina.curso_id')
        ->leftjoin('disciplina_professor', 'disciplina.id', '=', 'disciplina_professor.disciplina_id')
        ->leftjoin('professor', 'professor.id', '=', 'disciplina_professor.professor_id')
        ->leftjoin('usuario', 'usuario.id', '=', 'professor.usuario_id')
        ->select('disciplina.*', 'curso_disciplina.aula_semanal','disciplina_professor.professor_id','usuario.username as professor_nome','usuario.abreviatura as apelido')
        ->where($where)->get();
    }

    public function get_disciplinas_optativas_turma($where){
        return DB::table('disciplina')
                ->join('curso_disciplina', 'disciplina.id', '=', 'curso_disciplina.disciplina_id')
                ->join('curso', 'curso.id', '=', 'curso_disciplina.curso_id')
                ->leftJoin('disciplina_professor', 'disciplina.id', '=', 'disciplina_professor.disciplina_id')
                ->leftJoin('professor', 'professor.id', '=', 'disciplina_professor.professor_id')
                ->leftJoin('usuario', 'usuario.id', '=', 'professor.usuario_id')
                ->select('disciplina.*', 'curso_disciplina.aula_semanal','disciplina_professor.professor_id','usuario.username as professor_nome','usuario.abreviatura as apelido')
                ->where($where)
                ->get();
    }
    // FUNÇÃO QUE RETORNA TODAS AS AULAS CADASTRADAS DE UMA TURMA
    public function aulas_turma($turma){
        return DB::table('aula')
        ->join('disciplina', 'disciplina.id', '=', 'aula.disciplina_id')
        ->join('turma', 'turma.id', '=', 'aula.turma_id')
        ->join('disciplina_professor', 'disciplina.id', '=', 'disciplina_professor.disciplina_id')
        ->join('professor', 'professor.id', '=', 'disciplina_professor.professor_id')
        ->join('usuario', 'usuario.id', '=', 'professor.usuario_id')
        ->select('disciplina.*', 'usuario.username as professor_nome','usuario.abreviatura as apelido','aula.posicao as aula','aula.dia','turma.id as turma')
        ->where([
            ['turma.id','=', $turma->id],
            ['disciplina_professor.turma_id','=',$turma->id]
        ])->orderBy('disciplina.nome', 'ASC')->orderBy('aula.dia', 'ASC')->orderBy('aula.posicao','ASC')->get();
    }

    // FUNÇÃO QUE RETORNA TODAS AS AULAS CADASTRADAS DO PROFESSOR LOGADO NO SEMESTRE ATIVO
    public function aulas_professor($professor){

        $aulas =  DB::select('select a.dia, a.posicao as aula, d.sigla as sigla, t.periodo as turma_semestre,t.id as turma_id, c.sigla as curso FROM aula a
            INNER JOIN disciplina d ON d.id = a.disciplina_id
            INNER JOIN turma t ON t.id = a.turma_id
            INNER JOIN curso c ON c.id = t.curso_id
            INNER JOIN semestre s ON s.id = t.semestre_id
            INNER JOIN disciplina_professor dp ON dp.disciplina_id = d.id
            INNER JOIN professor p ON p.id = dp.professor_id WHERE p.id = :professor
            and s.status = :semestre and dp.turma_id = t.id ORDER BY dia,aula ASC', ['professor' => $professor, 'semestre' => 1]);

        return collect($aulas);

    }
}