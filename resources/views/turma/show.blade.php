@extends('layout.base')

@section('titulo','Controle de Turmas')

@section('scripts')
    @include('scripts.modal')
@endsection

@section('conteudo')
<div class="row container-fluid">
    <div class="col-md-12 col-md-offset-0">
        <div class="panel panel-default">
            <div class="panel-heading">Controle de Turmas</div>
            <div class="panel-body">
                <div class="row col-md-12 col-md-offset-0">
                    
                    @include('layout.flash')

                    @if($turmas->count() == 0 && empty($pesquisa) && empty($filtro) )
                        <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 danger text-center">
                            Não há nenhuma turma cadastrada no curso:<br> <b class="text-uppercase"> {{Auth::user()->professor->curso->nome}}</b>.
                        </div>

                        <div class="row col-md-2 col-md-offset-5">
                            <div class="form-group text-center text-uppercase">
                                <a href="{{route('turma.create')}}" class="btn btn-block btn-lg btn-primary">
                                    <span class="glyphicon glyphicon-plus"></span> Turma
                                </a>   
                            </div>
                        </div>
                    @elseif($turmas->count() == 0 && !empty($pesquisa) && !empty($filtro) )
                        <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 text-center">
                            Nenhuma Turma foi encontrada para o nome: <br><b class="text-uppercase"> {{$pesquisa}}</b> no semestre {{$filtro}} no sistema.
                        </div>

                        <div class="row col-md-2 col-md-offset-5">
                            <div class="form-group text-center text-uppercase">
                                <a href="{{route('turma.show')}}" class="btn btn-block btn-lg btn-primary">
                                    <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                </a>   
                            </div>
                        </div>
                    @elseif($turmas->count() == 0 && !empty($pesquisa) && empty($filtro))
                        <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 text-center">
                            Nenhuma turma foi encontrada com o nome: <br> <b class="text-uppercase"> {{$pesquisa}}</b> no sistema.
                        </div>

                        <div class="row col-md-2 col-md-offset-5">
                            <div class="form-group text-center text-uppercase">
                                <a href="{{route('turma.show')}}" class="btn btn-block btn-lg btn-primary">
                                    <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                </a>   
                            </div>
                        </div>
                    @elseif($turmas->count() == 0 && empty($pesquisa) && !empty($filtro))
                        <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 text-center">
                            Nenhuma turma cadastrada no semestre <b class="text-uppercase">{{$filtro}}</b> ativo.
                        </div>

                        <div class="row col-md-2 col-md-offset-0">
                            <div class="form-group text-center text-uppercase">
                                <a href="{{route('turma.show')}}" class="btn btn-block btn-lg btn-primary">
                                    <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                </a>   
                            </div>
                        </div>
                    @else
                        <div class="row col-md-12 col-md-offset-0">
                            <form method="GET" action="{{route('turma.show')}}">
                                <div class="form-group col-md-5">
                                    <div class="input-group">
                                        <input type="text" class="form-control input-lg text-uppercase" name="pesquisa" value="{{old('pesquisa','')}}" id="pesquisa" placeholder="Pesquise pelo nome da turma." />
                                        <div class="input-group-btn">
                                            <button class="btn btn-primary"><span class="glyphicon glyphicon-search"></span></button>
                                        </div>

                                    </div>
                                </div>

                                <div class="form-group col-md-5 col-md-offset-1 {{ $errors->has('filtro') ? ' has-error' : '' }}">
                                    <label class="col-md-2 control-label" for="filtro">Filtro:</label>
                                    <div class="col-md-8">
                                        <select class="selectpicker form-control text-uppercase" name="filtro" id="filtro">
                                        <option data-tokens="ketchup mustard" value="" selected >SEM FILTRO</option>
                                            @if(!empty($filtro))
                                                <option data-tokens="ketchup mustard" value="{{$filtro}}" selected>
                                                    {{$filtro}}
                                                </option>
                                            @endif
                                            <option data-tokens="ketchup mustard" value="CONVENCIONAL" >CONVENCIONAL</option>
                                            <option data-tokens="ketchup mustard" value="REGULAR" >REGULAR</option>
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

                        <div class="table-responsive col-md-12">
                            
                            <div class="row col-md-12 col-md-offset-0">
                                <div class="form-group pull-right">
                                    <a href="{{route('turma.create')}}" class="btn btn-primary text-uppercase" >
                                        <span class="glyphicon glyphicon-plus"></span> turma
                                    </a>
                                </div>  
                            </div>

                            <div class="row col-md-12 col-md-offset-0 align-left">     
                                <div class="col cliente-labels">                                        
                                    <p><i class="fa fa-square" style="color: #2E8B57;"></i><span>SEMESTRE CONVENCIONAL</span></p>
                                    <p><i class="fa fa-square" style="color: #FF6347;"></i><span>SEMESTRE REGULAR</span></p>
                                </div>
                            </div>

                            <table class="table table-striped bunitu">
                                <thead class="btn-primary">
                                    <tr class="row text-uppercase">
                                        <th class="text-center" style="vertical-align: middle;">Semestre</th>
                                        <th class="text-center" style="vertical-align: middle;">Nome</th>
                                        <th class="text-center" style="vertical-align: middle;">Turno</th>
                                        <th class="text-center" style="vertical-align: middle;">Periodo</th>
                                        <th class="text-center" style="vertical-align: middle;">Horário</th>
                                        <th class="text-center" style="vertical-align: middle;">Ação</th>
                                    </tr>
                                </thead>
                                @foreach($turmas as $turma)

                                    <tr class="row text-uppercase">

                                        <td class="text-center" style="vertical-align: middle;">
                                            @if($turma->semestre_tipo == "CONVENCIONAL")
                                            <a class="action" style="background-color: #2E8B57; color: #2E8B57;">
                                                <span class="fa fa-square"></span>
                                            </a>
                                            @elseif($turma->semestre_tipo == "REGULAR")
                                                <a class="action" style="background-color: #FF6347; color: #FF6347;">
                                                    <span class="fa fa-square"></span>
                                                </a>
                                            @endif
                                        </td>

                                        <td class="text-center" style="vertical-align: middle;"> {{ $turma->descricao}} </td>
                                        <td class="text-center" style="vertical-align: middle;">
                                            @if($turma->turno == 'M')
                                                MANHÃ
                                            @elseif($turma->turno == 'T')
                                                TARDE
                                            @elseif($turma->turno == 'N')
                                                NOITE
                                            @elseif($turma->turno == 'D')
                                                DIURNO
                                            @endif 
                                        </td>
                                        <td class="text-center" style="vertical-align: middle;"> {{ $turma->periodo}} </td>
                                        <td class="text-center" style="vertical-align: middle;">
                                            @if($turma->aulas->count() > 0 )
                                                <div class="btn-group-xs btn-group-vertical btn-block">
                                                    <a class='btn btn-info' href="{{route('horario.edit',$turma->id)}}">
                                                        <span class="glyphicon glyphicon-edit"></span> Editar
                                                    </a>  

                                                    <a class="btn"></a>
                                                    
                                                    <a class='btn btn-success' href="{{route('horario.show',$turma->id)}}">
                                                        <span class="glyphicon glyphicon-eye-open"></span> Visualizar
                                                    </a>
                                                </div>
                                            @else
                                                <div class="btn-group-xs btn-group-vertical btn-block">
                                                    <a class='btn btn-primary' href="{{route('horario.create',$turma->id)}}">
                                                        <span class="glyphicon glyphicon-plus-sign"></span> Montar
                                                    </a>
                                                </div>
                                            @endif 
                                        </td>
                                        <td class="text-center" style="vertical-align: middle;">
                                            <div class="btn-group-xs btn-group-vertical btn-block">
                                                <a class='btn btn-info' href="{{route('turma.edit',$turma->id)}}">
                                                    <span class="glyphicon glyphicon-edit"></span> Editar
                                                </a>

                                                <a class="btn"></a>
                                                
                                                <a type="button" class="btn btn-danger " data-toggle="modal" data-target="#modal" data-entidade="turma" data-url="{{route('turma.delete',$turma->id)}}">
                                                    <span class="glyphicon glyphicon-remove" ></span> Excluir
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                            {{ $turmas->appends(['pesquisa' => $pesquisa])->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@include('layout.modal')

@endsection