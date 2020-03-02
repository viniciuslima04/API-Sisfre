@extends('layout.base')

@section('titulo','Minhas Reposições')

@section('scripts')
    @include('scripts.update-tables')
    @include('scripts.modal')
@endsection

@section('conteudo')
<div class="row container-fluid">
    <div class="col-md-12 col-md-offset-0">
        <div class="panel panel-default">
            <div class="panel-heading">Minhas Reposições</div>
            <div class="panel-body">
                <div class="row col-md-12 col-md-offset-0">
                    
                    @include('layout.flash')

                    @if($reposicoes->count() == 0 && empty($pesquisa) && empty($filtro) )
                        <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 danger text-center">
                            Não há reposições marcadas por você.
                        </div>

                        <div class="row col-md-2 col-md-offset-0">
                            <div class="form-group text-center text-uppercase">
                                <a href="{{route('home')}}" class="btn btn-block btn-lg btn-primary">
                                    <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                </a>   
                            </div>
                        </div>
                    @elseif($reposicoes->count() == 0 && !empty($pesquisa) && !empty($filtro))
                        <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 text-center">
                            Nenhuma reposição foi encontrada para você na disciplina: <b class="text-uppercase"> {{$pesquisa}}</b>
                            utilizando o filtro: 
                            <b>
                                @if($filtro == "ESP")
                                    Esperando confirmação
                                @elseif($filtro == "CONF")
                                    Confirmada
                                @elseif($filtro == "NEG")
                                    Negada
                                @endif  
                            </b>.
                        </div>

                        <div class="row col-md-2 col-md-offset-0">
                            <div class="form-group text-center text-uppercase">
                                <a href="{{route('reposicao.show.professor')}}" class="btn btn-block btn-lg btn-primary">
                                    <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                </a>   
                            </div>
                        </div>
                    @elseif($reposicoes->count() == 0 && !empty($pesquisa) && empty($filtro))
                        <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 text-center">
                            Nenhuma reposição foi encontrada para você na disciplina: <b class="text-uppercase"> {{$pesquisa}}</b>.
                        </div>

                        <div class="row col-md-2 col-md-offset-0">
                            <div class="form-group text-center text-uppercase">
                                <a href="{{route('reposicao.show.professor')}}" class="btn btn-block btn-lg btn-primary">
                                    <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                </a>   
                            </div>
                        </div>
                    @elseif($reposicoes->count() == 0 && empty($pesquisa) && !empty($filtro))
                        <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 text-center">
                            Nenhuma reposição foi encontrada para você no filtro: 
                            <b>
                                @if($filtro == "ESP")
                                    Esperando confirmação
                                @elseif($filtro == "CONF")
                                    Confirmada
                                @elseif($filtro == "NEG")
                                    Negada
                                @endif  
                            </b>.
                        </div>

                        <div class="row col-md-2 col-md-offset-0">
                            <div class="form-group text-center text-uppercase">
                                <a href="{{route('reposicao.show.professor')}}" class="btn btn-block btn-lg btn-primary">
                                    <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                </a>   
                            </div>
                        </div>
                    @else

                    <div class="row col-md-12 col-md-offset-0">
                          <form method="GET" action="{{route('reposicao.show.professor')}}">
                            <div class="form-group col-md-5">
                                <div class="input-group">
                                    <input type="text" class="form-control input-lg text-uppercase" name="pesquisa" value="{{old('pesquisa','')}}" id="pesquisa" placeholder="Pesquise pela disciplina" />
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary"><span class="glyphicon glyphicon-search"></span></button>
                                    </div>

                                </div>
                            </div>

                            <div class="form-group col-md-6 col-md-offset-1 {{ $errors->has('filtro') ? ' has-error' : '' }}">
                                <label class="col-md-2 control-label" for="filtro">Filtro:</label>
                                <div class="col-md-8">
                                    <select class="selectpicker form-control text-uppercase" name="filtro" id="filtro">
                                        <option data-tokens="ketchup mustard" value="" selected >SEM FILTRO</option>
                                        @if(!empty($filtro))
                                            <option data-tokens="ketchup mustard" value="{{$filtro}}" selected>
                                                @if($filtro == "ESP")
                                                    Esperando confirmação
                                                @elseif($filtro == "CONF")
                                                    Confirmada
                                                @elseif($filtro == "NEG")
                                                    Negada
                                                @endif 
                                            </option>
                                        @endif
                                        <option data-tokens="ketchup mustard" value="ESP" >Esperando confirmação</option>
                                        <option data-tokens="ketchup mustard" value="CONF" >Confirmada</option>
                                        <option data-tokens="ketchup mustard" value="NEG" >Negada</option>
                                    </select>

                                    @if ($errors->has('filtro'))
                                        <span class="help-block">
                                             <strong>{{ $errors->first('filtro') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div> 
                          </form>
                     </div>


                    <div class="table-responsive col-md-12" id="tabela-update">
                        <div class="row col-md-12 col-md-offset-0">
                            <div class="form-group pull-right">
                            </div>  
                        </div>

                        <div class="row col-md-12 col-md-offset-0 align-left">     
                            <div class="col cliente-labels">                                        
                                <p><i class="fa fa-square" style="color: #2E8B57;"></i><span>Confirmada</span></p>
                                <p><i class="fa fa-square" style="color: #FF6347;"></i><span>Negada</span></p>
                                <p><i class="fa fa-square" style="color: #F0E68C;"></i><span>Esperando confirmação</span></p>
                            </div>
                        </div>

                        <table class="table table-striped bunitu">
                            <thead class="btn-primary">
                                <tr class="row text-uppercase">
                                    <th class="text-center">Situação</th>
                                    <th class="text-center">Disciplina</th>
                                    <th class="text-center">Turma</th>
                                    <th class="text-center">Quantidade</th>
                                    <th class="text-center">Dia</th>
                                    <th class="text-center">Observações</th>
                                    <th class="text-center">Folha de Reposição</th>
                                    <th class="text-center">Ação</th>
                                </tr>
                            </thead>
                            @foreach($reposicoes as $reposicao)

                                <tr class="row text-uppercase">
                                    <td class="text-center" style="vertical-align: middle;">

                                        @if($reposicao->situacao == 'CONF')
                                            <a class="action" style="background-color: #2E8B57; color: #2E8B57;">
                                                <span class="fa fa-square"></span>
                                            </a>
                                        @elseif($reposicao->situacao == 'NEG')
                                            <a class="action" style="background-color: #FF6347; color: #FF6347;">
                                                <span class="fa fa-square"></span>
                                            </a>
                                        @elseif($reposicao->situacao == 'ESP')
                                            <a class="action" style="background-color: #F0E68C; color: #F0E68C;">
                                                <span class="fa fa-square"></span>
                                            </a>
                                        @endif
                                    </td>
                                    <td class="text-center" style="vertical-align: middle;"> {{ $reposicao->disciplina }} </td>
                                    <td class="text-center" style="vertical-align: middle;"> {{ $reposicao->turma }} </td>
                                    <td class="text-center" style="vertical-align: middle;"> {{ $reposicao->qtd }} </td>
                                    <td class="text-center" style="vertical-align: middle;"> {{ implode("/", array_reverse(explode("-", $reposicao->dia))) }} </td>

                                    <td class="text-center" style="vertical-align: middle;"> {{ $reposicao->obs or '-'}} </td>
                                    <td class="text-center" style="vertical-align: middle;">
                                        <div class="text-center btn-group-xs btn-group-vertical btn-block">
                                            <a target=_blank class='btn' href="{{route('reposicao.download',$reposicao->id)}}" style="background: #008000;color: #fff">
                                                <span class="glyphicon glyphicon-download"></span> Download
                                            </a>  

                                            <a class="btn"></a>
                                            
                                            <a target=_blank class='btn' href="{{route('reposicao.visualizar',$reposicao->id)}}" style="background: #4682B4;color: #fff">
                                                <span class="glyphicon glyphicon-eye-open"></span> Visualizar
                                            </a>
                                        </div>
                                    </td>
                                    <td class="btn-group-xs btn-group-vertical btn-block text-center">
                                        @if($reposicao->situacao == 'ESP' && $reposicao->usuario == 'PROFESSOR')
                                            <a class='btn btn-info' href="{{route('reposicao.edit',['professor', $reposicao->id])}}">
                                                <span class="glyphicon glyphicon-edit"></span> Editar
                                            </a>
                                            <a class="btn"></a>
                                        @endif
                                    </td>
                                </tr>

                            @endforeach
                        </table>

                        {{ $reposicoes->appends(['pesquisa' => $pesquisa, 'filtro' => $filtro])->links() }}

                    </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>
    @include('layout.modal')
@endsection