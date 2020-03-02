@extends('layout.base')

@section('titulo','Controle de Sábados Letivo')

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

                            @if($sabados->count() == 0 && empty($pesquisa))
                                <div class="alert alert-danger btn-lg col-md-8 col-md-offset-2 danger text-center">
                                    Você não possui nenhum sábado letivo cadastrado.
                                </div>

                                <div class="row col-md-3 col-md-offset-5">
                                    <div class="form-group text-center text-uppercase">
                                        <a href="{{route('sabado.create')}}" class="btn btn-block btn-lg btn-primary">
                                            <span class="glyphicon glyphicon-plus"></span> Sábado
                                        </a>   
                                    </div>
                                </div>
                            @elseif($sabados->count() == 0 && !empty($pesquisa) )
                                <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 text-center">
                                    Nenhum Sábado letivo foi encontrado para a Pesquisa: <b class="text-uppercase">{{$pesquisa}}</b>.
                                </div>

                                <div class="row col-md-2 col-md-offset-5">
                                    <div class="form-group text-uppercase text-center">
                                        <a href="{{route('sabado.show')}}" class="btn btn-block btn-lg btn-primary">
                                            <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                        </a>   
                                    </div>
                                </div>
                            @else

                            <div class="row col-md-8 col-md-offset-0">
                                  <form method="GET" action="{{route('sabado.show')}}">
                                    <div class="form-group col-md-8">
                                        <div class="input-group">
                                            <input type="text" class="form-control input-lg text-uppercase" name="pesquisa" value="{{old('pesquisa','')}}" id="pesquisa" placeholder="Pesquise pelo dia referente" />
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
                                        <a href="{{route('sabado.create')}}" class="btn btn-primary text-uppercase" >
                                            <span class="glyphicon glyphicon-plus"></span> Sábado
                                        </a>
                                    </div>  
                                </div>
                                <table class="table table-striped bunitu">
                                    <thead class="btn-primary">
                                        <tr class="row text-uppercase">
                                            <th class="text-center">Dia Referente</th>
                                            <th class="text-center">Data</th>
                                            <th class="text-center">Ação</th>
                                        </tr>
                                    </thead>
                                    @foreach($sabados as $sabado)
                                        
                                        <tr class="row text-uppercase">
                                            <td class="text-center" style="vertical-align: middle;"> {{ $sabado->referente }} </td>
                                            <td class="text-center" style="vertical-align: middle;">
                                                @if(!empty($sabado->data)) 
                                                    @php echo date('d/m/Y' , strtotime($sabado->data) ) @endphp
                                                @else
                                                    -
                                                @endif
                                            </td>

                                            <td class="btn-group btn-group-xs btn-group-vertical btn-block">
                                                <a class='btn btn-info' href="{{route('sabado.edit',$sabado->id)}}">
                                                    <span class="glyphicon glyphicon-edit"></span> Editar
                                                </a>
                                                <a class="btn"></a>
                                                
                                                <a type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal" data-entidade="sabado letivo" data-url="{{route('sabado.delete',$sabado->id)}}">
                                                    <span class="glyphicon glyphicon-remove" ></span> Excluir
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>

                                {{ $sabados->appends(['pesquisa' => $pesquisa])->links() }}
                            </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @include('layout.modal')
@endsection