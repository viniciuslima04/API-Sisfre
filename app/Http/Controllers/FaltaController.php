<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\FaltaRequest;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

use App\Http\Models\Falta;
use App\Http\Models\Professor;
use App\Http\Models\Turma;
use App\Http\Models\Curso;
use App\Http\Models\Disciplina;
use App\Http\Models\Funcionario;
use App\Http\Models\Usuario;
use App\Http\Models\SabadoLetivo;
use App\Http\Models\Feriado;
use App\Http\Models\Anteposicao;
use App\Http\Models\Reposicao;
use App\Http\Models\Semestre;

use App\Notifications\FaltaConfirmada;

class FaltaController extends Controller
{
    private $falta;
    private $professor;
    private $turma;
    private $disciplina;
    private $curso;
    private $funcionario;
    private $usuario;
    private $sabadoLetivo;
    private $feriado;
    private $reposicao;
    private $anteposicao;

    public function __construct(Curso $curso, Professor $professor, Turma $turma, Disciplina $disciplina, Falta $falta, Funcionario $funcionario, Usuario $usuario, SabadoLetivo $sabado, Feriado $feriado, Reposicao $reposicao, Anteposicao $anteposicao){

        $this->middleware('func', ['only' => ['create', 'store','show_funcionario']]);
        $this->middleware('prof', ['only' => ['show_professor']]);
        $this->middleware('coord', ['only' => ['show_coordenador', 'cancelar', 'confirmar']]);

        $this->curso        = $curso;
        $this->professor    = $professor;
        $this->falta        = $falta;
        $this->disciplina   = $disciplina;
        $this->turma        = $turma;
        $this->funcionario  = $funcionario;
        $this->usuario      = $usuario;
        $this->feriado      = $feriado;
        $this->sabadoLetivo = $sabado;
        $this->reposicao    = $reposicao;
        $this->anteposicao  = $anteposicao;
    }

    public function create(){
        $cursos = $this->curso->orderBy('nome', 'ASC')->get();

        $hoje   = Carbon::now('America/Fortaleza');

        return view('falta.create',compact('cursos','hoje'));
    }

    public function store(FaltaRequest $req){
        $funcionario_id =   auth()->user()->funcionario->id;
        $turma          =   $this->turma->find($req->input('turma'));
        $semestreAtivo  =   Semestre::find($turma->semestre_id);
        $data           =   implode("-", array_reverse(explode("/",$req->input('dia'))));

        // ARMAZENA A DATA DO DIA DA FALTA + A QUANTIDADE X DE DIAS LETIVOS
        $dataSoma        =   self::somar_dias_uteis($data, 15);
       
        // RECUPERA A DATA DO FIM DA ETAPA DA FALTA
        $fimEtapa       =   $this->verifica_etapa($data, $semestreAtivo);

        // RECUPERA O QUE VEM PRIMEIRO: O FIM DA ETAPA DA FALTA OU O DIA DE REPOSIÇÃO
        $dataFim        =   Carbon::createFromFormat('Y-m-d', $this->data_final($dataSoma, $fimEtapa),'America/Fortaleza');

        // PEGA O DIA ATUAL
        $hoje           =   Carbon::now('America/Fortaleza');

        // PEGA A DIFERENÇA ENTRE O PRAZO MÁXIMO PRA REPOR E HOJE
        $diferenca      =   $dataFim->diff($hoje);

        // PEGA A DIFERENÇA ENTRE O FIM DA 1º ETAPA E HOJE
        $diferenca2     =   $dataFim->diff(Carbon::createFromFormat('Y-m-d', $this->data_final($dataSoma, $semestreAtivo->metade),'America/Fortaleza'));

        // SE HOJE É IGUAL A DATA LIMITE PRA REPOR E A DATA LIMITE É IGUAL AO FIM DA 1ª ETAPA
        if($diferenca->days == 0 && $diferenca2->days == 0){
            //$validade = self::somar_dias_uteis($data,2);
            $validade = $semestreAtivo->fim;
        }
        // SE HOJE É IGUAL A DATA LIMITE PRA REPOR E A DATA LIMITE É IGUAL AO FIM DO SEMESTRE
        elseif($diferenca->days == 0 && $diferenca2->days != 0){
            $validade = self::somar_dias_uteis($data,5);
        }
        else{
            // $validade = $dataFim; FAZ COM QUE AS FALTAS QUE NÃO SEJAM NO ÚLTIMO DIA DE CADA ETAPA RESPEITEM À REGRA DO QUE VIER PRIMEIRO O DIA DA REPOSIÇÃO OU FIM DA ETAPA

            $validade = $semestreAtivo->fim;
        }
       
        $this->falta->dia               = $data;
        $this->falta->situacao          = $req->input('situacao');
        $this->falta->qtd               = $req->input('qtd');
        $this->falta->funcionario_id    = $funcionario_id;
        $this->falta->professor_id      = $req->input('professor');
        $this->falta->turma_id          = $req->input('turma');
        $this->falta->disciplina_id     = $req->input('disciplina');
        $this->falta->validade          = $validade;

        if($req->input('observacao')){
            $this->falta->obs     = mb_strtoupper($req->input('observacao'),'UTF-8');
        }

        $inserido = $this->falta->save();
            
        if($inserido)
        {
            return redirect()->route('falta.show.funcionario')
            ->withInput()
            ->with('success','A Falta foi cadastrada com sucesso!');
        }
    }

    public function show_funcionario(Request $req){
        $funcionario_id = auth()->user()->funcionario->id;
        $pesquisa       = $req->get('pesquisa','');
        $where          = [ 
                            ['falta.situacao','=','ESP'],
                            ['funcionario.id','=',$funcionario_id],
                            ['semestre.status','=',1]
                          ];
        
        if($pesquisa){
            $where[] = ['u.username','LIKE','%'.$pesquisa.'%'];
        }
        
        $faltasFiltradas    = self::busca_faltas($where);
        
        return view('falta.showFuncionario',compact('faltasFiltradas','pesquisa'));
    }

    public function show_coordenador(Request $req){
        $curso          = auth()->user()->professor->curso->id;
        $situacao       = $req->get('situacao','');
        $semestre       = $req->get('semestre','');
        $pesquisa       = $req->get('pesquisa','');
        $where          = [
                            ['turma.curso_id','=',$curso],
                            ['semestre.status','=',1]
                        ];

        $semAtivos  = $this->get_semestresAtivos();

        if($semAtivos->isEmpty()){
            return redirect()->route('home')
            ->withInput()
            ->with('error','Não há nenhum semestre ativo'); 
        }

        if($semestre){
            $where[] = ['semestre.id','=',$semestre];
        }

        if($situacao){
            $where[] = ['falta.situacao','=',$situacao];
        }

        if($pesquisa){
            $where[] = ['u.username','LIKE','%'.$pesquisa.'%'];   
        }

        $faltasFiltradas    = self::busca_faltas($where, 1);
        $faltasVerificadas  = $this->verifica_vencidas($faltasFiltradas);

        if($situacao == '' && $faltasVerificadas->where('situacao','=','ESP')->isNotEmpty()){
            $where2      = [
                            ['turma.curso_id','=',$curso],
                            ['semestre.status','=',1],
                            ['falta.situacao','=','ESP']
                          ];

            if($semestre){
                $where2[] = ['semestre.id','=',$semestre];
            }

            if($pesquisa){
                $where2[] = ['u.username','LIKE','%'.$pesquisa.'%'];   
            }

            $faltasFiltradas    = self::busca_faltas($where2);
            $faltasVerificadas  = $this->verifica_vencidas($faltasFiltradas);
        }
        else{
            $faltasFiltradas    = self::busca_faltas($where);
            $faltasVerificadas  = $this->verifica_vencidas($faltasFiltradas);   
        }

        return view('falta.showCoordenador',compact('faltasVerificadas','pesquisa','situacao','semAtivos', 'semestre'));
    }

    public function show_professor(Request $req){
        $professor      = auth()->user()->professor->id;
        $situacao       = $req->get('situacao','');
        $semestre       = $req->get('semestre','');
        $pesquisa       = $req->get('pesquisa','');
        $where          = [
                            ['professor.id','=',$professor],
                            ['semestre.status','=',1]
                        ];

        $semAtivos  = $this->get_semestresAtivos();

        if($semAtivos->isEmpty()){
            return redirect()->route('home')
            ->withInput()
            ->with('error','Não há nenhum semestre ativo'); 
        }

        if($semestre){
            $where[] = ['semestre.id','=',$semestre];
        }

        if($situacao){
            $where[] = ['falta.situacao','=',$situacao]; 
        }
        else{
            $where[] = ['falta.situacao','!=','ESP'];
            $where[] = ['falta.situacao','!=','NEG'];
        }

        if($pesquisa){
            $where[] = ['disciplina.nome','LIKE','%'.$pesquisa.'%']; 
        }

        $faltasFiltradas    = self::busca_faltas($where, 1);
        $faltasVerificadas  = $this->verifica_vencidas($faltasFiltradas);

        if($faltasVerificadas->where('situacao','=','CONF')->isNotEmpty() && $situacao == ''){
            $where2      = [
                            ['professor.id','=',$professor],
                            ['semestre.status','=',1],
                            ['falta.situacao','=','CONF']
                          ];

            if($semestre){
                $where2[] = ['semestre.id','=',$semestre];
            }

            if($pesquisa){
                $where2[] = ['disciplina.nome','LIKE','%'.$pesquisa.'%']; 
            }

            $faltasFiltradas    = self::busca_faltas($where2);
            $faltasVerificadas  = $this->verifica_vencidas($faltasFiltradas);
        }
        else{
            $faltasFiltradas    = self::busca_faltas($where);
            $faltasVerificadas  = $this->verifica_vencidas($faltasFiltradas);   
        }

        return view('falta.showProfessor',compact('faltasVerificadas','pesquisa','situacao','semAtivos', 'semestre'));
    }

    public static function busca_faltas($where, $get = 0){

        if($get == 0){
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
            ->paginate(10);
        }
        else if($get == 1){
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
    }

    public function cancelar($falta){
        $falta = $this->falta->find($falta);

        $anteposicoes = $falta->anteposicoes;
        $reposicoes = $falta->reposicoes;

        switch ($falta->situacao) {

            case "ESP":
                $falta->situacao = 'NEG';
                break;

            case "CONF":
                if($reposicoes->where('situacao','=','ESP')->isEmpty()){
                    $falta->situacao = 'NEG'; 
                }
                else{
                    $falta->situacao = 'NEG'; 
                    foreach ($reposicoes as $reposicao) {
                        $reposicao->situacao = 'NEG';
                        $save[] = $reposicao->save();
                    }
                }
                break;

            case "PAGA_P":
                $falta->situacao = 'NEG';

                if($anteposicoes->isEmpty()){
                    foreach ($reposicoes as $reposicao) {
                        $reposicao->situacao = "NEG";
                        $save[] = $reposicao->save();
                    }
                }
                else{
                    foreach ($anteposicoes as $anteposicao) {
                        if($anteposicao->situacao == 'VENC'){
                            $anteposicao->situacao ='CONF';
                        }
                        $anteposicao->gasta = $anteposicao->gasta - 1;
                        $save[] = $anteposicao->save();
                        $falta->anteposicoes()->detach($anteposicao->id);
                    }
                }
                break;

            case "PAGA_T":
                $falta->situacao = 'NEG';

                if($anteposicoes->isNotEmpty() && $reposicoes->isNotEmpty()){
                    foreach ($anteposicoes as $anteposicao) {
                        if($anteposicao->situacao == 'VENC'){
                            $anteposicao->situacao ='CONF';
                        }
                        $anteposicao->gasta = $anteposicao->gasta - 1;
                        $save[] = $anteposicao->save();
                        $falta->anteposicoes()->detach($anteposicao->id);
                    }

                    foreach ($reposicoes as $reposicao) {
                        $reposicao->situacao = "NEG";
                        $save[] = $reposicao->save();
                    }
                }
                else if($anteposicoes->isNotEmpty()){
                    if($anteposicoes->count() == 1){
                        foreach ($anteposicoes as $anteposicao) {
                            if($anteposicao->situacao == 'VENC'){
                                $anteposicao->situacao ='CONF';
                            }
                            $anteposicao->gasta = $anteposicao->gasta - 2;
                            $save[] = $anteposicao->save();
                            $falta->anteposicoes()->detach($anteposicao->id);
                        }
                    }
                    else if($anteposicoes->count() == 2){
                        foreach ($anteposicoes as $anteposicao) {
                            if($anteposicao->situacao == 'VENC'){
                                $anteposicao->situacao ='CONF';
                            }
                            $anteposicao->gasta = $anteposicao->gasta - 1;
                            $save[] = $anteposicao->save();
                            $falta->anteposicoes()->detach($anteposicao->id);
                        }  
                    }
                }
                else if($reposicoes->isNotEmpty()){
                    foreach ($reposicoes as $reposicao) {
                        $reposicao->situacao = "NEG";
                        $save[] = $reposicao->save();
                    }   
                }
                break;
        }

        $save[] = $falta->save(); 

        $cancelado = self::all_save($save, count($save));

        if($cancelado){
            return redirect()->route('falta.show.coordenador')
            ->withInput()
            ->with('success','A Falta foi cancelada com sucesso!');
        }
    }

    public function confirmar($falta){
        $falta               = $this->falta->find($falta);
        $professorNotificado = $falta->professor->usuario;
        $situacao            = 'CONF'; 

        //RECUPERA A SITUAÇÃO DA FALTA E O ID DA ANTEPOSIÇÃO , CASO UMA ANTEPOSIÇÃO PAGUE-A.
        $paga = AnteposicaoController::anteposicao_paga_falta($falta->id);

        if($paga->isNotEmpty()){
            $situacao = $paga['situacao'];
            $falta->anteposicoes()->attach($paga['anteposicao']);
        }
        $falta->situacao = $situacao;
        $save = $falta->save();
        
        $professorNotificado->notify(new FaltaConfirmada($falta, $situacao));

        if($save){
            switch ($situacao) {
                case 'PAGA_T':
                    return redirect()->route('falta.show.coordenador')
                    ->withInput()
                    ->with('success','A Falta foi confirmada com sucesso! E havia uma anteposição que a repôs totalmente');
                break;
                
                case 'PAGA_P':
                    return redirect()->route('falta.show.coordenador')
                    ->withInput()
                    ->with('success','A Falta foi confirmada com sucesso! E havia uma anteposição que a repôs parcialmente');
                break;

                default:
                    return redirect()->route('falta.show.coordenador')
                    ->withInput()
                    ->with('success','A Falta foi confirmada com sucesso!');
                break;
            }
        }
        return redirect()->route('falta.show.coordenador')
        ->withInput()
        ->with('error','A Falta não pôde ser confirmada!');
    }

    // FUNÇÃO QUE SOMA A DATA PASSADA X DIAS UTEIS E RETORNA O PRAZO FINAL QUE A FALTA TEM QUE SER REPOSTA
    public static function somar_dias_uteis($data,$qtd_dias_uteis){
        $diasUteis      = 1;
        $anoCorrente   = Carbon::now('America/Fortaleza')->year;

        $data           = self::soma_dias($data,1);

        while($diasUteis <= $qtd_dias_uteis){

            if(self::verifica_ferias($data, $anoCorrente) > 0){
                $data = self::soma_dias($data,self::verifica_ferias($data, $anoCorrente));
            }
               
            if(self::verifica_recesso($data, $anoCorrente) > 0){
                $data = self::soma_dias($data, self::verifica_recesso($data, $anoCorrente));
            }
                
            $diaSemana = date("w",Carbon::createFromFormat('Y-m-d', $data)->timestamp);
    
            if($diaSemana == 6){ // SE FOR UM SÁBADO
                if(self::verifica_sabado($data,$anoCorrente) == true){
                    $diasUteis++;
                    $data = self::soma_dias($data,1);
                }
                else{
                    $data = self::soma_dias($data,1);
                }
            }
            elseif($diaSemana == 0){ // SE FOR UM DOMINGO
                $data = self::soma_dias($data,1);
            }
            else{

                if(self::verifica_feriado($data, $anoCorrente) == false){
                    $diasUteis++;
                    $data = self::soma_dias($data,1);
                }
                else{
                    $data = self::soma_dias($data,1);
                } 
            }
        }

        // SEMPRE RETORNAVA 1 DIA A MAIS AO DIA ÚTIL, POR ISSO A SUBTRAÇÃO DE 1 DIA
        return self::soma_dias($data,-1);
    }

    //FUNÇÃO QUE SOMA X DIAS A DATA PASSADA 
    public static function soma_dias($data,$qtd_dias){
        return date('Y-m-d',strtotime('+'.$qtd_dias.' days',strtotime($data)));
    }

    public static function verifica_feriado($data,$anoCorrente){
        // transforma data passada para objeto CARBON
        $dataC = Carbon::createFromFormat('Y-m-d', $data,'America/Fortaleza');

        //recupera se há feriados durante o semestre letivo atual
        $feriados = Feriado::where('tipo','=', 1)->whereYear('data','>=', $anoCorrente)->get();
        
        if($feriados->isNotEmpty()){
            foreach ($feriados as $feriado) {
                $data_inicio = Carbon::createFromFormat('Y-m-d', $feriado->data,'America/Fortaleza');
                if($dataC->diffInDays($data_inicio) == 0){
                    return true;
                }
            }
        }

        return false;
    }

    public static function verifica_ferias($data,$anoCorrente){
        // transforma data passada para objeto CARBON
        $dataC = Carbon::createFromFormat('Y-m-d', $data,'America/Fortaleza');

        //recupera se há férias durante o semestre letivo atual
        $ferias = Feriado::where('tipo','=', 2)->whereYear('data','>=', $anoCorrente)->get();

        if($ferias->isNotEmpty()){
            foreach ($ferias as $feria) {
                $data_inicio = Carbon::createFromFormat('Y-m-d', $feria->data,'America/Fortaleza');
                if($dataC->diffInDays($data_inicio) == 0){
                    $data_termino = Carbon::createFromFormat('Y-m-d', $feria->final, 'America/Fortaleza');
                    return $data_termino->diffInDays($data_inicio) + 1;
                     
                }
            }
        }

        return 0;
    }

    public static function verifica_recesso($data,$anoCorrente){
        // transforma data passada para objeto CARBON
        $dataC = Carbon::createFromFormat('Y-m-d', $data,'America/Fortaleza');

        // recupera se há recessos durante o semestre letivo atual
        $recessos = Feriado::where('tipo','=', 3)->whereYear('data','>=', $anoCorrente)->get();

        if($recessos->isNotEmpty()){
            foreach ($recessos as $recesso) {
                $data_inicio = Carbon::createFromFormat('Y-m-d', $recesso->data,'America/Fortaleza');
                if($dataC->diffInDays($data_inicio) == 0){
                    $data_termino = Carbon::createFromFormat('Y-m-d', $recesso->final, 'America/Fortaleza');
                    return $data_termino->diffInDays($data_inicio);
                }
            }
        }
        return 0;
    }

    // FUNÇÃO SE UM SÁBADO É LETIVO, CASO SEJA RETURN TRUE, CASO NÃO RETURN FALSE
    public static function verifica_sabado($data,$anoCorrente){
        // transforma data passada para objeto CARBON
        $dataC = Carbon::createFromFormat('Y-m-d', $data,'America/Fortaleza');
        
        //recupera se há sábados letivo durante o semestre letivo atual
        $sabados_letivos = SabadoLetivo::whereYear('data','>=', $anoCorrente)->get();
        
        if($sabados_letivos->isNotEmpty()){
            foreach ($sabados_letivos as $sabado) {
                $data_inicio = Carbon::createFromFormat('Y-m-d', $sabado->data,'America/Fortaleza');
                if($dataC->diffInDays($data_inicio) == 0){
                    return true;
                }
            }
        }
        return false;
    }
    
    //FUNÇÃO QUE Verifica a qual etapa pertence a falta e retorna o fim da etapa
    public function verifica_etapa($data, $semestre_ativo){
       
        $dataC  = Carbon::createFromFormat('Y-m-d', $data,'America/Fortaleza');

        $etapa1 = Carbon::createFromFormat('Y-m-d', $semestre_ativo->metade,'America/Fortaleza');
        $diferenca = $etapa1->diff($dataC);

        // DATA É MENOR QUE A DATA DO INICIO DA 2° ETAPA | PERTENCE A 1° ETAPA
        if($diferenca->days > 0 && $diferenca->invert == 1 || $diferenca->days == 0 && $diferenca->invert == 0){
            return  $semestre_ativo->metade;
        }

        $etapa2 = Carbon::createFromFormat('Y-m-d', $semestre_ativo->fim,'America/Fortaleza');
        $diferenca = $etapa2->diff($dataC);

        // DATA É MENOR QUE A DATA DO INICIO DA 2° ETAPA | PERTENCE A 1° ETAPA
        if($diferenca->days > 0 && $diferenca->invert == 1 || $diferenca->days == 0 && $diferenca->invert == 0){
            return  $semestre_ativo->fim;
        }
    }

    //FUNÇÃO QUE VERIFICA O QUE VEM PRIMEIRO SE O FIM DA ETAPA OU DATA SOMADA + 15 DIAS ÚTEIS
    public function data_final($data_fim,$fim_etapa){
        $fim_etapaC = Carbon::createFromFormat('Y-m-d', $fim_etapa,'America/Fortaleza');
        $data_fimC = Carbon::createFromFormat('Y-m-d', $data_fim,'America/Fortaleza');

        $diferenca = $fim_etapaC->diff($data_fimC);
        
        // DATA_FIM VEM PRIMEIRO QUE O FIM DA ETAPA DA FALTA
        if($diferenca->days > 0 && $diferenca->invert == 1){
            return  $data_fim;
        }
        // O FIM DA ETAPA VEM PRIMEIRO QUE A DATA_FIM
        else{
            return $fim_etapa;
        } 
    }

    // FUNÇÃO QUE VERIFICA SE A DATA LIMITE FOI ULTRAPASSADA SE SIM MUDA A SITUAÇÃO DA FALTA PARA "VENC"
    public function verifica_vencidas($faltas){
        $hoje = Carbon::now('America/Fortaleza');
        
        foreach ($faltas as $falta) {
            $validade = Carbon::createFromFormat('Y-m-d', $falta->validade,'America/Fortaleza');
            $diferenca = $hoje->diff($validade);
            // Invert verifica se é negativo caso 1, no carbon indica que a data do parâmetro é menor
            if($diferenca->invert == 1 && $diferenca->days>0 && $falta->situacao == 'CONF' && $falta->situacao == 'PAGA_P'){
                $falta_venc = $this->falta->find($falta->id);
                $falta_venc->situacao = "VENC";
                $falta_venc->save();
                $falta->situacao = "VENC";
            }
        }

        return $faltas;
    }

    // verifica se todas as mudanças foram salvas ou não
    public static function all_save($vetor, $tamanho){
        for ($i = 0; $i < $tamanho ; $i++) {
            if($vetor[$i] == false){
                return false;
            }
        }
        return true;
    }

    //FUNÇÃO APENAS PARA RETORNAR A DESCRIÇÃO DA SITUAÇÃO ATUAL DA FALTA.
    public static function situacao($situacao){
        switch ($situacao) {
            case 'PAGA_T':
                return 'Totalmente paga';
            break;
            
            case 'PAGA_P':
                return 'Parcialmente paga';
            break;

            case 'CONF':
                return 'Aguardando Reposição';
            break;

            case 'ESP':
                return 'Aguardando Confirmação';
            break;

            case 'VENC':
                return 'Não Reposta';
            break;
        }
    }

    // FUNÇÕES EM DESUSO POR ENQUANTO: EDIT | UPDATE | DELETE
    public function edit($falta){
        $falta = $this->falta->find($falta);

        $cursos = $this->curso->orderBy('nome', 'ASC')->get();

        return view('falta.edit',compact('cursos','falta'));   
    }

    public function update(FaltaRequest $req, $falta){
        $falta = $this->falta->find($falta);

        if($this->is_waiting($falta) == false){
            return redirect()->route('falta.show')
            ->withInput()
            ->with('error','A falta foi aprovada pelo coordenador do curso antes da atualização');
        }

        $funcionario_id =  auth()->user()->funcionario->id;
        $data = implode("-", array_reverse(explode("/",$req->input('dia'))));

        $falta->dia               = $data;
        $falta->situacao          = $req->input('situacao');
        $falta->qtd               = $req->input('qtd');
        $falta->funcionario_id    = $funcionario_id;
        $falta->professor_id      = $req->input('professor');
        $falta->turma_id          = $req->input('turma');
        $falta->disciplina_id     = $req->input('disciplina');
        $falta->validade          = $this->somar_dias_uteis($data,15);

        if($req->input('observacao')){
            $falta->obs     = mb_strtoupper($req->input('observacao'),'UTF-8');
        }

        $atualizado = $falta->save();
            
        if($atualizado)
        {
            return redirect()->route('falta.show.funcionario')
            ->withInput()
            ->with('success','A falta foi atualizada com sucesso!');
        }
    }

    public function delete($falta){
        $falta = $this->falta->find($falta);
        $mensagem = 'A(s) falta(s) do(a) professor(a): '.$falta->professor->usuario->name.' na Turma: '.$falta->turma->descricao.' na Disciplina: '.$falta->disciplina->nome.' do Dia: '. implode("/", array_reverse(explode("-",$falta->dia ))).' foi(foram) removida(s) com sucesso!';

        $removido = $falta->delete();

        if($removido)
        {
            return redirect()->route('falta.show.coordenador')
            ->withInput()
            ->with('success',$mensagem);
        }

    }

    public function get_semestresAtivos(){
        return Semestre::where('status','=',1)->orderBy('ano','DESC')->orderBy('etapa','DESC')->orderBy('tipo','ASC')->get(); 
    }
}