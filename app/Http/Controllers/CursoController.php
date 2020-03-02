<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CursoRequest;

use App\Http\Models\Curso;
use App\Http\Models\Professor;

class CursoController extends Controller
{

    private $curso;
    private $professor;

    public function __construct(Curso $curso, Professor $professor){
        $this->middleware('admin');
        $this->curso = $curso;
        $this->professor = $professor;
    }

    public function create(){
        $professores = $this->professor->doesntHave('curso')->get();
        return view('curso.create',compact('professores'));
    }

    public function store(CursoRequest $req){
        $nome     = mb_strtoupper($req->input('nome'),'UTF-8');
        $sigla    = mb_strtoupper($req->input('sigla'),'UTF-8');
        $tipo     = $this->tipo($req->input('tipo')); 
        $duracao  = $req->input('duracao');

        $curso = Curso::create([
            'nome'          => $nome,
            'sigla'         => $sigla,
            'tipo'          => $tipo,
            'duracao'       => $duracao
        ]);


        if($req->input('coord')){
            if($this->associaCoordenador($req->input('coord'), $curso->id) == false){
                return redirect()->route('curso.show')
                ->withInput()
                ->with('error','Não foi possível cadastrar o curso.');
            }
        }

        if($curso){

            return redirect()->route('curso.show')
            ->withInput()
            ->with('success','O Curso: '.$nome.' foi cadastrado com sucesso!');
        }

    }

    public function show(Request $req){
        $pesquisa = $req->get('pesquisa','');
        if($pesquisa){
          $cursos = $this->curso->where('nome','LIKE','%'.$pesquisa.'%')->orderBy('nome')->paginate(6);
        }
        else{
            $cursos = $this->curso->orderBy('nome')->paginate(6);
        }

         return view('curso.show',compact('cursos','pesquisa'));
    }

    public function edit($curso){
        $curso = $this->curso->find($curso);
        $professores = $this->professor->all();
        return view('curso.edit', compact('professores','curso'));
    }

    public function update(CursoRequest $req, $curso){
        $curso = $this->curso->find($curso);
        $curso->nome     = mb_strtoupper($req->input('nome'),'UTF-8');
        $curso->sigla    = mb_strtoupper($req->input('sigla'),'UTF-8');
        $curso->tipo     = $this->tipo($req->input('tipo')); 
        $curso->duracao  = $req->input('duracao');

        if(empty($curso->coordenador) && $req->input('coord')){
            if($this->associaCoordenador($req->input('coord'), $curso->id) == false ){
                return redirect()->route('curso.show')
                ->withInput()
                ->with('error','Não foi possível atualizar o curso.');  
            }
        }
        elseif( !empty($curso->coordenador) && $req->input('coord') && ($req->input('coord') != $curso->coordenador->id) ){
            if($this->desassociaCoordenador($curso->coordenador) == false || $this->associaCoordenador($req->input('coord'), $curso->id) == false){
                return redirect()->route('curso.show')
                ->withInput()
                ->with('error','Não foi possível atualizar o curso.');
            }
        }

        $atualizado = $curso->save();

        if($atualizado){

            return redirect()->route('curso.show')
            ->withInput()
            ->with('success','O Curso: '.$req->input('nome').' foi atualizado com sucesso!');
        }

    }

    public function delete($curso){
        $curso = $this->curso->find($curso);
        $cursoFormatado = $curso->nome.' - '.$curso->sigla;
        $desassocia = true;

        if(!empty($curso->coordenador)){
            $desassocia = $this->desassociaCoordenador($curso->coordenador);
        }

        $removido =  $curso->delete();

        if($removido && $desassocia){
            return redirect()->route('curso.show')
            ->withInput()
            ->with('success','O curso: '.$cursoFormatado.' foi removido com sucesso!');
        }
    }

    public function tipo($tipo){

        if($tipo == "1"){
            return "GRADUAÇÃO";
        }
        elseif($tipo == "2"){
            return "INTEGRADO";
        }
        elseif($tipo == "3"){
            return "TÉCNICO";
        }
    }

    public function associaCoordenador($coordenador, $curso){
            
            $prof = $this->professor->find($coordenador);
            $prof->curso_id = $curso;
            $usuario = $prof->usuario;
            $usuario->acesso = 3;

            $modifica_acesso = $usuario->save();

            $professor_atualizado = $prof->save();

            return $professor_atualizado && $modifica_acesso;
    } 

    public function desassociaCoordenador($antigo_coordenador){
        $antigo_coordenador->curso_id = NULL;
        $usuario = $antigo_coordenador->usuario;
        $usuario->acesso = 2;

        $modifica_acesso = $usuario->save();
        $retirada_curso = $antigo_coordenador->save();

        return $retirada_curso && $modifica_acesso;
    }   
}