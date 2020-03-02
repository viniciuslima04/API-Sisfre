@extends('layout.base')

@section('titulo','Controle de Disciplinas')

@section('scripts')
    @include('scripts.modal')
    @include('scripts.disciplina-show')
@endsection

@section('conteudo')
    <div class="row container-fluid">
        <div class="col-md-12 col-md-offset-0">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row col-md-12 col-md-offset-0">
                        
                        @include('layout.flash')

                        @if($disciplinas->count() == 0 && empty($pesquisa) && empty($curso) && empty($periodo) )
                            <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 danger text-center">
                                Não há disciplinas cadastradas no sistema.
                            </div>

                            <div class="row col-md-2 col-md-offset-5">
                                <div class="form-group text-center text-uppercase">
                                    <a href="{{route('disciplina.create')}}" class="btn btn-block btn-lg btn-primary">
                                        <span class="glyphicon glyphicon-plus"></span> Disciplina


                                    </a>   
                                </div>
                            </div>
                        
                        @elseif($disciplinas->count() == 0 && !empty($pesquisa) && !empty($curso) && !empty($periodo) )
                            <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 text-center">
                                Nenhuma disciplina: <b class="text-uppercase">{{$pesquisa}}</b> encontrada para o curso:<br> 
                                <b class="text-uppercase"> {{$curso->nome}}</b> no semestre: <b class="text-uppercase"> {{$periodo}} </b>.
                            </div>

                            <div class="row col-md-2 col-md-offset-0">
                                <div class="form-group text-center text-uppercase">
                                    <a href="{{route('disciplina.show')}}" class="btn btn-block btn-lg btn-primary">
                                        <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                    </a>   
                                </div>
                            </div>
                        
                        @elseif($disciplinas->count() == 0 && !empty($pesquisa) && empty($curso) && empty($periodo) )
                            <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 text-center">
                                Nenhuma disciplina: <b class="text-uppercase">{{$pesquisa}}</b> foi encontrada no sistema.
                            </div>

                            <div class="row col-md-2 col-md-offset-0">
                                <div class="form-group text-center text-uppercase">
                                    <a href="{{route('disciplina.show')}}" class="btn btn-block btn-lg btn-primary">
                                        <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                    </a>   
                                </div>
                            </div>
                        
                        @elseif($disciplinas->count() == 0 && !empty($pesquisa) && !empty($curso) && empty($periodo))
                            <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 text-center">
                                 Nenhuma disciplina: <b class="text-uppercase">{{$pesquisa}}</b> foi encontrada para o curso: <b class="text-uppercase">{{$curso->nome}}</b>.
                            </div>

                            <div class="row col-md-2 col-md-offset-0">
                                <div class="form-group text-center text-uppercase">
                                    <a href="{{route('disciplina.show')}}" class="btn btn-block btn-lg btn-primary">
                                        <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                    </a>   
                                </div>
                            </div>

                        @elseif($disciplinas->count() == 0 && !empty($pesquisa) && empty($curso) && !empty($periodo))
                            <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 text-center">
                                 Nenhuma disciplina: <b class="text-uppercase">{{$pesquisa}}</b> foi encontrada para o semestre: <b class="text-uppercase">{{$periodo}}</b>.
                            </div>

                            <div class="row col-md-2 col-md-offset-0">
                                <div class="form-group text-center text-uppercase">
                                    <a href="{{route('disciplina.show')}}" class="btn btn-block btn-lg btn-primary">
                                        <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                    </a>   
                                </div>
                            </div>

                        @elseif($disciplinas->count() == 0 && empty($pesquisa) && !empty($curso) && !empty($periodo))
                            <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 text-center">
                                Nenhuma disciplina encontrada para o curso:<br> <b class="text-uppercase"> {{$curso->nome}}</b> no semestre: <b class="text-uppercase"> {{$periodo}} </b>.
                            </div>
                            <div class="row col-md-2 col-md-offset-0">
                                <div class="form-group text-center text-uppercase">
                                    <a href="{{route('disciplina.show')}}" class="btn btn-block btn-lg btn-primary">
                                        <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                    </a>   
                                </div>
                            </div>

                        @elseif($disciplinas->count() == 0 && empty($pesquisa) && empty($curso) && !empty($periodo))
                            <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 text-center">
                                Nenhuma disciplina foi encontrada para o semestre: <b class="text-uppercase">{{$etapa}} </b>.
                            </div>

                            <div class="row col-md-2 col-md-offset-0">
                                <div class="form-group text-center text-uppercase">
                                    <a href="{{route('disciplina.show')}}" class="btn btn-block btn-lg btn-primary">
                                        <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                    </a>   
                                </div>
                            </div>

                        @elseif($disciplinas->count() == 0 && empty($pesquisa) && !empty($curso) && empty($periodo))
                            <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 text-center">
                                Nenhuma disciplina foi encontrada para o curso: <b class="text-uppercase">{{$curso->nome}}</b>.
                            </div>

                            <div class="row col-md-2 col-md-offset-0">
                                <div class="form-group text-center text-uppercase">
                                    <a href="{{route('disciplina.show')}}" class="btn btn-block btn-lg btn-primary">
                                        <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                    </a>   
                                </div>
                            </div>
                        
                        @else

                        <div id="container-pesquisar" class="row col-md-10 col-md-offset-1">
                              <form method="GET" action="{{route('disciplina.show')}}">
                                <div class="form-group col-md-6">
                                    <div class="input-group">
                                        <input type="text" class="form-control input-lg text-uppercase" name="pesquisa" value="{{old('pesquisa','')}}" id="pesquisa" placeholder="Pesquise pelo nome da disciplina" />
                                        <div class="input-group-btn">
                                            <button class="btn btn-primary"><span class="glyphicon glyphicon-search"></span></button>
                                        </div>

                                    </div>
                                </div>

                                <div class="form-group col-md-6 {{ $errors->has('curso') ? ' has-error' : '' }}">
                                    <label class="col-md-3 control-label" for="filtro">Curso:</label>
                                    <div class="col-md-9">
                                        <select class="selectpicker form-control text-uppercase" name="curso" id="curso">
                                            <option data-tokens="ketchup mustard" value="" selected> SEM FILTRO</option>
                                            @if(!empty($curso))
                                                <option data-tokens="ketchup mustard" value="{{$curso->id}}" data-semestres="{{$curso->duracao}}" selected>
                                                    {{$curso->nome}}
                                                </option>
                                            @endif

                                            @foreach($cursos as $curs)
                                                @if(old('curso') == $curs->id)
                                                    <option data-tokens="ketchup mustard" value="{{$curs->id}}" data-semestres="{{$curs->duracao}}" selected>{{$curs->nome}}</option> 
                                                @endif
                                                <option data-tokens="ketchup mustard" value="{{$curs->id}}" data-semestres="{{$curs->duracao}}">{{$curs->nome}}</option> 
                                            @endforeach
                                        </select>

                                        @if ($errors->has('curso'))
                                            <span class="help-block">
                                                 <strong>{{ $errors->first('curso') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group col-md-6 col-md-offset-6 {{ $errors->has('periodo') ? ' has-error' : '' }}">
                                    <label class="col-md-3 control-label" for="periodo">Semestre:</label>
                                    <div class="col-md-9">
                                        <select class="selectpicker form-control text-uppercase" name="periodo" id="periodo" disabled>
                                            <option data-tokens="ketchup mustard" value="" selected> SEM FILTRO </option>

                                        </select>

                                        @if ($errors->has('periodo'))
                                            <span class="help-block">
                                                 <strong>{{ $errors->first('periodo') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>  
                              </form>
                        </div>

                        <div class="table-responsive col-md-12">
                            <div class="row col-md-12 col-md-offset-0">
                                <div class="form-group pull-right">
                                    <a href="{{route('disciplina.create')}}" class="btn btn-primary text-uppercase" >
                                        <span class="glyphicon glyphicon-plus"></span> Disciplina
                                    </a>
                                </div>  
                            </div>
                            <table class="table table-striped bunitu">
                                <thead class="btn-primary">
                                    <tr class="row text-uppercase">
                                        <th class="text-center" style="vertical-align: middle;">Nome</th>
                                        <th class="text-center" style="vertical-align: middle;">Sigla</th>
                                        <th class="text-center" style="vertical-align: middle;">Cursos</th>
                                        <th class="text-center" style="vertical-align: middle;">Ação</th>
                                    </tr>
                                </thead>
                                @foreach($disciplinas as $disciplina)
                                    
                                    <tr class="row text-uppercase">
                                        <td class="text-center" style="vertical-align: middle;"> {{ $disciplina->nome }} </td>
                                        <td class="text-center" style="vertical-align: middle;"> {{ $disciplina->sigla }} </td>
                                        <td class="text-center" style="vertical-align: middle;">

                                            @foreach($disciplina->cursos->unique() as $curs)
                                                {{$curs->nome}} <br>
                                            @endforeach
                                        </td>
                                        <td class="text-center" style="vertical-align: middle;">
                                            <div class="btn-group-xs btn-group-vertical btn-block">
                                                <a class='btn btn-info' href="{{route('disciplina.edit',$disciplina->id)}}">
                                                    <span class="glyphicon glyphicon-edit"></span> Editar
                                                </a>
                                                <a class="btn"></a>
                                                
                                                <a type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal" data-entidade="disciplina" data-url="{{route('disciplina.delete',$disciplina->id)}}">
                                                    <span class="glyphicon glyphicon-remove" ></span> Excluir
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>

                            @if(empty($curso))
                                @php $cursoSelecionado = ''; @endphp
                            @else
                                @php $cursoSelecionado = $curso->id; @endphp
                            @endif

                            {{ $disciplinas->appends(['pesquisa' => $pesquisa, 'curso' => $cursoSelecionado, 'periodo' => $periodo])->links() }}
                        </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
    @include('layout.modal')
@endsection