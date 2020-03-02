<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\FeriadoRequest;

use Illuminate\Support\Facades\Validator;

use App\Http\Models\Feriado;

class FeriadoController extends Controller
{
    private $feriado;

    public function __construct(Feriado $feriado){
        $this->middleware('admin');
        $this->feriado      = $feriado;
    }

    public function create(){
        return view('feriado.create');
    }

    public function store(FeriadoRequest $req){
        $anoCorrente = Carbon::now('America/Fortaleza')->year;
        $qtd_feriado = $this->feriado->where('nome','=',mb_strtoupper($req->input('nome'),'UTF-8'))->whereYear('data',$anoCorrente)->count();

        if($req->input('tipo') == 2 || $req->input('tipo') == 3){
            $messages = [
                'fim.date'      =>'O dia do término do(a) recesso/férias deve ser uma data válida',
                'fim.after'     =>'O dia do término do(a) recesso/férias deve ser posterior a data de inicio do mesmo'
            ];

            $validador = Validator::make($req->all(),
                [
                    'fim'                     => 'date|after:inicio'
                ], $messages);

            if($validador->fails()){
                return redirect()->route('feriado.create')
                    ->withErrors($validador)
                    ->withInput();
            }
            $this->feriado->final       =   implode("-", array_reverse(explode("/",$req->input('fim'))));
        }

        if($qtd_feriado > 0){
            return redirect()->route('feriado.create')
                ->withErrors(['nome'=> 'Já existe um feriado com esse nome, nesse ano. Edite-o!!'])
                ->withInput();
        }

       $this->feriado->data         =   implode("-", array_reverse(explode("/",$req->input('inicio'))));
       $this->feriado->nome         =   mb_strtoupper($req->input('nome'),'UTF-8');
       $this->feriado->tipo         =   $req->input('tipo');

       $inserido = $this->feriado->save();

        if($inserido){
            return redirect()->route('feriado.show')
            ->withInput()
            ->with('success','O feriado: '.mb_strtoupper($req->input('nome'),'UTF-8').' foi cadastrado com sucesso!');
        }
    }

    public function edit($feriado){
        $feriado = $this->feriado->find($feriado);
        return view('feriado.edit',compact('feriado'));
    }

    public function update($feriado, Request $req){
        $anoCorrente = Carbon::now('America/Fortaleza')->year;
        $qtd_feriado = $this->feriado->where('nome','=',mb_strtoupper($req->input('nome'),'UTF-8'))->whereYear('data',$anoCorrente)->count();

        $feriado = $this->feriado->find($feriado);

        if($req->input('tipo') == 2 || $req->input('tipo') == 3){
            $messages = [
                'fim.date'      =>'O dia do término do(a) recesso/férias deve ser uma data válida',
                'fim.after'     =>'O dia do término do(a) recesso/férias deve ser posterior a data de inicio do mesmo'
            ];

            $validador = Validator::make($req->all(),
                [
                    'fim'                     => 'date|after:inicio'
                ], $messages);

            if($validador->fails()){
                return redirect()->route('feriado.create')
                    ->withErrors($validador)
                    ->withInput();
            }
            $feriado->final         =   implode("-", array_reverse(explode("/",$req->input('fim'))));
        }
        else{
            $feriado->final         =   null ;
        }

        if($qtd_feriado > 0 && $feriado->nome != mb_strtoupper($req->input('nome'),'UTF-8') ){
            return redirect()->route('feriado.edit')
                ->withErrors(['nome'=> 'Já existe um feriado com esse nome, nesse ano. Edite-o!!'])
                ->withInput();
        }

       $feriado->data           =   implode("-", array_reverse(explode("/",$req->input('inicio'))));
       $feriado->nome           =   mb_strtoupper($req->input('nome'),'UTF-8');
       $feriado->tipo           =   $req->input('tipo');

       $atualizado = $feriado->save();

        if($atualizado){
            return redirect()->route('feriado.show')
            ->withInput()
            ->with('success','O feriado: '.mb_strtoupper($req->input('nome'),'UTF-8').' foi atualizado com sucesso!');
        }
    }

    public function show(Request $req){
        $pesquisa = $req->get('pesquisa','');
        $hoje = Carbon::now('America/Fortaleza');
        
        if($pesquisa){

            $feriados = $this->feriado->where('nome','LIKE','%'.$pesquisa.'%')->whereYear('data','>=',$hoje->year)->orderBy('nome','ASC')->paginate(10);
        }
        else{
            $feriados = $this->feriado->whereYear('data','>=',$hoje->year)->orderBy('data','ASC')->paginate(10);
        }

         return view('feriado.show',compact('feriados','pesquisa'));
    }

    public function delete($feriado){
        $feriado = $this->feriado->find($feriado);
        $nome = $feriado->nome;

        $removido = $feriado->delete();

        if($removido){
            return redirect()->route('feriado.show')
            ->withInput()
            ->with('success','O feriado: '.$nome.' foi removido com sucesso!');
        }
    }
}