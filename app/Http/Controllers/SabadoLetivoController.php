<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\SabadoRequest;

use App\Http\Models\SabadoLetivo;

class SabadoLetivoController extends Controller
{
    private $sabadoLetivo;

    public function __construct(SabadoLetivo $sabado){
        $this->middleware('admin');
        $this->sabadoLetivo     = $sabado;
    }

    public function create(){

        return view('sabadoLetivo.create');

    }

    public function store(SabadoRequest $req){
        $this->sabadoLetivo->data         =   implode("-", array_reverse(explode("/",$req->input('inicio'))));
        $this->sabadoLetivo->referente    =   mb_strtoupper($req->input('tipo'),'UTF-8');


        $inserido = $this->sabadoLetivo->save();

        $dataBr = implode("/", array_reverse(explode("-",$req->input('inicio'))));
        if($inserido){
            return redirect()->route('sabado.show')
            ->withInput()
            ->with('success','O Sábado letivo referente a: '. mb_strtoupper($req->input('tipo'),'UTF-8').' foi cadastrado com sucesso para o dia: '.$dataBr);
        }
    }

    public function edit($sabado){
        $sabado = $this->sabadoLetivo->find($sabado);

        return view('sabadoLetivo.edit',compact('sabado'));
    }

    public function update($sabado, Request $req){
        $sabado = $this->sabadoLetivo->find($sabado);
        $sabado->data         =   implode("-", array_reverse(explode("/",$req->input('inicio'))));
        $sabado->referente    =   mb_strtoupper($req->input('tipo'),'UTF-8');

        $atualizado = $sabado->save();

        if($atualizado){
            return redirect()->route('sabado.show')
            ->withInput()
            ->with('success','O Sábado letivo foi atualizado com sucesso');
        }
    }

    public function show(Request $req){
        $pesquisa = $req->get('pesquisa','');
        $hoje = Carbon::now('America/Fortaleza');
        
        if($pesquisa){
            $sabados = $this->sabadoLetivo->where('referente','LIKE','%'.$pesquisa.'%')->whereYear('data','>=',$hoje->year)->orderBy('data','ASC')->paginate(10);
        }
        else{
            $sabados = $this->sabadoLetivo->whereYear('data','>=',$hoje->year)->orderBy('data','ASC')->paginate(10);
        }

         return view('sabadoLetivo.show',compact('sabados','pesquisa'));
    }

    public function delete($sabado){
        $sabado = $this->sabadoLetivo->find($sabado);
        $referente = $sabado->referente;
        $dia = implode("/", array_reverse(explode("-",$sabado->data)));
        $removido = $sabado->delete();

        if($removido){
            return redirect()->route('sabado.show')
            ->withInput()
            ->with('success','O Sábado letivo referente a: '. $referente.' foi removido com sucesso do dia: '.$dia);
        }
    }    
}