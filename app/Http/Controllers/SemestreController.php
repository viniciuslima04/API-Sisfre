<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SemestreRequest;

use App\Http\Models\Semestre;

class SemestreController extends Controller
{
    private $semestre;
    static  $semestreAtivo;

    public function __construct(Semestre $semestre){
        $this->middleware('admin');
        $this->semestre = $semestre;
    }

    /*
        FUNÇÃO PÚBLICA QUE RETORNA A TELA DE CADASTRO DE SEMESTRE
    */
    public function create(){
        return view('semestre.create');
    }

    /*
        FUNÇÃO PÚBLICA QUE TENTA CADASTRAR UM REGISTRO DE SEMESTRE NO BANCO DE DADOS. CASO CONSIGA COM ÊXITO RETORNA MENSAGEM DE SUCESSO NA TELA DE LISTAGEM DE SEMESTRES, CASO CONTRÁRIO, RETORNA UMA MENSAGEM DE ERRO
    */
    public function store(SemestreRequest $req){
        // RECUPERA ANO ,TIPO E A ETAPA DO SEMESTRE PASSADO PELO USUÁRIO
        $ano    = $req->input('ano');
        $etapa  = $req->input('sem');
        $tipo   = $req->input('tipo');

        // VARIÁVEL PRA UNIR EM UMA STRING O ANO E A ETAPA 
        $semestreFormatado  = $ano.'.'.$etapa.' - '.$tipo;

        /*
            CASO JÁ HAJA UM SEMESTRE COM MESMO ANO E  ETAPA, RETORNA MENSAGEM DE ERRO PRA TELA DE CADASTRO DO SEMESTRE, INFORMANDO AO USUÁRIO.
        */
        if($this->contain($ano, $etapa, $tipo) != NULL){
            return redirect()->route('semestre.create')
            ->withInput()
            ->withErrors([
                'sem'  => 'Já existe um semestre com essa etapa, ano e tipo',
                'ano'  => 'Já existe um semestre com esse ano, etapa e tipo',
                'tipo' => 'Já existe um semestre com esse tipo, etapa e ano',
            ]);
        }

        /*
            É NECESSÁRIO DESATIVAR O SEMESTRE MAIS ATUAL (POIS O QUE ESTÁ PRESTES A SER CADASTRADO DEVERÁ POR PADRÃO SER O ATIVO, CASO DESATIVE COM SUCESSO PROSSEGUE COM O ARMAZENAMENTO NO BANCO.
        */

        if($this->desativar_semestre_mais_atual($tipo)){

            $this->semestre->etapa     = $req->input('sem');
            $this->semestre->ano       = $req->input('ano');
            $this->semestre->inicio    = implode("-", array_reverse(explode("/",$req->input('inicio'))));
            $this->semestre->metade    = implode("-", array_reverse(explode("/",$req->input('meio'))));
            $this->semestre->fim       = implode("-", array_reverse(explode("/",$req->input('fim'))));
            $this->semestre->status    = $req->input('status');
            $this->semestre->tipo      = $req->input('tipo');

            $inserido = $this->semestre->save();

            // SE O SALVAMENTO NO BANCO TIVER OCORRIDO COM ÊXITO, EXIBE MENSAGEM DE SUCESSO
            if($inserido){
                return redirect()->route('semestre.show')
                ->withInput()
                ->with('success','O Semestre: '.$semestreFormatado.' foi cadastrado com sucesso!');
            }
        }

        // CASO OCORRA ALGUM ERRO NO DECORRER, EXIBE MENSAGEM DE INSUCESSO.

        return redirect()->route('semestre.show')
        ->withInput()
        ->with('error','Não foi possível cadastrar o semestre: '.$semestreFormatado);   

    }

    /*
        FUNÇÃO PÚBLICA QUE RETORNA A TELA DE LISTAGEM, 
        EM CASO DE BUSCA ELA FILTRA OS SEMESTRES, CASO CONTRÁRIO EXIBE TODOS
    */
    public function show(Request $req){

        //RECEBE O FILTRO E JOGA NA VARIÁVEL, CASO EXISTA, SENÃO FICA VAZIA
        $pesquisa = $req->get('pesquisa','');
        $filtro = $req->get('filtro','');

        //CASO NÃO ESTEJA VAZIA, RETORNA OS SEMESTRES QUE ATENDEM A PESQUISA
        if($pesquisa && $filtro ){
          $where[] = ['ano','=',$pesquisa];
          $where[] = ['status','=', $req->get('filtro')];
        }
        else if($pesquisa){
          $where[] = ['ano','=',$pesquisa];  
        }
        else if($filtro){
            $where[] = ['status','=', $filtro]; 
        }
        else{
            $where = NULL;
        }

        $semestres = self::busca_semestres($where);
        return view('semestre.show',compact('semestres','pesquisa','filtro'));
    }

    public static function busca_semestres($where){
        if(!empty($where)){
            return Semestre::where($where)->orderBy('ano','DESC')->orderBy('etapa','DESC')->orderBy('tipo','ASC')->paginate(10); 
        }

        return Semestre::where('status','=',1)->orWhere('status','=',2)->orderBy('ano','DESC')->orderBy('etapa','DESC')->orderBy('tipo','ASC')->paginate(10); 
    }

    /*
        FUNÇÃO PÚBLICA QUE RETORNA O FORMULÁRIO DE EDIÇÃO DO REGISTRO DE SEMESTRE PASSADO COMO PARÂMETRO
    */
    public function edit($semestre){
        $semestreEdit = $this->semestre->find($semestre);
        return view('semestre.edit', compact('semestreEdit'));
    }

    /*
        FUNÇÃO PÚBLICA QUE TENTA ATUALIZAR UM REGISTRO DE SEMESTRE PASSADO COMO PARÂMETRO. CASO CONSIGA COM ÊXITO RETORNA MENSAGEM DE SUCESSO NA TELA DE LISTAGEM DE SEMESTRES, CASO CONTRÁRIO, RETORNA UMA MENSAGEM DE ERRO
    */

    public function update($semestre,SemestreRequest $req){

        $semestreUpdate = $this->semestre->find($semestre);
        $situacao = true;

        // RECUPERA ANO ,TIPO E A ETAPA DO SEMESTRE RECUPERADO
        $ano    = $req->input('ano');
        $etapa  = $req->input('sem');
        $tipo   = $req->input('tipo');

        // VARIÁVEL PRA UNIR EM UMA STRING O ANO E A ETAPA 
        $semestreFormatado  = $ano.'.'.$etapa.' - '.$tipo;

        /*
            CASO O USUÁRIO TENHA ALTERADO A SITUAÇÃO DO SEMESTRE PARA ATIVO/DESATIVADO
            SE HOUVER MUDADO VERIFICA SE ALTEROU PRA DESATIVADO OU ATIVADO
        */
        if($semestreUpdate->status != $req->input('status')){
            
            // CASO TENHA ATIVADO, ISSO IMPLICA DIZER QUE HÁ UM SEMESTRE MAIS ATUAL, E ELE PRECISA SER DESATIVADO, POIS SÓ HÁ UM SEMESTRE ATIVO NO SISTEMA
            if($req->input('status') == 1){
                $situacao = $this->desativar_semestre_mais_atual($tipo);
            }
        }

        // CASO TENHA ATIVADO/DESATIVADO COM SUCESSO O SEMESTRE MAIS ATUAL, PROSSEGUE COM A ATUALIZAÇÃO
        if($situacao == true){

            $semestreUpdate->etapa     = $req->input('sem');
            $semestreUpdate->ano       = $req->input('ano');
            $semestreUpdate->inicio    = implode("-", array_reverse(explode("/",$req->input('inicio'))));
            $semestreUpdate->metade    = implode("-", array_reverse(explode("/",$req->input('meio'))));
            $semestreUpdate->fim       = implode("-", array_reverse(explode("/",$req->input('fim'))));
            $semestreUpdate->status    = $req->input('status');
            
            // SALVA AS MUDANÇAS NO REGISTRO
            $atualizado = $semestreUpdate->save();

            //CASO O SALVAMENTO TENHA OCORRIDO COM ÊXITO, EXIBE MENSAGEM DE SUCESSO NA LISTAGEM DE SEMESTRES
            if($atualizado){
                return redirect()->route('semestre.show')
                ->withInput()
                ->with('success','O Semestre: '.$semestreFormatado.' foi atualizado com sucesso!');
            }
        }

        // CASO DE ERRO EM ALGUM MOMENTO , EXIBE MENSAGEM DE INSUCESSO NA LISTAGEM DE SEMESTRES
        return redirect()->route('semestre.show')
        ->withInput()
        ->with('error','Não foi possível alterar o semestre: '.$semestreFormatado);  

    }

    /*
        FUNÇÃO PÚBLICA QUE RETORNA UMA MENSAGEM DE CONFIRMAÇÃO NA TELA DE LISTAGEM DE SEMESTRES CASO A REMOÇÃO TENHA OCORRIDO COM SUCESSO E UMA MENSAGEM DE ERRO CASO CONTRÁRIO.
    */

    public function delete($semestre){
        // RECUPERA O SEMESTRE A SER REMOVIDO, UTILIZANDO O ID PASSADO COMO PARÂMETRO
        $semestreDelete     = $this->semestre->find($semestre);

        // VARIÁVEL PRA UNIR EM UMA STRING O ANO E A ETAPA 
        $semestreFormatado  = $semestreDelete->ano.'.'.$semestreDelete->etapa.' - '.$semestreDelete->tipo;

        // VERIFICA QUANTOS SEMESTRES EXISTEM CADASTRADOS NO SISTEMA (SEM CONTAR O QUE ESTÁ A SER REMOVIDO) E ARMAZENA NA VARIÁVEL
        $qtdSemestres       = $this->semestre->where('id','!=',$semestre)->count();
        
        /* 
            CASO HAJA 1 OU MAIS SEMESTRES ALÉM DO QUE ESTÁ PRESTES A SER REMOVIDO NO SISTEMA 
            TENTA ATIVAR O SEMESTRE MAIS ATUAL
        */
        if($qtdSemestres >= 1){
            /* 
                SE FALHAR AO TENTAR ATIVAR O SEMESTRE MAIS ATUAL, RETORNA MENSAGEM DE ERRO, DIZENDO QUE NÃO FOI POSSÍVEL REMOVER. 
            */
            if($this->ativar_semestre_mais_atual($semestreDelete->id, $semestreDelete->tipo) == false){
                return redirect()->route('semestre.show')
                ->withInput()
                ->with('error','Não foi possível remover o semestre: '.$semestreFormatado);  
            }   
        }
        /* 
            CASO NÃO HAJA, É PORQUE SÓ EXISTE ELE, ENTÃO NÃO PRECISAR ATIVAR NENHUM SEMESTRE E SÓ REMOVE O PASSADO COMO PARÂMETRO
        */
        $removido = $semestreDelete->delete();

        // CASO A REMOÇÃO TENHA OCORRIDO COM SUCESSO RETORNA MENSAGEM INFORMANDO
        if($removido){
            return redirect()->route('semestre.show')
            ->withInput()
            ->with('success','O Semestre: '.$semestreFormatado.' foi removido com sucesso!');
        }
        //CASO CONTRÁRIO MENSAGEM DE ERRO
        else{
            return redirect()->route('semestre.show')
            ->withInput()
            ->with('error','Não foi possível remover o semestre: '.$semestreFormatado);   
        }
    }

    /*
        FUNÇÃO PRIVADA QUE RETORNA TRUE CASO A DESATIVAÇÃO DO SEMESTRE MAIS ATUAL OCORRA COM SUCESSO
        E FALSE CASO CONTRÁRIO.
    */

    private function desativar_semestre_mais_atual($tipo){
        //RECUPERA O SEMESTRE ATUALMENTE ATIVO
        $semestreAtual = self::semestre_ativo(false, $tipo);

        // SE NÃO EXISTIR UM SEMESTRE ATIVO RETORNA TRUE
        if(empty($semestreAtual)){
            return true;
        }
        // CASO EXISTA, DESATIVA-O (MUDANDO SEU STATUS DE 1 PARA 2) E SALVA AS MUDANÇAS
        $semestreAtual->status = "2";
        $semestreDesativado = $semestreAtual->save();

        // RETORNA TRUE CASO O SALVAMENTO TENHA OCORRIDO DE FORMA CORRETA E FALSE CASO CONTRÁRIO
        return $semestreDesativado;  
    }

    /*
        FUNÇÃO PRIVADA QUE RETORNA TRUE CASO A ATIVAÇÃO DO SEMESTRE MAIS ATUAL SEJA FEITA COM SUCESSO
        OU NÃO TENHA UM SEMESTRE MAIS ATUAL E FALSE CASO CONTRÁRIO.
    */

    private function ativar_semestre_mais_atual($semestre, $tipo){

        //RECUPERA O ANO DO SEMESTRE CADASTRADO MAIS ATUAL DAQUELE TIPO (IGNORANDO O SEMESTRE PASSADO COMO PARÂMETRO)
        $anoSemestreAnt     = $this->semestre->where([
            ['id','!=',$semestre],
            ['tipo','=', $tipo]
        ])->max('ano');
        
        /*
            RECUPERA A ETAPA DO SEMESTRE CADASTRADO MAIS ATUAL (IGNORANDO O SEMESTRE PASSADO COMO PARÂMETRO).
            USANDO O ANO DO SEMESTRE MAIS ATUAL RECUPERADO.
        */
        $etapaSemestreAnt   = $this->semestre->where([
            ['ano','=',$anoSemestreAnt],
            ['id','!=',$semestre],
            ['tipo','=',$tipo]
        ])->max('etapa');

        // COM O ANO E A ETAPA, VERIFICA SE EXISTE REALMENTE UM SEMESTRE COM ESSAS INFORMAÇÕES
        $semestreAnterior = $this->contain($anoSemestreAnt, $etapaSemestreAnt, $tipo);
        
        // SE NÃO EXISTIR RETORNA TRUE, POIS NÃO PRECISA
        if($semestreAnterior == NULL){
            return true;
        }

        // CASO EXISTA, ATIVA O SEMESTRE (MUDANÇA DO STATUS = 2 PARA STATUS = 1)
        $semestreAnterior->status = "1";

        // SALVA A ATUALIZAÇÃO NO SEMESTRE MAIS ATUAL ENCONTRADO
        $semestreAtivado = $semestreAnterior->save();

        // RETORNA TRUE CASO O SALVAMENTO TENHA OCORRIDO COM SUCESSO E FALSE CASO CONTRÁRIO.
        return $semestreAtivado; 
    }

    /*
        FUNÇÃO PRIVADA QUE RETORNA SE HÁ SEMESTRE CADASTRADO USANDO
        O ANO E A ETAPA PASSADAS NO PARÂMETRO. RETORNA O SEMESTRE SE HOUVER
        E NULL CASO CONTRÁRIO.
    */

    private function contain($ano, $etapa, $tipo){
        $semestre = $this->semestre->where([
            ['ano','=',$ano],
            ['etapa','=',$etapa],
            ['tipo','=',$tipo]
        ])->first();

        if(empty($semestre)){
            return NULL;
        }

        return $semestre;
    }

    /*
        FUNÇÃO ESTÁTICA QUE RETORNA O ID DO SEMESTRE ATIVO DO SISTEMA POR PADRÃO, CASO SEJA PASSADO UM VALOR FALSE
        NO PARÂMETRO RETORNA O SEMESTRE ATUALMENTE ATIVO. E NULL CASO NÃO TENHA SEMESTRE ATIVO
    */
    public static function semestre_ativo($id = true, $tipo){
        // PEGA O ID DO SEMESTRE ATUALMENTE ATIVO
        $semestreAtivo = Semestre::where([
            ['status', '=','1'],
            ['tipo', '=', $tipo]
        ])->pluck('id')->first();
        
        // VERIFICA SE HÁ VALOR DE ID PARA O SEMESTRE ATUALMENTE ATIVO
        if(!empty($semestreAtivo)){
            // VERIFICA SE A VARIÁVEL DE PARÂMETRO POSSUI O VALOR PADRÃO, CASO SIM, RETORNA O ID DO SEMESTRE ATUALMENTE ATIVO
            if($id){
                return $semestreAtivo;
            }
            // CASO CONTRÁRIO RETORNA O SEMESTRE ATUALMENTE ATIVO
            else{
                return $semestreAtivo = Semestre::find($semestreAtivo);
            }
        }
        // RETORNA NULL CASO NÃO HAJA UM SEMESTRE ATIVO ATUALMENTE
        return $semestreAtivo = NULL;
    }

}