@extends('layout.base')

@section('titulo','Controle de Semestres')

@section('scripts')
    @include('scripts.modal')
@endsection

@section('conteudo')
<div class="row container-fluid">
    <div class="col-md-12 col-md-offset-0">
        <div class="panel panel-default">
            <div class="panel-heading">Controle de Semestres</div>
            <div class="panel-body">
                <div class="row col-md-12 col-md-offset-0">
                    
                    @include('layout.flash')

                    @if($semestres->count() == 0 && empty($pesquisa) && empty($filtro) )
                        <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 danger text-center">
                            Não há nenhum semestre cadastrado no sistema.
                        </div>

                        <div class="row col-md-2 col-md-offset-5">
                            <div class="form-group text-center text-uppercase">
                                <a href="{{route('semestre.create')}}" class="btn btn-block btn-lg btn-primary">
                                    <span class="glyphicon glyphicon-plus"></span> Semestre
                                </a>   
                            </div>
                        </div>
                    @elseif($semestres->count() == 0 && !empty($pesquisa) && !empty($filtro) )
                        <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 text-center">
                            Nenhum semestre <b>
                                @if($filtro == 2)
                                    DESATIVADO
                                @elseif($filtro == 1)
                                    ATIVO
                                @endif 
                            </b> foi encontrado para o ano: <br><b class="text-uppercase"> {{$pesquisa}}</b> no sistema.
                        </div>

                        <div class="row col-md-2 col-md-offset-5">
                            <div class="form-group text-center text-uppercase">
                                <a href="{{route('semestre.show')}}" class="btn btn-block btn-lg btn-primary">
                                    <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                </a>   
                            </div>
                        </div>
                    @elseif($semestres->count() == 0 && !empty($pesquisa) && empty($filtro))
                        <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 text-center">
                            Nenhum semestre foi encontrado para o ano: <br> <b class="text-uppercase"> {{$pesquisa}}</b> no sistema.
                        </div>

                        <div class="row col-md-2 col-md-offset-5">
                            <div class="form-group text-center text-uppercase">
                                <a href="{{route('semestre.show')}}" class="btn btn-block btn-lg btn-primary">
                                    <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                </a>   
                            </div>
                        </div>
                    @elseif($semestres->count() == 0 && empty($pesquisa) && !empty($filtro))
                        <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 text-center">
                            Nenhum semestre <b>
                                @if($filtro == 2)
                                    DESATIVADO
                                @elseif($filtro == 1)
                                    ATIVO
                                @endif 
                            </b> foi encontrado no sistema.
                        </div>

                        <div class="row col-md-2 col-md-offset-0">
                            <div class="form-group text-center text-uppercase">
                                <a href="{{route('semestre.show')}}" class="btn btn-block btn-lg btn-primary">
                                    <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                </a>   
                            </div>
                        </div>
                    @else
                        <div class="row col-md-12 col-md-offset-0">
                            <form method="GET" action="{{route('semestre.show')}}">
                                <div class="form-group col-md-5">
                                    <div class="input-group">
                                        <input type="text" class="form-control input-lg text-uppercase" name="pesquisa" value="{{old('pesquisa','')}}" id="pesquisa" placeholder="Pesquise pelo ano do Semestre" />
                                        <div class="input-group-btn">
                                            <button class="btn btn-primary"><span class="glyphicon glyphicon-search"></span></button>
                                        </div>

                                    </div>
                                </div>

                                <div class="form-group col-md-5 col-md-offset-1 {{ $errors->has('filtro') ? ' has-error' : '' }}">
                                    <label class="col-md-2 control-label" for="filtro">Status:</label>
                                    <div class="col-md-8">
                                        <select class="selectpicker form-control text-uppercase" name="filtro" id="filtro">
                                            <option data-tokens="ketchup mustard" value="" selected>
                                                SEM FILTRO
                                            </option>
                                            @if(!empty($filtro))
                                                <option data-tokens="ketchup mustard" value="{{$filtro}}" selected>
                                                    @if($filtro == 1)
                                                        ATIVADO
                                                    @elseif($filtro == 2)
                                                        DESATIVADO
                                                    @endif 
                                                </option>
                                            @endif
                                            <option data-tokens="ketchup mustard" value="1" >ATIVADO</option>
                                            <option data-tokens="ketchup mustard" value="2" >DESATIVADO</option>
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
                                    <a href="{{route('semestre.create')}}" class="btn btn-primary text-uppercase" >
                                        <span class="glyphicon glyphicon-plus"></span> Semestre
                                    </a>
                                </div>  
                            </div>

                            <div class="row col-md-12 col-md-offset-0 align-left">     
                                <div class="col cliente-labels">                                        
                                    <p><i class="fa fa-square" style="color: #2E8B57;"></i><span>ATIVO</span></p>
                                    <p><i class="fa fa-square" style="color: #FF6347;"></i><span>DESATIVADO</span></p>
                                </div>
                            </div>

                            <table class="table table-striped bunitu" id="tabela-semestre">
                                <thead class="btn-primary">
                                    <tr class="row text-uppercase">
                                        <th class="text-center">Situação</th>
                                        <th class="text-center">Semestre</th>
                                        <th class="text-center">Tipo</th>
                                        <th class="text-center">Inicio</th>
                                        <th class="text-center">2ª etapa</th>
                                        <th class="text-center">Término</th>
                                        <th class="text-center">Ação</th>
                                    </tr>
                                </thead>
                                @foreach($semestres as $semestre)

                                    <tr class="row text-uppercase">
                                        <td class="text-center" style="vertical-align: middle;">
                                            @if($semestre->status == 1)
                                            <a class="action" style="background-color: #2E8B57; color: #2E8B57;">
                                                <span class="fa fa-square"></span>
                                            </a>
                                            @elseif($semestre->status == 2)
                                                <a class="action" style="background-color: #FF6347; color: #FF6347;">
                                                    <span class="fa fa-square"></span>
                                                </a>
                                            @endif
                                        </td>
                                        <td class="text-center" style="vertical-align: middle;">{{$semestre->ano}}.{{$semestre->etapa}}</td>
                                        <td class="text-center" style="vertical-align: middle;">{{$semestre->tipo}}</td>
                                        <td class="text-center" style="vertical-align: middle;">@php echo date('d/m/Y' , strtotime($semestre->inicio) ) @endphp</td>
                                        <td class="text-center" style="vertical-align: middle;">@php echo date('d/m/Y' , strtotime($semestre->metade) ) @endphp</td> 
                                        <td class="text-center" style="vertical-align: middle;">@php echo date('d/m/Y' , strtotime($semestre->fim) ) @endphp</td> 
                                        <td class="text-center">
                                            <div class="btn-group-xs btn-group-vertical btn-block" style="vertical-align: middle;">
                                                <a class='btn btn-info' href="{{route('semestre.edit',$semestre->id)}}">
                                                    <span class="glyphicon glyphicon-edit"></span> Editar
                                                </a>
                                                <a class="btn"></a>
                                                
                                                <a type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal" data-entidade="semestre" data-url="{{route('semestre.delete',$semestre->id)}}">
                                                    <span class="glyphicon glyphicon-remove" ></span> Excluir
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                            {{ $semestres->appends(['pesquisa' => $pesquisa])->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@include('layout.modal')

@endsection