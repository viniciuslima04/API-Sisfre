<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AnteposicaoRequest;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Collection;

use App\Http\Models\Falta;
use App\Http\Models\Semestre;
use App\Http\Models\Anteposicao;
use App\Http\Models\Turma;

class AnteposicaoController extends Controller
{
    private $falta;
    private $anteposicao;
    private $semestre;
    private $turma;

    public function __construct(Falta $falta, Anteposicao $anteposicao, Semestre $semestre, Turma $turma){
        $this->middleware('prof', ['except' => ['show_coordenador', 'cancelar','confirmar']]);
        $this->middleware('coord', ['only' => ['show_coordenador', 'cancelar','confirmar']]);
        $this->falta        = $falta;
        $this->anteposicao  = $anteposicao;
        $this->semestre     = $semestre;
        $this->turma        = $turma;
    }

   public function create(){
        $professor = auth()->user()->professor->id;

        $turmas = DB::table('disciplina')
        ->join('disciplina_professor', 'disciplina.id', '=', 'disciplina_professor.disciplina_id')
        ->join('professor', 'professor.id', '=', 'disciplina_professor.professor_id')
        ->join('turma', 'turma.id', '=', 'disciplina_professor.turma_id')
        ->join('semestre', 'semestre.id', '=', 'turma.semestre_id')
        ->join('usuario', 'usuario.id', '=', 'professor.usuario_id')
        ->select('turma.*')
        ->where([
            ['semestre.status','=', 1],
            ['professor.id','=',$professor]
        ])->orderBy('turma.descricao', 'ASC')->distinct()->get();

        return view('anteposicao.create',compact('turmas'));
    }

    public function store(AnteposicaoRequest $req){
        $turma          = $this->turma->find($req->input('turma'));
        $professor_id   = auth()->user()->professor->id;
        $url            = $this->save_file($req->arquivo, $turma);

        $this->anteposicao->dia             = implode("-", array_reverse(explode("/",$req->input('dia'))));
        $this->anteposicao->situacao        = $req->input('situacao');
        $this->anteposicao->qtd             = $req->input('qtd');
        $this->anteposicao->arquivo         = $url;
        $this->anteposicao->professor_id    = $professor_id;
        $this->anteposicao->disciplina_id   = $req->input('disciplina');
        $this->anteposicao->turma_id        = $req->input('turma');
        $this->anteposicao->gasta           = 0;

        if($req->input('observacao')){
            $this->anteposicao->obs     = mb_strtoupper($req->input('observacao'),'UTF-8');
        }

        $inserido = $this->anteposicao->save();

        if($inserido){
            return redirect()->route('anteposicao.show.professor')
            ->withInput()
            ->with('success','A Anteposição foi registrada com sucesso!');
        }
    }

    public function show_professor(Request $req){
        $professor  = auth()->user()->professor->id;
        $filtro     = $req->get('filtro','');
        $pesquisa   = $req->get('pesquisa','');
        $where      = [ ['professor.id','=',$professor], ['semestre.status','=',1] ];


        if($pesquisa && $filtro){
            $where[] = ['disciplina.nome','LIKE','%'.$pesquisa.'%'];
            $where[] = ['anteposicao.situacao','=',$filtro];
        }
        else if($filtro){
            $where[] = ['anteposicao.situacao','=',$filtro];
        }
        else if($pesquisa){
            $where[] = ['disciplina.nome','LIKE','%'.$pesquisa.'%'];   
        }

        $anteposicoes = self::busca_anteposicoes($where);
        return view('anteposicao.showProfessor',compact('anteposicoes','pesquisa','filtro'));
    }
    
    public function show_coordenador(Request $req){
        $curso = auth()->user()->professor->curso->id;
        $filtro = $req->get('filtro','');
        $pesquisa = $req->get('pesquisa','');
        $where      = [ ['turma.curso_id','=',$curso], ['semestre.status','=',1] ];

        if($pesquisa && $filtro){
            $where[] = ['u.username','LIKE','%'.$pesquisa.'%'];
            $where[] = ['anteposicao.situacao','=',$filtro];
        }
        else if($filtro){
            $where[] = ['anteposicao.situacao','=',$filtro];
        }
        else if($pesquisa){
            $where[] = ['u.username','LIKE','%'.$pesquisa.'%'];  
        }

        $anteposicoes = self::busca_anteposicoes($where);
        return view('anteposicao.showCoordenador',compact('anteposicoes','pesquisa','filtro'));
    }

    public static function busca_anteposicoes($where){
        return DB::table('anteposicao')
                ->join('disciplina', 'disciplina.id', '=', 'anteposicao.disciplina_id')
                ->join('professor', 'professor.id', '=', 'anteposicao.professor_id')
                ->join('turma', 'turma.id', '=', 'anteposicao.turma_id')
                ->join('semestre', 'semestre.id', '=', 'turma.semestre_id')
                ->join('usuario AS u', 'u.id', '=', 'professor.usuario_id')
                ->select('anteposicao.*', 'disciplina.nome AS disciplina','turma.descricao AS turma','u.username AS professor')
                ->where($where)
                ->orderBy('anteposicao.dia','ASC')
                ->paginate(10);  
    }
    public function edit($anteposicao){

        $professor = auth()->user()->professor->id;
        $anteposicao = $this->anteposicao->find($anteposicao);

        $turmas = DB::table('disciplina')
        ->join('disciplina_professor', 'disciplina.id', '=', 'disciplina_professor.disciplina_id')
        ->join('professor', 'professor.id', '=', 'disciplina_professor.professor_id')
        ->join('turma', 'turma.id', '=', 'disciplina_professor.turma_id')
        ->join('semestre', 'semestre.id', '=', 'turma.semestre_id')
        ->join('usuario', 'usuario.id', '=', 'professor.usuario_id')
        ->select('turma.*')
        ->where([
            ['semestre.status','=', 1],
            ['professor.id','=',$professor]
        ])->orderBy('turma.descricao', 'ASC')->distinct()->get();

        $disciplinas = DB::table('disciplina')
        ->join('disciplina_professor', 'disciplina.id', '=', 'disciplina_professor.disciplina_id')
        ->join('professor', 'professor.id', '=', 'disciplina_professor.professor_id')
        ->select('disciplina.*')
        ->where([
            ['disciplina_professor.professor_id','=',$professor],
            ['disciplina_professor.turma_id','=',$anteposicao->turma->id],
        ])->distinct()->orderBy('disciplina.nome', 'ASC')->get();

        return view('anteposicao.edit',compact('turmas','disciplinas','anteposicao'));

    }

    public function update($anteposicao, Request $req){
        $anteposicao = $this->anteposicao->find($anteposicao);
        $url = $anteposicao->arquivo;
        $professor_id   = auth()->user()->professor->id;

        $messages = [
            'arquivo.required'       =>'É necessário selecionar um novo arquivo para efetuar a mudança',
            'arquivo.max'            =>'O tamanho máximo do arquivo deve ser 2MB',
            'arquivo.mimes'          =>'O Arquivo deve está no formato .PDF',
            'qtd.required'           =>'A quantidade de falta é obrigatória',
            'qtd.integer'            =>'A quantidade de falta tem que ser um valor númerico',
            'qtd.min'                =>'Selecione a quantidade de faltas',
            'dia.required'           =>'Informe o dia que a reposição ocorreu',
            'dia.date'               =>'O dia da falta tem que ser uma data válida',
            'turma.required'         =>'Selecione a turma',
            'turma.integer'          =>'A turma tem que ser um valor númerico',
            'turma.min'              =>'Selecione a turma',
            'disciplina.required'    =>'Selecione a disciplina',
            'disciplina.integer'     =>'A disciplina tem que ser um valor númerico',
            'disciplina.min'         =>'Selecione a disciplina'
        ];

        if(empty($req->input('arquivo'))){
            $validador = Validator::make($req->all(),
                [
                    'arquivo'                    => 'required|file|mimes:pdf|max:2048',
                    'qtd'                        => 'required|integer|min:1',
                    'dia'                        => 'required|date',
                    'turma'                      => 'required|integer|min:1',
                    'disciplina'                 => 'required|integer|min:1'
                ], $messages);

            if($validador->fails()){
                return redirect()->route('anteposicao.edit',$anteposicao->id)
                    ->withErrors($validador)
                    ->withInput();
            }

            //remove o antigo arquivo vinculado
            Storage::delete($anteposicao->arquivo);

            //pega o novo arquivo vinculado
            $url = $this->save_file($req->arquivo, $anteposicao->turma);
        }
        else{

            $validador = Validator::make($req->all(),
                [
                    'qtd'                        => 'required|integer|min:1',
                    'dia'                        => 'required|date',
                    'turma'                      => 'required|integer|min:1',
                    'disciplina'                 => 'required|integer|min:1'
                ], $messages);

            if($validador->fails()){
                return redirect()->route('anteposicao.edit',$anteposicao->id)
                    ->withErrors($validador)
                    ->withInput();
            }
        }

        $anteposicao->dia               = implode("-", array_reverse(explode("/",$req->input('dia'))));
        $anteposicao->situacao          = $req->input('situacao');
        $anteposicao->qtd               = $req->input('qtd');
        $anteposicao->arquivo           = $url;
        $anteposicao->professor_id      = $professor_id;
        $anteposicao->disciplina_id     = $req->input('disciplina');
        $anteposicao->turma_id          = $req->input('turma');
        $anteposicao->gasta             = 0;

        if($req->input('observacao')){
            $anteposicao->obs     = mb_strtoupper($req->input('observacao'),'UTF-8');
        }

        $atualizado = $anteposicao->save();

        if($atualizado){
            return redirect()->route('anteposicao.show.professor')
            ->withInput()
            ->with('success','A Anteposição foi atualizada com sucesso!');
        }
    }

    public function confirmar($anteposicao){
        $anteposicao = $this->anteposicao->find($anteposicao);
        $anteposicao->situacao = 'CONF';

        $faltas = $this->falta->where([
            ['situacao','=','CONF'],
            ['professor_id','=',$anteposicao->professor_id],
            ['turma_id','=',$anteposicao->turma_id],
            ['disciplina_id','=',$anteposicao->disciplina_id]
        ])->orWhere([
            ['situacao','=','PAGA_P'],
            ['professor_id','=',$anteposicao->professor_id],
            ['turma_id','=',$anteposicao->turma_id],
            ['disciplina_id','=',$anteposicao->disciplina_id]
        ])->get();

        if($faltas->isNotEmpty()){
            foreach ($faltas as $falta) {
                if($anteposicao->qtd == $anteposicao->gasta){
                    $anteposicao->situacao = 'VENC';
                    break;
                }
                else if($anteposicao->qtd > $anteposicao->gasta){
                    if($falta->situacao == 'CONF'){
                        if($anteposicao->qtd - $anteposicao->gasta >= $falta->qtd){
                            $falta->situacao = 'PAGA_T';
                            $anteposicao->gasta = $anteposicao->gasta + $falta->qtd;
                        }
                        else{
                            $falta->situacao = 'PAGA_P';
                            $anteposicao->gasta = $anteposicao->gasta + 1;
                        }   
                    }
                    else{
                        if($anteposicao->qtd - $anteposicao->gasta >= $falta->qtd){
                            $falta->situacao = 'PAGA_T';
                            $anteposicao->gasta = $anteposicao->gasta + 1;
                        }
                    }

                    $falta->anteposicoes()->attach($anteposicao->id);
                    $falta->save();
                }
            }
        }

        $confirmado = $anteposicao->save();
        
        if($confirmado){
            return redirect()->route('anteposicao.show.coordenador')
            ->withInput()
            ->with('success','A Anteposição foi confirmada com sucesso!');
        }

    }

    public function cancelar($anteposicao){
        $anteposicao            =   $this->anteposicao->find($anteposicao);
        $anteposicao->situacao  =   'NEG';
        $anteposicao->gasta     =   0;
        $save[]                 =   $anteposicao->save(); 
        $faltas                 =   $anteposicao->faltas;

        if($faltas->isNotEmpty()){
            foreach ($faltas as $falta) {
                if($falta->situacao == 'PAGA_T'){
                    if($falta->reposicoes->isEmpty()){
                        $falta->situacao = 'CONF';
                    }
                    else{
                        $falta->situacao = 'PAGA_P';
                    }
                }
                else if($falta->situacao == 'PAGA_P'){

                    $falta->situacao = 'CONF';
                }

                $falta->anteposicoes()->detach($anteposicao->id);
                $save[] = $falta->save();
            }
        } 

        $cancelado = FaltaController::all_save($save,count($save));

        if($cancelado){
            return redirect()->route('anteposicao.show.coordenador')
            ->withInput()
            ->with('success','A Anteposição foi cancelada com sucesso!');
        }
    }

    private function save_file($arquivo, $turma){

        $nomeArquivo = $this->name_file($arquivo->guessClientExtension());
        $caminhoArquivo = $this->path_file($turma);

        return $arquivo->move($caminhoArquivo, $nomeArquivo);
    }

    private function name_file($extension){
        // pega a data e hora atual e transforma em objeto Carbon
        $dataC = Carbon::now('America/Fortaleza');
        return 'anteposicao.'.$dataC->day.'-'.$dataC->month.'-'.$dataC->year.'.'.$dataC->hour.'-'.$dataC->minute.'-'.$dataC->second.'.'.$extension;
    }

    private function path_file($turma){
        return 'arquivos'.DIRECTORY_SEPARATOR.'anteposicao'.DIRECTORY_SEPARATOR.'semestre'.DIRECTORY_SEPARATOR.$turma->semestre->ano.'.'.$turma->semestre->etapa.DIRECTORY_SEPARATOR.$turma->curso->sigla.DIRECTORY_SEPARATOR.$turma->turno.DIRECTORY_SEPARATOR.'S'.$turma->periodo.DIRECTORY_SEPARATOR;
    }

    public function download($anteposicao){
        $anteposicao = $this->anteposicao->find($anteposicao);
        return response()->download(public_path().DIRECTORY_SEPARATOR.$anteposicao->arquivo, $this->name_file('pdf'), array('content-type' => 'application/pdf'));
    }


    public function visualizar($anteposicao){
        $anteposicao = $this->anteposicao->find($anteposicao);
        return response()->file(public_path().DIRECTORY_SEPARATOR.$anteposicao->arquivo, array('content-type' => 'application/pdf'));
    }
    
    /*
        FUNÇÃO ESTÁTICA QUE RETORNA TODAS AS ANTEPOSIÇÕES CONFIRMADAS PARA DETERMINADO PROFESSOR EM DETERMINADA TURMA E DISCIPLINA, OU RETURN UMA COLLECTION VAZIA. POR PADRÃO RECUPERA AS ANTEPOSIÇÕES CONFIRMADAS (ISSO É, AS QUE FORAM ACEITAS E AINDA POSSUEM AULAS A SEREM USADAS POR FALTAS)
    */
    public static function has_anteposicao($professor, $turma, $disciplina, $situacao = 'CONF'){
        return Anteposicao::where([
            ['professor_id','=',$professor],
            ['turma_id','=',$turma],
            ['disciplina_id','=',$disciplina],
            ['situacao','=', $situacao]
        ])->get();
    }

    /*
        FUNÇÃO ESTÁTICA QUE VERIFICA SE UMA FALTA FOI PAGA POR UMA ANTEPOSIÇÃO, RETORNANDO UMA COLLECTION COM A ID DA ANTEPOSIÇÃO E A SITUAÇÃO DA FALTA, OU UMA COLLECTION VAZIA CASO NÃO HAJA ANTEPOSIÇÕES PARA A TURMA
    */

    public static function anteposicao_paga_falta($falta_id){
        $falta = Falta::find($falta_id);

        //RECUPERA OS ID'S DO PROFESSOR, DISCIPLINA E TURMA VINCULADAS A FALTA;
        $professor       = $falta->professor_id;
        $turma           = $falta->turma_id;
        $disciplina      = $falta->disciplina_id;

        $anteposicoes = self::has_anteposicao($professor, $turma, $disciplina);


        if($anteposicoes->isNotEmpty()){

            //recebe a primeira anteposição que pode pagar a falta completamente
            $anteposicao_compl = $anteposicoes->where('qtd','>=',$falta->qtd)->first();

            //recebe a primeira anteposição que pode pagar a falta parcialmente
            $anteposicao_incompl = $anteposicoes->where('qtd','<',$falta->qtd)->first();

            if(!empty($anteposicao_compl)){
                $situacao = 'PAGA_T';
                $anteposicao =  $anteposicao_compl;
                $qtd_paga = 2;
            }
            else{
                $situacao = 'PAGA_P';
                $anteposicao =  $anteposicao_incompl;
                $qtd_paga = 1;
            }

            if($anteposicao->gasta + $qtd_paga == $anteposicao->qtd){
                $anteposicao->situacao = 'VENC';
            }

            $anteposicao->gasta = $anteposicao->gasta + $qtd_paga;

            if($anteposicao->save()){
                return Collection::make(['situacao' => $situacao, 'anteposicao' => $anteposicao->id]);
            }

        }

        return Collection::make();
    }
}