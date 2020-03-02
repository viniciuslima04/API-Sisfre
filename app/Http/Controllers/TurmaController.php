<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TurmaRequest;

use Illuminate\Support\Collection; 
use Illuminate\Support\Facades\DB;

use App\Http\Models\Turma;
use App\Http\Models\Aula;
use App\Http\Models\Semestre;
use App\Http\Models\Optativa;
use App\Http\Models\Disciplina;

class TurmaController extends Controller
{
    private $turma;
    private $aula;

    public function __construct(Turma $turma, Aula $aula){
        $this->middleware('coord');
        $this->turma    = $turma;
        $this->aula     = $aula;
    }

    /*
        FUNÇÃO PÚBLICA QUE RETORNA A TELA DE CADASTRO DE TURMAS EM CASO DE HAVER UM SEMESTRE ATIVO, CASO CONTRÁRIO RETORNA MENSAGEM DE ERRO.
    */
    public function create(){
        //RECUPERA OS SEMESTRES ATUALMENTE ATIVOS ATRAVÉS DO MÉTODO ESTÁTICO DE SEMESTRE CONTROLLER
        $where[] = ['status','=', 1];
        $semestresAtivo = SemestreController::busca_semestres($where);

        //VARIÁVEL QUE ARMAZENA A MENSAGEM DE ERRO DA FALTA DE SEMESTRE ATIVO, POR PADRÃO VAZIA
        $errorSemestre = '';

        // EM CASO DE NÃO EXISTIR SEMESTRE ATIVO, RETORNA MENSAGEM DE ERRO, PASSANDO A VÁRIAVEL COM VALOR
        if($semestresAtivo->isEmpty()){
            return view('turma.create', ['errorSemestre' => 'Não há um semestre ativo ou cadastrado. Informe ao administrador do sistema!!']);
        }

        /*
            CASO EXISTA, RECUPERA O TIPO DO CURSO E A SIGLA DO MESMO ATRAVÉS DO COORDENADOO PARA OBTENÇÃO DOS TURNOS OFERTADOS PARA O CURSO DO COORDENADOR, E REPASSA PARA A TELA DE CADASTRO.
        */
        $tipo = auth()->user()->professor->curso->tipo;
        $sigla = auth()->user()->professor->curso->sigla;
        $turnos = $this->turnos($tipo, $sigla);

        return view('turma.create',compact('turnos','errorSemestre','semestresAtivo'));
    }

    /*
        FUNÇÃO PÚBLICA QUE TENTA CADASTRAR UM REGISTRO DE TURMA NO BANCO DE DADOS. CASO CONSIGA COM ÊXITO RETORNA MENSAGEM DE SUCESSO NA TELA DE LISTAGEM DE TURMAS, CASO CONTRÁRIO, RETORNA UMA MENSAGEM DE ERRO
    */
    public function store(TurmaRequest $req){
        $periodo     = $req->input('periodo');
        $turno       = $req->input('turno');
        $semestre    = Semestre::find($req->input('semestre'));
        $curso_id    = auth()->user()->professor->curso->id;
        $descricao   = $this->create_description($periodo, $turno, $semestre->tipo);

        $optativas   = $req->input('optativa');

        //PARA EFETUAR O CADASTRO NÃO PODE HAVER NENHUMA TURMA NO MESMO PERÍODO, SEMESTRE, CURSO E TURNO
        if($this->contagem_cursos($periodo, $turno, $semestre->id, $curso_id) == 0){

            $turma = Turma::create([
                'periodo'           => $req->input('periodo'),
                'turno'             => $req->input('turno'),
                'semestre_id'       => $semestre->id,
                'descricao'         => $descricao,
                'curso_id'          => $curso_id
            ]);
            
            if(!empty($turma)){
                $save[] = !empty($turma);

                //SÓ CADASTRA OPTATIVAS SE HOUVER
                if(!empty($optativas)){
                    $save[] = $this->cadastrar_optativas($optativas, $turma);
                }
            }

            $inserido = FaltaController::all_save($save,count($save));

            if($inserido){
                return redirect()->route('turma.show')
                ->withInput()
                ->with('success','A Turma: '.$descricao.' foi cadastrada com sucesso!');
            }
            else{
                $this->remover($turma);
            }

            return redirect()->route('turma.show')
            ->withInput()
            ->with('error','A Turma: '.$descricao.' não pôde ser cadastrada');
        }
        //CASO EXISTA UMA TURMA QUE ATENDE AS CONDIÇÕES RETORNA O ERRO PARA TELA DE CADASTRO.
        else{
            return redirect()->route('turma.create')
            ->withInput()
            ->withErrors([
                'periodo'   => 'Já existe uma turma nesse período, turno e semestre',
                'turno'     => 'Já existe uma turma nesse turno, período e semestre',
                'semestre'  => 'Já existe uma turma nesse semestre, período e turno',
            ]);
        }
    }

    /*
        FUNÇÃO PÚBLICA QUE RETORNA A TELA DE LISTAGEM DAS TURMAS 
        EXIBINDO POR PADRÃO TODAS AS TURMAS DAQUELE CURSO NO SEMESTRE ATUALMENTE ATIVO, EM CASO DE PESQUISA FILTRA O RESULTADO DAS TURMAS QUE ATENDAM AS CONDIÇÕES DESEJADAS.
    */
    public function show(Request $req){
        $curso_id    = auth()->user()->professor->curso->id;
        $pesquisa    = $req->get('pesquisa','');
        $filtro      = $req->get('filtro','');
        
        //ARMAZENA A CONDIÇÃO DE BUSCA, POR PADRÃO TODOS AS TURMAS DE UM CURSO NOS SEMESTRES ATIVOS
        $where =  [['curso.id','=',$curso_id], ['semestre.status','=',1] ];

        // EM CASO DE BUSCA, FILTRA PELA PESQUISA PASSADA
        if($pesquisa && $filtro){
            $where[] = ['turma.descricao','LIKE','%'.$pesquisa.'%'];
            $where[] = ['semestre.tipo','=', $filtro];
        }
        else if($pesquisa){
            $where[] = ['turma.descricao','LIKE','%'.$pesquisa.'%']; 
        }
        else if($filtro){
            $where[] = ['semestre.tipo','=', $filtro];
        }

        // RETORNA TODAS AS TURMAS QUE ATENDAM AS CONDIÇÕES DE BUSCA
        $turmas = self::busca_turmas($where);

        return view('turma.show',compact('turmas','pesquisa','filtro'));
    }

    public static function busca_turmas($where){
        return Turma::with('semestre','curso')
                ->join('semestre', 'semestre.id', '=', 'turma.semestre_id')
                ->join('curso', 'curso.id', '=', 'turma.curso_id')
                ->select('turma.*', 'semestre.tipo as semestre_tipo')
                ->where($where)
                ->orderBy('turma.descricao','ASC', 'semestre.tipo','ASC')
                ->paginate(10); 
    }

    /*
        FUNÇÃO PÚBLICA QUE RETORNA O FORMULÁRIO DE EDIÇÃO DO REGISTRO DA TURMA PASSADO COMO PARÂMETRO
    */
    public function edit($turma){
        $turmaEdit      = $this->turma->find($turma);
        $where[]        = ['status','=', 1];
        $semestresAtivo = SemestreController::busca_semestres($where);
        $tipo           = auth()->user()->professor->curso->tipo;
        $sigla          = auth()->user()->professor->curso->sigla;
        $turnos         = $this->turnos($tipo, $sigla);

        $where2         =  [
                                ['curso_disciplina.periodo','=', $turmaEdit->periodo],
                                ['curso.id','=', $turmaEdit->curso_id],
                                ['curso_disciplina.optativa','=', 1]
                            ];

        $disciplinasOptativas = self::get_optativas_da_turma($where2);

        return view('turma.edit',compact('turnos','turmaEdit','semestresAtivo', 'disciplinasOptativas'));
    }

    /*
        FUNÇÃO PÚBLICA QUE TENTA ATUALIZAR UM REGISTRO DE TURMA PASSADO COMO PARÂMETRO. CASO CONSIGA COM ÊXITO RETORNA MENSAGEM DE SUCESSO NA TELA DE LISTAGEM DE TURMAS, CASO CONTRÁRIO, RETORNA UMA MENSAGEM DE ERRO
    */
    public function update($turma, TurmaRequest $req){
        $turmaUpdate        = $this->turma->find($turma);
        $curso_id           = auth()->user()->professor->curso->id;
        $periodo            = $req->input('periodo');
        $turno              = $req->input('turno');
        $semestre           = Semestre::find($req->input('semestre'));
        $contagem_cursos    = 0;
        $optativas          = $req->input('optativa');

        if($turno != $turmaUpdate->turno || $periodo != $turmaUpdate->periodo || $semestre->id != $turmaUpdate->semestre_id){
            $contagem_cursos = $this->contagem_cursos($periodo, $turno, $semestre->id, $curso_id);
        }

        if( $contagem_cursos == 0){

            $descricao   = $this->create_description($periodo, $turno, $semestre->tipo);
            
            $turmaUpdate->semestre_id   = $semestre->id;
            $turmaUpdate->periodo       = $periodo;
            $turmaUpdate->turno         = $turno;
            $turmaUpdate->descricao     = $descricao;
        
            if($turmaUpdate->optativas->isNotEmpty()){

                if(count($optativas) > $turmaUpdate->optativas->count() || count($optativas) < $turmaUpdate->optativas->count() || $this->isMudancas_optativas($turmaUpdate, $optativas) && !empty($optativas)){
                    
                    $remover    = $this->remover_optativas($turmaUpdate);

                    if($remover){
                        $cadastrar  = $this->cadastrar_optativas($optativas, $turmaUpdate);

                        if($cadastrar){
                            $salvarTurma    = $turmaUpdate->save();
                            $hasAula        = $turmaUpdate->aulas->isNotEmpty();

                            if($salvarTurma && $hasAula){
                                return redirect()->route('horario.edit',$turmaUpdate->id)
                                ->withInput()
                                ->with('success','A Turma: '.$descricao.' foi atualizada com sucesso! Porém houve alterações em suas optativas sendo necessário atualizar o horário da turma');    
                            }
                            $save[] = $salvarTurma;
                        }

                        $save[] = $cadastrar; 
                    }

                    $save[] = $remover;
                }

            }
            else if(!empty($optativas) && count($optativas) > 0 && $turmaUpdate->optativas->isEmpty() ){
                $cadastrar  = $this->cadastrar_optativas($optativas, $turmaUpdate);

                if($cadastrar){
                    $salvar = $turmaUpdate->save();
                    if($salvar){
                        return redirect()->route('horario.edit',$turmaUpdate->id)
                        ->withInput()
                        ->with('success','A Turma: '.$descricao.' foi atualizada com sucesso! Porém houve alterações em suas optativas sendo necessário atualizar o horário da turma');   
                    }
                    $save[] = $salvar; 
                }

                $save[] = $cadastrar; 
            }

            $save[] = $turmaUpdate->save();

            $atualizado = FaltaController::all_save($save,count($save));
            if($atualizado){
                return redirect()->route('turma.show')
                ->withInput()
                ->with('success','A Turma: '.$descricao.' foi atualizada com sucesso!');
            }
        }

        return redirect()->route('turma.show')
        ->withInput()
        ->with('error','A Turma: '.$descricao.' não pôde ser atualizada');
    }


    public function cadastrar_optativas($optativas, $turma){
        $save = [];
        foreach ($optativas as $optativa) {
            $disciplinaOptativa                = new Optativa();
            $disciplinaOptativa->disciplina_id = $optativa;
            $disciplinaOptativa->turma_id      = $turma->id;
            $disciplinaOptativa->curso_id      = $turma->curso_id;
            $save[]                            = $disciplinaOptativa->save();
        }

        return FaltaController::all_save($save,count($save));
    }

    // REMOVE TODAS AS OPTATIVAS E AULAS RELACIONADAS A ESSAS OPTATIVAS ASSIM COMO O PROFESSOR QUE A LECIONAVA
    public function remover_optativas($turma){
        $save = [];

        foreach ($turma->optativas as $optativa) {

            //SE TIVER AULAS PARA A OPTATIVA A SER REMOVIDA REMOVE-AS TAMBÉM, E FICA SEM PROFESSOR QUE A LECIONE.

            if($turma->aulas->where('disciplina_id','=', $optativa->disciplina_id)->isNotEmpty()){

                $disciplina = Disciplina::find($optativa->disciplina_id);
                $disciplina->professores()->wherePivot('disciplina_id','=',$optativa->disciplina_id)->detach(); 
                $save[] = $turma->aulas()->where('disciplina_id','=', $optativa->disciplina_id)->delete();
            }

            $save[] = $turma->optativas()->delete($optativa);
        }

        return FaltaController::all_save($save,count($save));
    }

    public function isMudancas_optativas($turmaUpdate, $optativas){
        $notMudou = [];

        foreach ($turmaUpdate->optativas as $disciplinaOptativa){
            $notMudou[] =  in_array($disciplinaOptativa->disciplina_id, $optativas);
        }

        return ! FaltaController::all_save($notMudou,count($notMudou));
    }


    /*
        FUNÇÃO PÚBLICA QUE RETORNA UMA MENSAGEM DE CONFIRMAÇÃO NA TELA DE LISTAGEM DE TURMAS CASO A REMOÇÃO TENHA OCORRIDO COM SUCESSO E UMA MENSAGEM DE ERRO CASO CONTRÁRIO.
    */
    public function delete($turma){
        $turma = $this->turma->find($turma);
        $descricao = $turma->descricao;

        $removido = $this->remover($turma);

        if($removido){
            return redirect()->route('turma.show')
            ->withInput()
            ->with('success','A Turma: '.$descricao.' foi removida com sucesso!');
        }

        return redirect()->route('turma.show')
        ->withInput()
        ->with('error','A Turma: '.$descricao.' não pôde ser removida!');

    }

    public function remover($turma){
        return $turma->delete();
    }

    /*
        FUNÇÃO PRIVADA QUE RETORNA UMA COLLECTION CONTENDO OS TURNOS QUE SÃO OFERTADOS PARA UMA TURMA DE DETERMINADO CURSO A PARTIR DO TIPO E SIGLA DO CURSO.
        OBS:. INFORMAÇÕES RETIRADAS DO SITE DA INSTITUIÇÃO.
        OBS:.² APENAS OS CURSOS JÁ CADASTRADOS DA GRADUAÇÃO, POSSUEM ESPECIFICAÇÃO DE TURNOS, OS NOVOS UTILIZARAM OS TRÊS TURNOS COMO PADRÃO.
    */
    private function turnos($tipo, $sigla){
        // CRIA UMA COLLECTION VAZIA
        $turnos = new Collection();

        switch ($tipo) {
            case 'GRADUAÇÃO':
                if($sigla == 'BSI' || $sigla == 'FIS'){
                    $turnos = collect(['T' => 'TARDE','N' => 'NOITE']);  
                }
                elseif($sigla == 'MAT' || $sigla == 'MIN'){
                    $turnos = collect(['M' => 'MANHÃ','N' => 'NOITE']); 
                }
                break;
            
            case 'INTEGRADO':
                $turnos = collect(['D' => 'DIURNO']);
                break;

            case 'TÉCNICO':
                $turnos = collect(['T' => 'TARDE','N' => 'NOITE']);
                break;
        }

        if($turnos->isEmpty()){
            $turnos = collect(['M' => 'MANHÃ', 'T' => 'TARDE','N' => 'NOITE']);
        }
        
        return $turnos;
    }

    /*
        FUNÇÃO PRIVADA QUE RETORNA A DESCRIÇÃO DA TURMA CRIADA A PARTIR DO TURNO, PERÍODO (PASSADOS NO PARÂMETRO DA FUNÇÃO) E SIGLA DO CURSO.
    */
    private function create_description($periodo, $turno, $tipo){
        //RECUPERA A SIGLA DO CURSO DO COORDENADOR LOGADO
        $sigla = auth()->user()->professor->curso->sigla;
        $curso = "";

        // MODIFICA O TURNO PASSADO DO PARÂMETRO DE CHAR PRA SUA DESCRIÇÃO COMPLETA
        switch ($turno) {
            case 'M':
                $turno = 'MANHÃ';
                break;
            
            case 'T':
                $turno = 'TARDE';
                break;

            case 'N':
                $turno = 'NOITE';
                break;

            case 'D':
                $turno = 'DIURNO';
                break;
        }

        /* 
            MODIFICA A VARIÁVEL CURSO A PARTIR DE SUA SIGLA PARA O NOME "POPULAR" DO CURSO.
            OBS:. SOMENTE PARA OS CURSOS JÁ PRESENTES NO SISTEMA, PARA OS NOVOS QUE VENHAM A SER CADASTRADOS UTILIZAM O NOME LITERAL DO CURSO.
        */
        switch ($sigla) {
            case 'SI':
                $curso = 'SISTEMAS';
                break;
            
            case 'MAT':
                $curso = 'MATEMÁTICA';
                break;

            case 'FIS':
                $curso = 'FÍSICA';
                break;

            case 'MIN':
                $turno = 'MECATRÔNICA';
                break;

            case 'TME':
                $curso = 'TÉC. MECÂNICA';
                break;
            
            case 'TEL':
                $curso = 'TÉC. ELETROTÉCNICA';
                break;

            case 'IME':
                $curso = 'INT. MECÂNICA';
                break;

            case 'INF':
                $curso = 'INT. INFORMÁTICA';
                break;

            case 'ELE':
                $curso = 'INT. ELETROTÉCNICA';
                break;
            default:
                $curso = auth()->user()->professor->curso->nome;
                break;
        }

        return "S".$periodo." DE ".$curso." - ".$turno.' ('.$tipo.')';
    }

    /*
        FUNÇÃO PRIVADA QUE RETORNA A QUANTIDADE DE CURSOS EM DETERMINADO: PERÍODO, TURNO, SEMESTRE E CURSO.
        UTILIZADA PARA VERIFICAR SE JÁ HÁ UM CURSO, QUE ATENDA OS PARÂMETROS.
    */
    private function contagem_cursos($periodo, $turno, $semestre_id, $curso_id){
            return $this->turma->where([
            ['periodo','=',$periodo],
            ['turno','=',$turno],
            ['semestre_id','=',$semestre_id],
            ['curso_id','=',$curso_id]
        ])->count();
    }

    public static function get_optativas_da_turma($where){
        return DB::table('disciplina')
                ->join('curso_disciplina', 'disciplina.id', '=', 'curso_disciplina.disciplina_id')
                ->join('curso', 'curso.id', '=', 'curso_disciplina.curso_id')
                ->select('disciplina.*', 'curso_disciplina.aula_semanal')
                ->where($where)
                ->orderBy('disciplina.nome', 'ASC')
                ->get();
    } 
}