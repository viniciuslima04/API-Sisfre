<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use App\Http\Models\Curso;
use App\Http\Models\Disciplina;

class DisciplinaController extends Controller
{
    private $disciplina;
    private $curso;

    public function __construct(Curso $curso, Disciplina $disciplina){
        $this->middleware('admin');
        $this->curso = $curso;
        $this->disciplina = $disciplina;
    }

    public function create(){
        $cursos = $this->curso->orderBy('nome', 'ASC')->get();
        return view('disciplina.create',compact('cursos'));
    }

    public function store(Request $req){
        
        $cursos     = $req->input('curso');
        $periodos   = $req->input('periodo');
        $optativas  = $req->input('optativa');

        $validador = Validator::make($req->all(), [
            'disciplina'=> 'unique:disciplina,nome',
            'sigla'     => 'unique:disciplina,sigla'
        ]);

        if($validador->fails()){

            return redirect()->route('disciplina.create')
                ->withErrors($validador)
                ->withInput();
        }

        $disciplina = Disciplina::create([
            'nome'          => mb_strtoupper($req->input('disciplina'),'UTF-8'),
            'sigla'         => mb_strtoupper($req->input('sigla'),'UTF-8')
        ]);

        foreach ($cursos as $curso_id) {
            foreach ($periodos[$curso_id] as $periodo => $qtd_aula) {
                if(!empty($qtd_aula)){
                    $optativa = 2;
                    if(!empty($optativas[$curso_id][$periodo])){
                        $optativa = 1;
                    }
                    $disciplina->cursos()->attach($curso_id,[
                        'periodo'       => $periodo,
                        'carga_horaria' => $this->calculo_ch($qtd_aula),
                        'aula_semanal'  => $qtd_aula,
                        'optativa'      => $optativa
                    ]);
                }
            }
        }

        if($disciplina){
            return redirect()->route('disciplina.show')
            ->withInput()
            ->with('success','A disciplina: '.$disciplina->nome.' foi cadastrada com sucesso!');
        }

    }

    public function show(Request $req){
        $pesquisa   =  $req->get('pesquisa','');
        $curso      =  $req->get('curso','');
        $periodo    =  $req->get('periodo','');
        $cursos     =  $this->curso->orderBy('nome','ASC')->get();
        $where      =  [];

        if($curso){
            $where[] = ['curso.id','=', $curso];
            $curso   = Curso::find($curso);
        }
        
        if($pesquisa){
            $where[] = ['disciplina.nome','LIKE','%'.$pesquisa.'%'];
        }

        if($periodo){
            $where[] = ['curso_disciplina.periodo','=',$periodo];
        }

        $disciplinas = self::buscar_disciplinas($where);

        return view('disciplina.show',compact('disciplinas','pesquisa','curso','periodo','cursos'));
    }

    public static function buscar_disciplinas($where, $perPagine = 10, $qtdItens = 0){

        if(!empty($where)){

            $collections    = Disciplina::with('cursos')
                            ->join('curso_disciplina', 'disciplina.id', '=', 'curso_disciplina.disciplina_id')
                            ->join('curso', 'curso.id', '=', 'curso_disciplina.curso_id')
                            ->select('disciplina.*')
                            ->where($where)
                            ->distinct()
                            ->orderBy('disciplina.nome','ASC')
                            ->get();

            $qtdItens       = $collections->unique()->count();

            $queryBuilder   = Disciplina::with('cursos')
                            ->join('curso_disciplina', 'disciplina.id', '=', 'curso_disciplina.disciplina_id')
                            ->join('curso', 'curso.id', '=', 'curso_disciplina.curso_id')
                            ->select('disciplina.*')
                            ->where($where)
                            ->distinct()
                            ->orderBy('disciplina.nome','ASC')
                            ->paginate($perPagine);

            $total          = $queryBuilder->total();

            if($total > $qtdItens){

                $pagineInteger = (int) ($qtdItens / $perPagine);
                $pagineMod     = (int) ($qtdItens % $perPagine);
                $pagines       = self::getPagines($pagineInteger, $pagineMod);
                $perPagine     = self::getPerPagine($total, $pagines);

                return  Disciplina::with('cursos')
                        ->join('curso_disciplina', 'disciplina.id', '=', 'curso_disciplina.disciplina_id')
                        ->join('curso', 'curso.id', '=', 'curso_disciplina.curso_id')
                        ->select('disciplina.*')
                        ->where($where)
                        ->distinct()
                        ->orderBy('disciplina.nome','ASC')
                        ->paginate($perPagine);
            }

            return $queryBuilder;
        }

        $collections   = Disciplina::with('cursos')
                        ->select('disciplina.*')
                        ->orderBy('disciplina.nome','ASC')
                        ->distinct()
                        ->get();

        $qtdItens      = $collections->unique()->count();

        $queryBuilder  = Disciplina::with('cursos')
                        ->select('disciplina.*')
                        ->orderBy('disciplina.nome','ASC')
                        ->distinct()
                        ->paginate($perPagine);

        $total         = $queryBuilder->total();

        if($total > $qtdItens){
            $pagineInteger = (int) ($qtdItens / $perPagine);
            $pagineMod     = (int) ($qtdItens % $perPagine);
            $pagines       = self::getPagines($pagineInteger, $pagineMod);
            $perPagine     = self::getPerPagine($total, $pagines);

            return  Disciplina::with('cursos')
                    ->select('disciplina.*')
                    ->orderBy('disciplina.nome','ASC')
                    ->distinct()
                    ->paginate($perPagine); 
        }

        return $queryBuilder;
    }

    public static function getPerPagine($total, $pagines){
        return (int) ($total/$pagines);
    }

    public static function getPagines($integer, $mod){
        // A QUANTIDADE DE PÁGINAS É MAIOR QUE ZERO
        if($integer > 0){

            // A QUANTIDADE ENCONTRADA COMPORTA PERFEITAMENTE TODOS OS ITENS
            if($mod == 0){
                return $integer;
            }
            // A QUANTIDADE ENCONTRADA NÃO COMPORTA PERFEITAMENTE TODOS OS ITENS, SENDO NECESSÁRIO CRIAR UMA NOVA PÁGINA PARA OS ITENS EXCEDENTES.
            else if($mod > 0){
                return $integer + 1;
            }
        }

        // A QUANTIDADE DE ITENS NÃO DÁ UMA PÁGINA COMPLETA
        else{
            return 1;
        }
    }

    public function edit($discipli){
        $disciplina = $this->disciplina->find($discipli);
        $relacao = $disciplina->cursos->groupBy('id');
        $relacoes = collect([]);

        foreach ($relacao as $curso_id => $cursos) {
            
            foreach ($cursos as $curso) {
                $periodo[$curso_id][$curso->pivot->periodo]    = $curso->pivot->aula_semanal;
                $optativa[$curso_id][$curso->pivot->periodo]   = $curso->pivot->optativa;
            }
            $relacoes->push(['id' => $curso->id, 'nome' => $curso->nome,'duracao' => $curso->duracao, $periodo, $optativa]);
        }

        $cursos = $this->curso->orderBy('nome', 'ASC')->get();
        return view('disciplina.edit',compact('cursos','disciplina','relacoes'));
    }

    public function update($discipli, Request $req){
        $validador = Validator::make($req->all(), [
            'nome'           => [Rule::unique('disciplina')->ignore($discipli)],
            'sigla'          => [Rule::unique('disciplina')->ignore($discipli)]
        ]);

        if($validador->fails()){

            return redirect()->route('disciplina.edit',$discipli)
                ->withErrors($validador)
                ->withInput();
        }

        $disciplina = $this->disciplina->find($discipli);
        if($this->desassocia_cursos($disciplina)){
            $disciplina->nome  = mb_strtoupper($req->input('disciplina'),'UTF-8');
            $disciplina->sigla = mb_strtoupper($req->input('sigla'),'UTF-8');
            $cursos            = $req->input('curso');
            $periodos          = $req->input('periodo'); 
            $optativas         = $req->input('optativa');

            $this->associa_cursos($disciplina, $cursos, $periodos, $optativas);

            $atualizado = $disciplina->save();
            
            if($disciplina){
                return redirect()->route('disciplina.show')
                ->withInput()
                ->with('success','A disciplina: '.$disciplina->nome.' foi atualizada com sucesso!');
            }

        }
        else{
            if($disciplina){
                return redirect()->route('disciplina.show')
                ->withInput()
                ->with('error','Não foi possível atualizar a disciplina: '.$disciplina->nome);
            }
        }
    }

    public function desassocia_cursos($disciplina){
        $remove = $disciplina->cursos()->detach();

        if($remove > 0){
            return true;
        }
        return false;
    }

    public function associa_cursos($disciplina, $cursos, $periodos, $optativas){
        foreach ($cursos as $curso_id) {
            foreach ($periodos[$curso_id] as $periodo => $qtd_aula) {
                if(!empty($qtd_aula)){
                    $optativa = 2;
                    if(!empty($optativas[$curso_id][$periodo])){
                        $optativa = 1;
                    }
                    $add = $disciplina->cursos()->attach($curso_id,[
                        'periodo'       => $periodo,
                        'carga_horaria' => $this->calculo_ch($qtd_aula),
                        'aula_semanal'  => $qtd_aula,
                        'optativa'      => $optativa
                    ]);
                }
            }
        }

        return true;
    }

    public function delete($disciplina){
        $disciplina = $this->disciplina->find($disciplina);
        $nome = $disciplina->nome;
        $removido = $disciplina->delete();

        if($removido){
            return redirect()->route('disciplina.show')
            ->withInput()
            ->with('success','A disciplina: '.$nome.' foi removida com sucesso!');
        }  
    }

    public function calculo_ch($qtd_aula){
        return ($qtd_aula * 10) * 2;
    }
}