@extends('layout.base')

@section('titulo','Minhas Faltas')

@section('scripts')
    @include('scripts.update-tables')
    @include('scripts.modal')
@endsection

@section('conteudo')
<div class="row container-fluid">
    <div class="col-md-12 col-md-offset-0">
        <div class="panel panel-default">
            <div class="panel-heading">Minhas Faltas</div>
            <div class="panel-body">
                <div class="row col-md-12 col-md-offset-0">
                    
                    @include('layout.flash')

                    @if($faltasVerificadas->count() == 0 && empty($pesquisa) && empty($situacao) && empty($semestre) )
                        <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 danger text-center">
                            Não há faltas registradas para você.
                        </div>

                    @elseif($faltasVerificadas->count() == 0 && !empty($pesquisa) && !empty($situacao) && !empty($semestre) )
                        <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 text-center">
                            Nenhuma falta 
                            <b class="text-uppercase">
                                @if($situacao == "VENC")
                                    Não Reposta
                                @elseif($situacao == "CONF")
                                    Aguardando reposição
                                @elseif($situacao == "PAGA_P")
                                    Reposta parcialmente
                                @elseif($situacao == "PAGA_T")
                                    Totalmente reposta
                                @endif 
                            </b> foi encontrada para a disciplina: <br><b class="text-uppercase"> {{$pesquisa}} </b> no semestre dado.
                        </div>

                        <div class="row col-md-2 col-md-offset-0">
                            <div class="form-group text-center text-uppercase">
                                <a href="{{route('falta.show.professor')}}" class="btn btn-block btn-lg btn-primary">
                                    <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                </a>   
                            </div>
                        </div>
                    
                    @elseif($faltasVerificadas->count() == 0 && !empty($pesquisa) && empty($semestre) && empty($situacao) )
                        <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 text-center">
                            Nenhuma falta foi encontrada para a disciplina: <br> <b class="text-uppercase"> {{$pesquisa}}</b> no sistema.
                        </div>

                        <div class="row col-md-2 col-md-offset-0">
                            <div class="form-group text-center text-uppercase">
                                <a href="{{route('falta.show.professor')}}" class="btn btn-block btn-lg btn-primary">
                                    <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                </a>   
                            </div>
                        </div>
                    
                    @elseif($faltasVerificadas->count() == 0 && !empty($pesquisa) && !empty($semestre) && empty($situacao))
                        <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 text-center">
                            Nenhuma falta foi encontrada para a disciplina: <br> <b class="text-uppercase"> {{$pesquisa}}</b> no semestre dado.
                        </div>

                        <div class="row col-md-2 col-md-offset-0">
                            <div class="form-group text-center text-uppercase">
                                <a href="{{route('falta.show.professor')}}" class="btn btn-block btn-lg btn-primary">
                                    <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                </a>   
                            </div>
                        </div>

                    @elseif($faltasVerificadas->count() == 0 && !empty($pesquisa) && empty($semestre) && !empty($situacao))
                        <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 text-center">
                            Nenhuma falta 
                            <b class="text-uppercase">
                                @if($situacao == "VENC")
                                    Não Reposta
                                @elseif($situacao == "CONF")
                                    Aguardando reposição
                                @elseif($situacao == "PAGA_P")
                                    Reposta parcialmente
                                @elseif($situacao == "PAGA_T")
                                    Totalmente reposta
                                @endif 
                            </b> foi encontrada para a disciplina: <br> <b class="text-uppercase"> {{$pesquisa}} </b> no sistema.
                        </div>

                        <div class="row col-md-2 col-md-offset-0">
                            <div class="form-group text-center text-uppercase">
                                <a href="{{route('falta.show.professor')}}" class="btn btn-block btn-lg btn-primary">
                                    <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                </a>   
                            </div>
                        </div>

                    @elseif($faltasVerificadas->count() == 0 && empty($pesquisa) && !empty($semestre) && !empty($situacao))
                        <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 text-center">
                            Nenhuma falta 
                            <b class="text-uppercase">
                                @if($situacao == "VENC")
                                    Não Reposta
                                @elseif($situacao == "CONF")
                                    Aguardando reposição
                                @elseif($situacao == "PAGA_P")
                                    Reposta parcialmente
                                @elseif($situacao == "PAGA_T")
                                    Totalmente reposta
                                @endif 
                            </b> foi encontrada para o semestre dado, no sistema.
                        </div>

                        <div class="row col-md-2 col-md-offset-0">
                            <div class="form-group text-center text-uppercase">
                                <a href="{{route('falta.show.professor')}}" class="btn btn-block btn-lg btn-primary">
                                    <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                </a>   
                            </div>
                        </div>

                    @elseif($faltasVerificadas->count() == 0 && empty($pesquisa) && empty($semestre) && !empty($situacao))
                        <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 text-center">
                            Nenhuma falta 
                            <b class="text-uppercase">
                                @if($situacao == "VENC")
                                    Não Reposta
                                @elseif($situacao == "CONF")
                                    Aguardando reposição
                                @elseif($situacao == "PAGA_P")
                                    Reposta parcialmente
                                @elseif($situacao == "PAGA_T")
                                    Totalmente reposta
                                @endif 
                            </b> foi encontrada no sistema.
                        </div>

                        <div class="row col-md-2 col-md-offset-0">
                            <div class="form-group text-center text-uppercase">
                                <a href="{{route('falta.show.professor')}}" class="btn btn-block btn-lg btn-primary">
                                    <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                </a>   
                            </div>
                        </div>

                    @elseif($faltasVerificadas->count() == 0 && empty($pesquisa) && !empty($semestre) && empty($situacao))
                        <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 text-center">
                            Nenhuma falta foi encontrada para o semestre dado, no sistema.
                        </div>

                        <div class="row col-md-2 col-md-offset-0">
                            <div class="form-group text-center text-uppercase">
                                <a href="{{route('falta.show.professor')}}" class="btn btn-block btn-lg btn-primary">
                                    <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                </a>   
                            </div>
                        </div>
                    
                    @else

                    <div id="container-pesquisar" class="row col-md-10 col-md-offset-1">
                          <form method="GET" action="{{route('falta.show.professor')}}">
                            <div class="form-group col-md-6">
                                <div class="input-group">
                                    <input type="text" class="form-control input-lg text-uppercase" name="pesquisa" value="{{old('pesquisa','')}}" id="pesquisa" placeholder="Pesquise pela disciplina" />
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary"><span class="glyphicon glyphicon-search"></span></button>
                                    </div>

                                </div>
                            </div>

                            <div class="form-group col-md-6 {{ $errors->has('situacao') ? ' has-error' : '' }}">
                                <label class="col-md-3 control-label" for="filtro">Situação:</label>
                                <div class="col-md-9">
                                    <select class="selectpicker form-control text-uppercase" name="situacao" id="situacao">
                                        <option data-tokens="ketchup mustard" value="" selected> SEM FILTRO</option>
                                        @if(!empty($situacao))
                                            <option data-tokens="ketchup mustard" value="{{$filtro}}" selected>
                                                @if($situacao == "VENC")
                                                    Não Reposta
                                                @elseif($situacao == "CONF")
                                                    Aguardando reposição
                                                @elseif($situacao == "PAGA_P")
                                                    Reposta parcialmente
                                                @elseif($situacao == "PAGA_T")
                                                    Totalmente reposta
                                                @endif
                                            </option>
                                        @endif
                                        <option data-tokens="ketchup mustard" value="CONF" >Aguardando reposição</option>
                                        <option data-tokens="ketchup mustard" value="PAGA_P" >Reposta parcialmente</option>
                                        <option data-tokens="ketchup mustard" value="PAGA_T" >Totalmente reposta</option>
                                        <option data-tokens="ketchup mustard" value="VENC" >Não Reposta</option>
                                    </select>

                                    @if ($errors->has('situacao'))
                                        <span class="help-block">
                                             <strong>{{ $errors->first('situacao') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group col-md-6 col-md-offset-6 {{ $errors->has('semestre') ? ' has-error' : '' }}">
                                <label class="col-md-3 control-label" for="semestre">Semestre:</label>
                                <div class="col-md-9">
                                    <select class="selectpicker form-control text-uppercase" name="semestre" id="semestre">
                                        <option data-tokens="ketchup mustard" value="" selected> SEM FILTRO </option>

                                        @foreach ($semAtivos as $semestreAtivo)

                                            @if(old('semestre') == $semestreAtivo->id)
                                                <option data-tokens="ketchup mustard" value="{{$semestreAtivo->id}}" selected> {{$semestreAtivo->ano}}.{{$semestreAtivo->etapa}} ({{$semestreAtivo->tipo}}) </option>   
                                            @endif

                                            @if($semestre == $semestreAtivo->id)
                                                <option data-tokens="ketchup mustard" value="{{$semestreAtivo->id}}" selected> {{$semestreAtivo->ano}}.{{$semestreAtivo->etapa}} ({{$semestreAtivo->tipo}}) </option>   
                                            @endif

                                            <option data-tokens="ketchup mustard" value="{{$semestreAtivo->id}}"> {{$semestreAtivo->ano}}.{{$semestreAtivo->etapa}} ({{$semestreAtivo->tipo}}) </option>   
                                        @endforeach

                                    </select>

                                    @if ($errors->has('semestre'))
                                        <span class="help-block">
                                             <strong>{{ $errors->first('semestre') }}</strong>
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
                                <p><i class="fa fa-square" style="color: #2E8B57;"></i><span>Totalmente Paga</span></p>
                                <p><i class="fa fa-square" style="color: #98FB98;"></i><span>Parcialmente Paga</span></p>
                                <p><i class="fa fa-square" style="color: #FF6347;"></i><span>Não Reposta</span></p>
                                <p><i class="fa fa-square" style="color: #F0E68C;"></i><span>Aguardando Reposição</span></p>
                            </div>
                        </div>

                        <table class="table table-striped bunitu">
                            <thead class="btn-primary">
                                <tr class="row text-uppercase">
                                    <th class="text-center" style="vertical-align: middle;">Situação</th>
                                    <th class="text-center" style="vertical-align: middle;">Disciplina</th>
                                    <th class="text-center" style="vertical-align: middle;">Turma</th>
                                    <th class="text-center" style="vertical-align: middle;">Quantidade</th>
                                    <th class="text-center" style="vertical-align: middle;">Dia</th>
                                    <th class="text-center" style="vertical-align: middle;">Repôr até</th>
                                    <th class="text-center" style="vertical-align: middle;">Justificativa</th>
                                    <th class="text-center" style="vertical-align: middle;">Ação</th>
                                </tr>
                            </thead>
                            @foreach($faltasVerificadas as $falta)

                                <tr class="row text-uppercase">
                                    <td class="text-center">

                                        @if($falta->situacao == 'CONF')
                                            <a class="action" style="background-color: #F0E68C; color: #F0E68C;">
                                                <span class="fa fa-square"></span>
                                            </a>
                                        @elseif($falta->situacao == 'PAGA_P')
                                            <a class="action" style="background-color: #98FB98; color: #98FB98;">
                                                <span class="fa fa-square"></span>
                                            </a>
                                        @elseif($falta->situacao == 'PAGA_T')
                                            <a class="action" style="background-color: #2E8B57; color: #2E8B57;">
                                                <span class="fa fa-square"></span>
                                            </a>
                                        @elseif($falta->situacao == 'VENC')
                                            <a class="action" style="background-color: #FF6347; color: #FF6347;">
                                                <span class="fa fa-square"></span>
                                            </a>
                                        @endif
                                    </td>
                                    <td class="text-center" style="vertical-align: middle;"> {{ $falta->disciplina }} </td>
                                    <td class="text-center" style="vertical-align: middle;"> {{ $falta->turma }} </td>
                                    <td class="text-center" style="vertical-align: middle;"> {{ $falta->qtd }} </td>
                                    <td class="text-center" style="vertical-align: middle;"> {{ implode("/", array_reverse(explode("-", $falta->dia))) }} </td>
                                    <td class="text-center" style="vertical-align: middle;"> {{ implode("/", array_reverse(explode("-", $falta->validade))) }} </td>
                                    <td class="text-center" style="vertical-align: middle;"> {{ $falta->obs or '-'}} </td>
                                    <td  class="text-center" style="vertical-align: middle;">
                                        <div class="btn-group-xs btn-group-vertical btn-block">
                                            @if($falta->situacao == 'CONF')
                                                @if($falta->reposicoes->where('situacao','=','ESP')->where('qtd','<',$falta->qtd)->count() <= 1 && $falta->reposicoes->where('situacao','=','ESP')->where('qtd','=',$falta->qtd)->count() == 0)
                                                    <a class='btn btn-info' href="{{route('reposicao.create',['professor',$falta->id])}}">
                                                        <span class="glyphicon glyphicon-plus"></span> Reposição
                                                    </a>
                                                    <a class="btn"></a>
                                                @endif
                                            @elseif($falta->situacao == 'PAGA_P')
                                                @if($falta->reposicoes->where('situacao','=','ESP')->count() == 0)
                                                    <a class='btn btn-info' href="{{route('reposicao.create',['professor',$falta->id])}}">
                                                        <span class="glyphicon glyphicon-plus"></span> Reposição
                                                    </a>
                                                    <a class="btn"></a>
                                                @endif  
                                            @else
                                                -
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                            @endforeach
                        </table>

                        {{ $faltasVerificadas->appends(['pesquisa' => $pesquisa, 'situacao' => $situacao, 'semestre' => $semestre])->links() }}

                    </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>
    @include('layout.modal')
@endsection