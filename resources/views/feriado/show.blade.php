@extends('layout.base')

@section('titulo','Controle de Feriados')

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

                            @if($feriados->count() == 0 && empty($pesquisa))
                                <div class="alert alert-danger btn-lg col-md-8 col-md-offset-2 danger text-center">
                                    Você não possui nenhum feriado cadastrado.
                                </div>

                                <div class="row col-md-2 col-md-offset-5">
                                    <div class="form-group text-center text-uppercase">
                                        <a href="{{route('feriado.create')}}" class="btn btn-block btn-lg btn-primary">
                                            <span class="glyphicon glyphicon-plus"></span> feriado
                                        </a>   
                                    </div>
                                </div>
                            @elseif($feriados->count() == 0 && !empty($pesquisa) )
                                <div class="alert alert-info btn-lg col-md-8 col-md-offset-2 text-center">
                                    Nenhum feriado foi encontrado para a Pesquisa: <b class="text-uppercase">{{$pesquisa}}</b>.
                                </div>

                                <div class="row col-md-2 col-md-offset-5">
                                    <div class="form-group text-uppercase text-center">
                                        <a href="{{route('feriado.show')}}" class="btn btn-block btn-lg btn-primary">
                                            <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                        </a>   
                                    </div>
                                </div>
                            @else

                            <div class="row col-md-8 col-md-offset-0">
                                  <form method="GET" action="{{route('feriado.show')}}">
                                    <div class="form-group col-md-8">
                                        <div class="input-group">
                                            <input type="text" class="form-control input-lg text-uppercase" name="pesquisa" value="{{old('pesquisa','')}}" id="pesquisa" placeholder="Pesquise pelo nome do feriado" />
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
                                        <a href="{{route('feriado.create')}}" class="btn btn-primary text-uppercase" >
                                            <span class="glyphicon glyphicon-plus"></span> feriado
                                        </a>
                                    </div>  
                                </div>
                                <table class="table table-striped bunitu">
                                    <thead class="btn-primary">
                                        <tr class="row text-uppercase">
                                            <th class="text-center" style="vertical-align: middle;">Nome</th>
                                            <th class="text-center" style="vertical-align: middle;">Data</th>
                                            <th class="text-center" style="vertical-align: middle;">Data Término</th>
                                            <th class="text-center" style="vertical-align: middle;">Ação</th>
                                        </tr>
                                    </thead>
                                    @foreach($feriados as $feriado)
                                        
                                        <tr class="row text-uppercase">
                                            <td class="text-center" style="vertical-align: middle;"> {{ $feriado->nome }} </td>
                                            <td class="text-center" style="vertical-align: middle;">
                                                @if(!empty($feriado->data)) 
                                                    @php echo date('d/m/Y' , strtotime($feriado->data) ) @endphp
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="text-center" style="vertical-align: middle;">
                                                @if(!empty($feriado->final)) 
                                                    @php echo date('d/m/Y' , strtotime($feriado->final) ) @endphp
                                                @else
                                                    -
                                                @endif
                                            </td>

                                            <td class="text-center" style="vertical-align: middle;">
                                                
                                                <div class="btn-group btn-group-xs btn-group-vertical btn-block">
                                                    <a class='btn btn-info' href="{{route('feriado.edit',$feriado->id)}}">
                                                        <span class="glyphicon glyphicon-edit"></span> Editar
                                                    </a>
                                                    <a class="btn"></a>

                                                    <a type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal" data-entidade="feriado" data-url="{{route('feriado.delete',$feriado->id)}}">
                                                        <span class="glyphicon glyphicon-remove" ></span> Excluir
                                                    </a>
          
                                                </div>

                                            </td>
                                        </tr>
                                    @endforeach
                                </table>

                                {{ $feriados->appends(['pesquisa' => $pesquisa])->links() }}
                            </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @include('layout.modal')
@endsection