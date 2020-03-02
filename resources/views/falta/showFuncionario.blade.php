@extends('layout.base')

@section('titulo','Controle de Faltas')

@section('scripts')
    @include('scripts.update-tables')
    @include('scripts.modal')
@endsection

@section('conteudo')
<div class="row container-fluid">
    <div class="col-md-12 col-md-offset-0">
        <div class="panel panel-default">
            <div class="panel-heading">Controle de Faltas</div>
            <div class="panel-body">
                <div class="row col-md-12 col-md-offset-0">
                    
                    @include('layout.flash')

                    @if($faltasFiltradas->count() == 0 && empty($pesquisa))
                        <div class="alert alert-danger btn-lg col-md-8 col-md-offset-2 danger text-center">
                            Você não possui nenhuma falta cadastrada.
                        </div>

                        <div class="row col-md-2 col-md-offset-5">
                            <div class="form-group text-center text-uppercase">
                                <a href="{{route('falta.create')}}" class="btn btn-block btn-lg btn-primary">
                                    <span class="glyphicon glyphicon-plus"></span> Falta
                                </a>   
                            </div>
                        </div>
                    @elseif($faltasFiltradas->count() == 0 && !empty($pesquisa) )
                        <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 text-center">
                            Nenhuma falta foi encontrada para o/a professor(a): <b class="text-uppercase"> {{$pesquisa}}</b>.
                        </div>

                        <div class="row col-md-2 col-md-offset-0">
                            <div class="form-group text-center text-uppercase">
                                <a href="{{route('falta.show.funcionario')}}" class="btn btn-block btn-lg btn-primary">
                                    <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                </a>   
                            </div>
                        </div>
                    @else

                    <div class="row col-md-8 col-md-offset-0">
                          <form method="GET" action="{{route('falta.show.funcionario')}}">
                            <div class="form-group col-md-8">
                                <div class="input-group">
                                    <input type="text" class="form-control input-lg text-uppercase" name="pesquisa" value="{{old('pesquisa','')}}" id="pesquisa" placeholder="Pesquise pelo nome do professor" />
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary"><span class="glyphicon glyphicon-search"></span></button>
                                    </div>

                                </div>
                            </div>   
                          </form>
                     </div>

                    <div class="table-responsive col-md-12" id="tabela-update">
                        <div class="row col-md-12 col-md-offset-0">
                            <div class="form-group pull-right">
                                <a href="{{route('falta.create')}}" class="btn btn-primary text-uppercase" >
                                    <span class="glyphicon glyphicon-plus"></span> Falta
                                </a>
                            </div>  
                        </div>

                        <div class="row col-md-12 col-md-offset-0 align-left">     
                            <div class="col cliente-labels">                                        
                                <p><i class="fa fa-square" style="color: #FFA500;"></i><span>Aguardando Aprovação</span></p>
                       
                            </div>
                        </div>

                        <table class="table table-striped bunitu">
                            <thead class="btn-primary">
                                <tr class="row text-uppercase">
                                    <th class="text-center">Professor</th>
                                    <th class="text-center">Disciplina</th>
                                    <th class="text-center">Turma</th>
                                    <th class="text-center">Quantidade</th>
                                    <th class="text-center">Dia</th>
                                    <th class="text-center">Justificativa</th>
                                    <th class="text-center">Situação</th>
                                </tr>
                            </thead>
                            @foreach($faltasFiltradas as $falta)

                                <tr class="row text-uppercase">
                                    <td class="text-center" style="vertical-align: middle;"> {{ $falta->professor }} </td>
                                    <td class="text-center" style="vertical-align: middle;"> {{ $falta->disciplina }} </td>
                                    <td class="text-center" style="vertical-align: middle;"> {{ $falta->turma }} </td>
                                    <td class="text-center" style="vertical-align: middle;"> {{ $falta->qtd }} </td>
                                    <td class="text-center" style="vertical-align: middle;"> {{ implode("/", array_reverse(explode("-", $falta->dia))) }} </td>
                                    <td class="text-center" style="vertical-align: middle;"> {{ $falta->obs or '-'}} </td>
                                    <td class="text-center">
                                        @if($falta->situacao == 'ESP')
                                            <a class="action" style="background-color: #FFA500; color: #FFA500;">
                                                <span class="fa fa-square"></span>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </table>

                        {{ $faltasFiltradas->appends(['pesquisa' => $pesquisa])->links() }}

                    </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>
    @include('layout.modal')
@endsection