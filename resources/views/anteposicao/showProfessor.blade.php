@extends('layout.base')

@section('titulo','Minhas Anteposições')

@section('scripts')
    @include('scripts.update-tables')
    @include('scripts.modal')
@endsection

@section('conteudo')
<div class="row container-fluid">
    <div class="col-md-12 col-md-offset-0">
        <div class="panel panel-default">
            <div class="panel-heading">Minhas Anteposições</div>
            <div class="panel-body">
                <div class="row col-md-12 col-md-offset-0">
                    
                    @include('layout.flash')

                    @if($anteposicoes->count() == 0 && empty($pesquisa) && empty($filtro) )
                        <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 danger text-center">
                            Não há anteposições registradas por você.
                        </div>

                        <div class="row col-md-3 col-md-offset-5">
                            <div class="form-group text-center text-uppercase">
                                <a href="{{route('anteposicao.create')}}" class="btn btn-block btn-lg btn-primary">
                                    <span class="glyphicon glyphicon-plus"></span> Anteposição
                                </a>   
                            </div>
                        </div>
                    @elseif($anteposicoes->count() == 0 && !empty($pesquisa) && !empty($filtro) )
                        <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 text-center">
                            Nenhuma anteposição foi encontrada para o/a professor(a): <b class="text-uppercase"> {{$pesquisa}}</b>
                            utilizando o filtro: 
                            <b>
                                @if($filtro == "ESP")
                                    Aguardando Confirmação
                                @elseif($filtro == "CONF")
                                    Confirmada
                                @elseif($filtro == "VENC")
                                    Sem aulas de crédito
                                @elseif($filtro == "NEG")
                                    Cancelada
                                @endif 
                            </b> para este curso.
                        </div>

                        <div class="row col-md-2 col-md-offset-0">
                            <div class="form-group text-center text-uppercase">
                                <a href="{{route('anteposicao.show.professor')}}" class="btn btn-block btn-lg btn-primary">
                                    <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                </a>   
                            </div>
                        </div>
                    @elseif($anteposicoes->count() == 0 && !empty($pesquisa) && empty($filtro))
                        <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 text-center">
                            Nenhuma anteposição foi encontrada para o/a professor(a): <b class="text-uppercase"> {{$pesquisa}}</b> neste curso.
                        </div>

                        <div class="row col-md-2 col-md-offset-0">
                            <div class="form-group text-center text-uppercase">
                                <a href="{{route('anteposicao.show.professor')}}" class="btn btn-block btn-lg btn-primary">
                                    <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                </a>   
                            </div>
                        </div>
                    @elseif($anteposicoes->count() == 0 && empty($pesquisa) && !empty($filtro))
                        <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 text-center">
                            Nenhuma anteposição foi encontrada no curso utilizando o filtro: 
                            <b>
                               @if($filtro == "ESP")
                                    Aguardando Confirmação
                                @elseif($filtro == "CONF")
                                    Confirmada
                                @elseif($filtro == "VENC")
                                    Sem aulas de crédito
                                @elseif($filtro == "NEG")
                                    Cancelada
                                @endif 
                            </b>.
                        </div>

                        <div class="row col-md-2 col-md-offset-0">
                            <div class="form-group text-center text-uppercase">
                                <a href="{{route('anteposicao.show.professor')}}" class="btn btn-block btn-lg btn-primary">
                                    <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                </a>   
                            </div>
                        </div>
                    @else

                    <div class="row col-md-12 col-md-offset-0">
                          <form method="GET" action="{{route('anteposicao.show.professor')}}">
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
                                                    Aguardando Confirmação
                                                @elseif($filtro == "CONF")
                                                    Confirmada
                                                @elseif($filtro == "VENC")
                                                    Sem aulas de crédito
                                                @elseif($filtro == "NEG")
                                                    Cancelada
                                                @endif
                                            </option>
                                        @endif
                                        <option data-tokens="ketchup mustard" value="ESP" >Aguardando confirmação</option>
                                        <option data-tokens="ketchup mustard" value="CONF" >Confirmada</option>
                                        <option data-tokens="ketchup mustard" value="VENC" >Sem aulas de crédito</option>
                                        <option data-tokens="ketchup mustard" value="NEG" >Cancelada</option>
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
                                <a href="{{route('anteposicao.create')}}" class="btn btn-primary text-uppercase" >
                                    <span class="glyphicon glyphicon-plus"></span> Anteposição
                                </a>
                            </div>  
                        </div>

                        <div class="row col-md-12 col-md-offset-0 align-left">     
                            <div class="col cliente-labels">                                        
                                <p><i class="fa fa-square" style="color: #2E8B57;"></i><span>Confirmada</span></p>
                                <p><i class="fa fa-square" style="color: #F0E68C;"></i><span>Sem aulas de crédito</span></p>
                                <p><i class="fa fa-square" style="color: #87CEEB;"></i><span>Aguardando Confirmação</span></p>
                                <p><i class="fa fa-square" style="color: #FF00FF;"></i><span>Cancelada</span></p>
                            </div>
                        </div>
                        <table class="table table-striped bunitu">
                            <thead class="btn-primary">
                                <tr class="row text-uppercase">
                                    <th class="text-center" style="vertical-align: middle;">SITUAÇÃO</th>
                                    <th class="text-center" style="vertical-align: middle;">Professor</th>
                                    <th class="text-center" style="vertical-align: middle;">Disciplina</th>
                                    <th class="text-center" style="vertical-align: middle;">Turma</th>
                                    <th class="text-center" style="vertical-align: middle;">Restantes</th>
                                    <th class="text-center" style="vertical-align: middle;">Dia</th>
                                    <th class="text-center" style="vertical-align: middle;">Justificativa</th>
                                    <th class="text-center" style="vertical-align: middle;">Folha de Anteposição</th>
                                    <th class="text-center" style="vertical-align: middle;">Ação</th>
                                </tr>
                            </thead>
                            @foreach($anteposicoes as $anteposicao)

                                <tr class="row text-uppercase">
                                    <td class="text-center" style="vertical-align: middle;">
                                        @if($anteposicao->situacao == 'CONF')
                                            <a class="action" style="background-color: #2E8B57; color: #2E8B57;">
                                                <span class="fa fa-square"></span>
                                            </a>
                                        @elseif($anteposicao->situacao == 'VENC')
                                            <a class="action" style="background-color: #F0E68C; color: #F0E68C;">
                                                <span class="fa fa-square"></span>
                                            </a>
                                        @elseif($anteposicao->situacao == 'ESP')
                                            <a class="action" style="background-color: #87CEEB; color: #87CEEB;">
                                                <span class="fa fa-square"></span>
                                            </a>
                                        @elseif($anteposicao->situacao == 'NEG')
                                            <a class="action" style="background-color: #FF00FF; color: #FF00FF;">
                                                <span class="fa fa-square"></span>
                                            </a>
                                        @endif
                                    </td>
                                    <td class="text-center" style="vertical-align: middle;"> {{ $anteposicao->professor }} </td>
                                    <td class="text-center" style="vertical-align: middle;"> {{ $anteposicao->disciplina }} </td>
                                    <td class="text-center" style="vertical-align: middle;"> {{ $anteposicao->turma }} </td>
                                    <td class="text-center" style="vertical-align: middle;"> {{ $anteposicao->qtd - $anteposicao->gasta}} </td>
                                    <td class="text-center" style="vertical-align: middle;"> {{ implode("/", array_reverse(explode("-", $anteposicao->dia))) }} </td>
                                    <td class="text-center" style="vertical-align: middle;"> {{ $anteposicao->obs or '-'}} </td>
                                    <td class="text-center" style="vertical-align: middle;">
                                        <div class="btn-group-xs btn-group-vertical btn-block">
                                            <a class='btn' href="{{route('anteposicao.download',$anteposicao->id)}}" style="background: #008000;color: #fff">
                                                <span class="glyphicon glyphicon-download"></span> Download
                                            </a>  

                                            <a class="btn"></a>
                                            
                                            <a target=_blank class='btn' href="{{route('anteposicao.visualizar',$anteposicao->id)}}" style="background: #4682B4;color: #fff">
                                                <span class="glyphicon glyphicon-eye-open"></span> Visualizar
                                            </a>
                                        </div>
                                    </td>
                                    <td class="text-center" style="vertical-align: middle;">
                                        <div class="btn-group-xs btn-group-vertical btn-block">
                                            @if($anteposicao->situacao == 'ESP')
                                                <a class='btn btn-info' href="{{route('anteposicao.edit',$anteposicao->id)}}">
                                                    <span class="glyphicon glyphicon-edit"></span> Editar
                                                </a>
                                                <a class="btn"></a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </table>

                        {{ $anteposicoes->appends(['pesquisa' => $pesquisa , 'filtro' => $filtro])->links() }}

                    </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>
    @include('layout.modal')
@endsection