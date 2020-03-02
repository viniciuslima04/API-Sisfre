<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReposicaoRequest;

use App\Http\Models\Falta;
use App\Http\Models\Reposicao;
use App\Http\Models\Semestre;
use App\Http\Models\Turma;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ReposicaoController extends Controller
{
    private $falta;
    private $reposicao;
    private $semestre;
    private $turma;

    public function __construct(Falta $falta, Reposicao $reposicao, Semestre $semestre, Turma $turma){
        $this->middleware('prof', ['except' => ['show_coordenador', 'cancelar','confirmar']]);
        $this->middleware('coord', ['only' => ['show_coordenador', 'cancelar','confirmar']]);
        $this->falta      = $falta;
        $this->reposicao  = $reposicao;
        $this->semestre   = $semestre;
        $this->turma      = $turma;
    }

    public function create($usuario, $falta){
        $usuario = $usuario;
        $falta = $this->falta->find($falta);
        $semestreAtivo = Semestre::find($falta->turma->semestre_id);
        $qtd_repor = 1;
        $validade = FaltaController::soma_dias($falta->validade,1);

        if($falta->situacao == 'CONF' && $falta->reposicoes->where('situacao','=','ESP')->isEmpty()){
            $qtd_repor = $falta->qtd;
        }
        else if($falta->situacao == 'VENC'){

            //A FALTA ERA CONF E NÃO TINHA NADA AGENDADO PRA REPOR ELA
            if($falta->reposicoes->where('situacao','=','ESP')->isEmpty() && $falta->anteposicoes->isEmpty() ){
                $qtd_repor = $falta->qtd;
            }

            $dataAtual      = date('Y-m-d',strtotime(Carbon::now('America/Fortaleza') ) );
            $novaValidade   = FaltaController::soma_dias_uteis($dataAtual,1);
            $validade       = FaltaController::soma_dias($novaValidade,1);
        }

        return view('reposicao.create',compact('falta','qtd_repor','validade','usuario'));
    }

    public function store(ReposicaoRequest $req){
        $falta          = $this->falta->find(request()->falta);
        $url            = $this->save_file($req->arquivo, $falta->turma);
        $usuario        = mb_strtoupper($req->input('usuario'),'UTF-8');
        $validade       = FaltaController::soma_dias($req->input('validade'),-1);

        if($validade != $falta->validade && $falta->situacao == 'VENC'){
            $falta->validade = $validade;
            $falta->situacao = 'CONF';
            $save[] = $falta->save();
        } 

        $this->reposicao->dia       = implode("-", array_reverse(explode("/",$req->input('dia'))));
        $this->reposicao->situacao  = $req->input('situacao');
        $this->reposicao->qtd       = $req->input('qtd');
        $this->reposicao->arquivo   = $url;
        $this->reposicao->falta_id  = $falta->id;
        $this->reposicao->usuario   = $usuario;

        if($req->input('observacao')){
            $this->reposicao->obs     = mb_strtoupper($req->input('observacao'),'UTF-8');
        }

        $save[] = $this->reposicao->save();

        $inserido = FaltaController::all_save($save, count($save));

        if($inserido && $usuario == 'PROFESSOR'){
            return redirect()->route('reposicao.show.professor')
            ->withInput()
            ->with('success','A Reposição foi registrada com sucesso!');
        }
        else if($inserido && $usuario == 'COORDENADOR'){
            return redirect()->route('reposicao.show.coordenador')
            ->withInput()
            ->with('success','A Reposição foi registrada com sucesso!');   
        }
    }

    public function show_professor(Request $req){
        $professor = auth()->user()->professor->id;
        $filtro = $req->get('filtro','');
        $pesquisa = $req->get('pesquisa','');
        $where      = [
                        ['professor.id','=',$professor],
                        ['semestre.status','=',1],
                      ];

        if($pesquisa && $filtro){
            $where[] = ['disciplina.nome','LIKE','%'.$pesquisa.'%'];
            $where[] = ['reposicao.situacao','=',$filtro];
        }
        else if($filtro){
            $where[] = ['reposicao.situacao','=',$filtro];
        }
        else if($pesquisa){
            $where[] = ['disciplina.nome','LIKE','%'.$pesquisa.'%'];
        }

        $reposicoes = $this->busca_reposicoes($where);

        return view('reposicao.showProfessor',compact('reposicoes','pesquisa','filtro'));
    }
    
    public function show_coordenador(Request $req){
        $curso = auth()->user()->professor->curso->id;
        $filtro = $req->get('filtro','');
        $pesquisa = $req->get('pesquisa','');
        $where      = [
                        ['turma.curso_id','=',$curso],
                        ['semestre.status','=',1],
                      ];
        
        if($pesquisa && $filtro){

            $where[] = ['u.username','LIKE','%'.$pesquisa.'%'];
            $where[] = ['reposicao.situacao','=',$filtro];
        }
        else if($filtro){
            $where[] = ['reposicao.situacao','=',$filtro];
        }
        else if($pesquisa){
            $where[] = ['u.username','LIKE','%'.$pesquisa.'%'];   
        }

        $reposicoes = $this->busca_reposicoes($where);
        
        return view('reposicao.showCoordenador',compact('reposicoes','pesquisa','filtro'));
    }

    public function edit($usuario, $reposicao){
        $usuario = $usuario;
        $reposicao = $this->reposicao->find($reposicao);
        $falta = $this->falta->find($reposicao->falta->id);
        $semestreAtivo  = Semestre::find($falta->turma->semestre_id);
        $qtd_repor = 1;

        $validade = FaltaController::soma_dias($reposicao->falta->validade,1);

        if($falta->situacao == 'CONF' && $falta->reposicoes->where('situacao','=','ESP')->where('id','!=',$reposicao->id)->isEmpty()){
            $qtd_repor = $falta->qtd;
        }
        else if($falta->situacao == 'VENC'){

            //A FALTA ERA CONF E NÃO TINHA NADA AGENDADO PRA REPOR ELA
            if($falta->reposicoes->where('situacao','=','ESP')->where('id','!=',$reposicao->id)->isEmpty() && $falta->anteposicoes->isEmpty() ){
                $qtd_repor = $falta->qtd;
            }

            $dataAtual      = date('Y-m-d',strtotime(Carbon::now('America/Fortaleza') ) );
            $novaValidade   = FaltaController::soma_dias_uteis($dataAtual,1);
            $validade       = FaltaController::soma_dias($novaValidade,1);
        }

        return view('reposicao.edit',compact('reposicao','qtd_repor','validade','usuario'));
    }

    public function update(Request $req){
        $reposicao  = $this->reposicao->find(request()->reposicao);
        $falta      = $this->falta->find($reposicao->falta->id);
        $turma      = $this->turma->find($falta->turma_id);
        $url        = $reposicao->arquivo;
        $validade   = FaltaController::soma_dias($req->input('validade'),-1);

        if($validade != $falta->validade && $falta->situacao == 'VENC'){
            $falta->validade = $validade;
            $falta->situacao = 'CONF';
            $save[] = $falta->save();
        } 

        $messages = [
            'arquivo.required'       =>'É necessário selecionar um novo arquivo para efetuar a mudança',
            'arquivo.max'            =>'O tamanho máximo do arquivo deve ser 2MB',
            'arquivo.mimes'          =>'O Arquivo deve está no formato .PDF',
            'qtd.required'           =>'A quantidade de falta é obrigatória',
            'qtd.integer'            =>'A quantidade de falta tem que ser um valor númerico',
            'qtd.min'                =>'Selecione a quantidade de faltas',
            'dia.required'           =>'Informe o dia que a reposição ocorreu',
            'dia.date'               =>'O dia da falta tem que ser uma data válida',
            'dia.after'              =>'A data da reposição deve ser posterior a data da falta',
            'dia.before'             =>'A data da reposição deve ser anterior a data limite para reposição da falta'
        ];
       
        if(empty($req->input('arquivo'))){
            $validador = Validator::make($req->all(),
                [
                    'qtd'                        => 'required|integer|min:1',
                    'dia'                        => 'required|date|after:falta|before:validade',
                    'arquivo'                    => 'required|file|mimes:pdf|max:2048'
                ], $messages);


            if($validador->fails() && $reposicao->usuario == 'PROFESSOR'){

                return redirect()->route('reposicao.edit',['professor', $reposicao->id])
                    ->withErrors($validador)
                    ->withInput();
            }
            else if($validador->fails() && $reposicao->usuario == 'COORDENADOR'){

                return redirect()->route('reposicao.edit',['coordenador', $reposicao->id])
                    ->withErrors($validador)
                    ->withInput();
            }

            //remove o antigo arquivo vinculado
            Storage::delete($reposicao->arquivo);

            //pega o novo arquivo vinculado
            $url = $this->save_file($req->arquivo, $turma);
        }
        else{
                $validador = Validator::make($req->all(),
                    [
                        'qtd'                        => 'required|integer|min:1',
                        'dia'                        => 'required|date|after:falta|before:validade'
                    ], $messages);

                if($validador->fails() && $reposicao->usuario == 'PROFESSOR'){

                    return redirect()->route('reposicao.edit',['professor', $reposicao->id])
                        ->withErrors($validador)
                        ->withInput();
                }
                else if($validador->fails() && $reposicao->usuario == 'COORDENADOR'){

                    return redirect()->route('reposicao.edit',['coordenador', $reposicao->id])
                        ->withErrors($validador)
                        ->withInput();
                }
            }

        $usuario              = mb_strtoupper($req->input('usuario'),'UTF-8');

        $reposicao->dia       = implode("-", array_reverse(explode("/",$req->input('dia'))));
        $reposicao->situacao  = $req->input('situacao');
        $reposicao->qtd       = $req->input('qtd');
        $reposicao->arquivo   = $url;
        $reposicao->falta_id  = $falta->id;
        $reposicao->usuario   = $usuario;

        if($req->input('observacao')){
            $reposicao->obs     = mb_strtoupper($req->input('observacao'),'UTF-8');
        }

        $save[]         = $reposicao->save();
        $atualizado     = FaltaController::all_save($save,count($save));

        if($atualizado && $usuario == 'PROFESSOR'){
            return redirect()->route('reposicao.show.professor')
            ->withInput()
            ->with('success','A Reposição foi atualizada com sucesso!');
        }
        else if($atualizado && $usuario == 'COORDENADOR'){
            return redirect()->route('reposicao.show.coordenador')
            ->withInput()
            ->with('success','A Reposição foi atualizada com sucesso!');   
        }
    }

    public function confirmar($reposicao){
        $reposicao = $this->reposicao->find($reposicao);
        $falta = $this->falta->find($reposicao->falta->id);
        $reposicao->situacao = "CONF";


        switch ($falta->situacao) {
            case 'CONF':
                if($reposicao->qtd == $falta->qtd) {
                    $falta->situacao = 'PAGA_T';
                }
                else{
                    $falta->situacao = 'PAGA_P';  
                }
                break;
            
            case 'PAGA_P':
                if($reposicao->qtd == 1) {
                    $falta->situacao = 'PAGA_T';
                } 
                break;
        }

        $confirmado[] = $falta->save();
        $confirmado[] = $reposicao->save();
        
        if($confirmado[0] && $confirmado[1]){
            return redirect()->route('reposicao.show.coordenador')
            ->withInput()
            ->with('success','A Reposição foi confirmada com sucesso!');
        }

    }

    public function cancelar($reposicao){
        $reposicao             = $this->reposicao->find($reposicao);
        $situacaoReposicao     = $reposicao->situacao;
        $reposicao->situacao   = "NEG";
        $cancelado[]           = $reposicao->save();
        //RECUPERA AS INFORMAÇÕES DA FALTA VINCULADA A REPOSIÇÃO
        $falta = $this->falta->find($reposicao->falta->id);


        // CASO A REPOSIÇÃO ESTEJA SENDO UTILIZADA PARA PAGAR UM REGISTRO DE FALTA
        if($situacaoReposicao == 'CONF'){

            //REALIZA UMA AÇÃO DEPENDENDO DA SITUAÇÃO DA FALTA VINCULADA
            switch ($falta->situacao) {
                //CASO ELA ESTEJA TOTALMENTE PAGA
                case 'PAGA_T':
                    /*
                        SE ELA NÃO TEM ANTEPOSIÇÃO VINCULADA INDICA DIZER QUE ELA FOI TOTALMENTE PAGA POR REPOSIÇÃO
                    */
                    if($falta->anteposicoes->isEmpty()){
                        //CASO A REPOSIÇÃO TENHA A MESMA QUANTIDADE DE AULAS DA FALTA PAGA, FOI ELA QUE PAGOU TOTALMENTE, LOGO A FALTA VOLTA A SUA SITUAÇÃO INICIAL
                        if($reposicao->qtd == $falta->qtd){
                            $situacaoCancelar = 'CONF';
                        }
                        else{
                            $situacaoCancelar = 'PAGA_P'; 
                        }

                    }
                    //CASO EXISTA ANTEPOSIÇÃO, ESSA REPOSIÇÃO PAGOU ELA PARCIALMENTE, E ELA VOLTA PARA SUA SITUAÇÃO ANTERIOR "PAGA_P"
                    else{
                        $situacaoCancelar = 'PAGA_P';
                    }    
                break;
                //CASO A FALTA ESTEJA PARCIALMENTE PAGA, OBRIGATORIAMENTE FOI ESSA REPOSIÇÃO QUE A PAGOU
                case 'PAGA_P':
                    $situacaoCancelar = 'CONF';
                break;
            }

            //RECUPERA A SITUAÇÃO DA FALTA E O ID DA ANTEPOSIÇÃO , CASO UMA ANTEPOSIÇÃO PAGUE-A.
            $paga = AnteposicaoController::anteposicao_paga_falta($falta->id);

            if($paga->isNotEmpty()){
                $situacaoPaga = $paga['situacao'];
                $falta->anteposicoes()->attach($paga['anteposicao']);
                $cancelado[]  = $falta->save();

                if($cancelado[0] && $cancelado[1]){

                    return redirect()->route('reposicao.show.coordenador')
                    ->withInput()
                    ->with('success','A Reposição foi cancelada com sucesso! A situação da falta iria mudar para:'.FaltaController::situacao($situacaoCancelar). ' .Mas havia uma anteposição que a deixou: '.FaltaController::situacao($situacaoPaga));
                }
            }

            $falta->situacao       = $situacaoCancelar;
            $cancelado[]           = $falta->save();

            if($cancelado[0] && $cancelado[1]){
                return redirect()->route('reposicao.show.coordenador')
                ->withInput()
                ->with('success','A Reposição foi cancelada com sucesso!A situação da falta vinculada mudou para:'.FaltaController::situacao($situacaoCancelar));
            }

        }

        // SE ELA TIVER NO MODO "ESP", É O MODO PADRÃO, SÓ MUDA A SITUAÇÃO PARA "NEG", JÁ QUE AINDA NÃO HÁ UMA FALTA ASSOCIADA.

        if($cancelado[0]){
            return redirect()->route('reposicao.show.coordenador')
            ->withInput()
            ->with('success','A Reposição foi cancelada com sucesso!');
        }

    }

    private function busca_reposicoes($where){
        return DB::table('reposicao')
            ->join('falta', 'falta.id', '=', 'reposicao.falta_id')
            ->join('disciplina', 'disciplina.id', '=', 'falta.disciplina_id')
            ->join('professor', 'professor.id', '=', 'falta.professor_id')
            ->join('turma', 'turma.id', '=', 'falta.turma_id')
            ->join('semestre', 'semestre.id', '=', 'turma.semestre_id')
            ->join('usuario AS u', 'u.id', '=', 'professor.usuario_id')
            ->select('reposicao.*', 'disciplina.nome AS disciplina','turma.descricao AS turma','u.username AS professor')
            ->where($where)
            ->orderBy('reposicao.dia','ASC')
            ->paginate(10);
    }

    public function save_file($arquivo, $turma){

        $nomeArquivo = $this->name_file($arquivo->guessClientExtension());
        $caminhoArquivo = $this->path_file($turma);

        return $arquivo->move($caminhoArquivo, $nomeArquivo);
    }

    public function name_file($extension){
        // pega a data e hora atual e transforma em objeto Carbon
        $dataC = Carbon::now('America/Fortaleza');
        return 'reposicao.'.$dataC->day.'-'.$dataC->month.'-'.$dataC->year.'.'.$dataC->hour.'-'.$dataC->minute.'-'.$dataC->second.'.'.$extension;
    }

    public function path_file($turma){
        return 'arquivos'.DIRECTORY_SEPARATOR.'reposicao'.DIRECTORY_SEPARATOR.'semestre'.DIRECTORY_SEPARATOR.$turma->semestre->ano.'.'.$turma->semestre->etapa.DIRECTORY_SEPARATOR.$turma->curso->sigla.DIRECTORY_SEPARATOR.$turma->turno.DIRECTORY_SEPARATOR.'S'.$turma->periodo.DIRECTORY_SEPARATOR;
    }

    public function download($reposicao){
        $reposicao = $this->reposicao->find($reposicao);
        return response()->download(public_path().DIRECTORY_SEPARATOR.$reposicao->arquivo, $this->name_file('pdf'), array('content-type' => 'application/pdf'));
    }

    public function visualizar($reposicao){
        $reposicao = $this->reposicao->find($reposicao);
        return response()->file(public_path().DIRECTORY_SEPARATOR.$reposicao->arquivo, array('content-type' => 'application/pdf'));
    }
}