@extends('layout.base')

@section('titulo','Controle de Cursos')

@section('scripts')
    @include('scripts.modal')
@endsection

@section('conteudo')
        <div class="row container-fluid">
            <div class="col-md-12 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row col-md-12 col-md-offset-0">
                            
                            @include('layout.flash')

                            @if($cursos->count() == 0 && empty($pesquisa))
                                <div class="alert alert-danger btn-lg col-md-8 col-md-offset-2 danger text-center">
                                    Você não possui nenhum curso cadastrado.
                                </div>

                                <div class="row col-md-2 col-md-offset-5">
                                    <div class="form-group text-center text-uppercase">
                                        <a href="{{route('semestre.create')}}" class="btn btn-block btn-lg btn-primary">
                                            <span class="glyphicon glyphicon-plus"></span> Curso
                                        </a>   
                                    </div>
                                </div>
                            @elseif($cursos->count() == 0 && !empty($pesquisa) )
                                <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 text-center">
                                    Nenhum curso foi encontrado para a Pesquisa: <b class="text-uppercase">{{$pesquisa}}</b>.
                                </div>

                                <div class="row col-md-2 col-md-offset-5">
                                    <div class="form-group text-uppercase text-center">
                                        <a href="{{route('curso.show')}}" class="btn btn-block btn-lg btn-primary">
                                            <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                        </a>   
                                    </div>
                                </div>
                            @else

                            <div class="row col-md-8 col-md-offset-0">
                                  <form method="GET" action="{{route('curso.show')}}">
                                    <div class="form-group col-md-8">
                                        <div class="input-group">
                                            <input type="text" class="form-control input-lg text-uppercase" name="pesquisa" value="{{old('pesquisa','')}}" id="pesquisa" placeholder="Pesquise pelo nome do curso" />
                                            <div class="input-group-btn">
                                                <button class="btn btn-primary"><span class="glyphicon glyphicon-search"></span></button>
                                            </div>

                                        </div>
                                    </div>   
                                  </form>
                             </div>

                            <div class="table-responsive col-md-12">
                                <div class="row col-md-12 col-md-offset-0">
                                    <div class="form-group pull-right">
                                        <a href="{{route('curso.create')}}" class="btn btn-primary text-uppercase" >
                                            <span class="glyphicon glyphicon-plus"></span> Curso
                                        </a>
                                    </div>  
                                </div>
                                <table class="table table-striped bunitu">
                                    <thead class="btn-primary">
                                        <tr class="row text-uppercase">
                                            <th class="text-center" style="vertical-align: middle;">Nome</th>
                                            <th class="text-center" style="vertical-align: middle;">Sigla</th>
                                            <th class="text-center" style="vertical-align: middle;">Tipo</th>
                                            <th class="text-center" style="vertical-align: middle;">Coordenador</th>
                                            <th class="text-center" style="vertical-align: middle;">Ação</th>
                                        </tr>
                                    </thead>
                                    @foreach($cursos as $curso)
                                        
                                        <tr class="row text-uppercase">
                                            <td class="text-center" style="vertical-align: middle;"> {{ $curso->nome }} </td>
                                            <td class="text-center" style="vertical-align: middle;"> {{ $curso->sigla }} </td>
                                            <td class="text-center" style="vertical-align: middle;"> {{ $curso->tipo }} </td>
                                            <td class="text-center" style="vertical-align: middle;"> {{ $curso->coordenador->usuario->username or '-' }} </td>
                                            <td class="text-center" style="vertical-align: middle;">
                                                <div class="btn-group btn-group-xs btn-group-vertical btn-block">
                                                    <a class='btn btn-info' href="{{route('curso.edit',$curso->id)}}">
                                                        <span class="glyphicon glyphicon-edit"></span> Editar
                                                    </a>
                                                    <a class="btn"></a>
                                                    
                                                    <a type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal" data-entidade="curso" data-url="{{route('curso.delete',$curso->id)}}">
                                                        <span class="glyphicon glyphicon-remove" ></span> Excluir
                                                    </a> 
                                                </div>

                                            </td>
                                        </tr>
                                    @endforeach
                                </table>

                                {{ $cursos->appends(['pesquisa' => $pesquisa])->links() }}
                            </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @include('layout.modal')
@endsection