@extends('layout.base')

@section('titulo','Reposições do Curso')

@section('scripts')
    @include('scripts.update-tables')
    @include('scripts.modal')
@endsection

@section('conteudo')
<div class="row container-fluid">
    <div class="col-md-12 col-md-offset-0">
        <div class="panel panel-default">
            <div class="panel-heading">Reposições do Curso</div>
            <div class="panel-body">
                <div class="row col-md-12 col-md-offset-0">
                    
                    @include('layout.flash')

                    @if($reposicoes->count() == 0 && empty($pesquisa) && empty($filtro) )
                        <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 danger text-center">
                            Não há reposições marcadas para o curso: <br> <b> {{Auth::user()->professor->curso->nome}}</b>.
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
                            Nenhuma reposição foi encontrada para o professor: <br> <b class="text-uppercase"> {{$pesquisa}}</b>
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
                                <a href="{{route('reposicao.show.coordenador')}}" class="btn btn-block btn-lg btn-primary">
                                    <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                </a>   
                            </div>
                        </div>
                    @elseif($reposicoes->count() == 0 && !empty($pesquisa) && empty($filtro))
                        <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 text-center">
                            Nenhuma reposição foi encontrada para o professor: <br><b class="text-uppercase"> {{$pesquisa}}</b>.
                        </div>

                        <div class="row col-md-2 col-md-offset-0">
                            <div class="form-group text-center text-uppercase">
                                <a href="{{route('reposicao.show.coordenador')}}" class="btn btn-block btn-lg btn-primary">
                                    <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                </a>   
                            </div>
                        </div>
                    @elseif($reposicoes->count() == 0 && empty($pesquisa) && !empty($filtro))
                        <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 text-center">
                            Nenhuma reposição foi encontrada para o curso:<br><b>{{Auth::user()->professor->curso->nome}}</b> no filtro: 
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
                                <a href="{{route('reposicao.show.coordenador')}}" class="btn btn-block btn-lg btn-primary">
                                    <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                </a>   
                            </div>
                        </div>
                    @else

                    <div class="row col-md-12 col-md-offset-0">
                          <form method="GET" action="{{route('reposicao.show.coordenador')}}">
                            <div class="form-group col-md-5">
                                <div class="input-group">
                                    <input type="text" class="form-control input-lg text-uppercase" name="pesquisa" value="{{old('pesquisa','')}}" id="pesquisa" placeholder="Pesquise pelo nome do professor" />
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
                                    <th class="text-center" style="vertical-align: middle;">Situação</th>
                                    <th class="text-center" style="vertical-align: middle;">Professor</th>
                                    <th class="text-center" style="vertical-align: middle;">Disciplina</th>
                                    <th class="text-center" style="vertical-align: middle;">Turma</th>
                                    <th class="text-center" style="vertical-align: middle;">Quantidade</th>
                                    <th class="text-center" style="vertical-align: middle;">Dia</th>
                                    <th class="text-center" style="vertical-align: middle;">Observação</th>
                                    <th class="text-center" style="vertical-align: middle;">Folha de Reposição</th>
                                    <th class="text-center" style="vertical-align: middle;">Ação</th>
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
                                    <td class="text-center" style="vertical-align: middle;"> {{ $reposicao->professor }} </td>
                                    <td class="text-center" style="vertical-align: middle;"> {{ $reposicao->disciplina }} </td>
                                    <td class="text-center" style="vertical-align: middle;"> {{ $reposicao->turma }} </td>
                                    <td class="text-center" style="vertical-align: middle;"> {{ $reposicao->qtd }} </td>
                                    <td class="text-center" style="vertical-align: middle;"> {{ implode("/", array_reverse(explode("-", $reposicao->dia))) }} </td>
                                    <td class="text-center" style="vertical-align: middle;"> {{ $reposicao->obs or '-'}} </td>
                                    <td class="text-center" style="vertical-align: middle;">
                                        <div class="text-center btn-group-xs btn-group-vertical btn-block">
                                            <a class='btn' href="{{route('reposicao.download',$reposicao->id)}}" style="background: #008000;color: #fff">
                                                <span class="glyphicon glyphicon-download"></span> Download
                                            </a>  

                                            <a class="btn"></a>
                                            
                                            <a target=_blank class='btn' href="{{route('reposicao.visualizar',$reposicao->id)}}" style="background: #4682B4;color: #fff">
                                                <span class="glyphicon glyphicon-eye-open"></span> Visualizar
                                            </a>
                                        </div>
                                    </td>
                                    <td class="text-center" style="vertical-align: middle;">
                                        <div class="btn-group-xs btn-group-vertical btn-block">
                                            @if($reposicao->situacao != 'CONF' )
                                                <a class="btn btn-info" data-toggle="modal" data-target="#modal_confirmar_remover" data-entidade="reposicao" data-url="{{route('reposicao.confirmar',$reposicao->id)}}" data-modo="confirmar"> 
                                                    <span class="glyphicon glyphicon-ok"></span> Confirmar
                                                </a>
                                                <a class="btn"></a>
                                            @endif

                                            @if($reposicao->situacao == 'ESP' && $reposicao->usuario == 'COORDENADOR')
                                                <a class='btn btn-info' href="{{route('reposicao.edit',['coordenador', $reposicao->id])}}">
                                                    <span class="glyphicon glyphicon-edit"></span> Editar
                                                </a>
                                                <a class="btn"></a>
                                            @endif
                                            @if($reposicao->situacao != 'NEG')
                                                <a class="btn btn-danger" data-toggle="modal" data-target="#modal_confirmar_remover" data-entidade="reposicao" data-url="{{route('reposicao.cancelar',$reposicao->id)}}" data-modo="remover">
                                                    <span class="glyphicon glyphicon-remove" ></span> Cancelar
                                                </a>
                                            @endif
                                        </div>
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