@extends('layout.base')

@section('titulo','Gráficos')

@section('scripts')
    @include('scripts.grafico')
@endsection

@section('conteudo')
<div class="row container-fluid">
    <div class="col-md-12 col-md-offset-0">
        <div class="panel panel-default">
            <div class="panel-heading">Gráficos</div>
            <div class="panel-body">
                <div class="row col-md-12 col-md-offset-0">
                    
                    @include('layout.flash')

                    <div class="row col-md-12">

                        <div class="form-group col-md-6 {{ $errors->has('ano1') ? ' has-error' : '' }}">
                            <label for="ano1" class="col-md-2 control-label">Ano: </label>

                            <div class="col-md-8">
                                <select class="selectpicker form-control text-uppercase" name="ano1" id="ano1">
                                    <option data-tokens="ketchup mustard" value="0" selected> --- SELECIONE O ANO --- </option>
                                    @foreach($anos as $anoAbr => $ano)
                                        @if(old('ano1') == $anos[$anoAbr]->ano)
                                            <option data-tokens="ketchup mustard" value="{{$anos[$anoAbr]->ano}}" selected> {{ $anos[$anoAbr]->ano }} </option>
                                        @endif
                                        <option data-tokens="ketchup mustard" value="{{$anos[$anoAbr]->ano}}">{{ $anos[$anoAbr]->ano }}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('ano1'))
                                    <span class="help-block">
                                         <strong>{{ $errors->first('ano1') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group col-md-6 {{ $errors->has('semestre1') ? ' has-error' : '' }}">
                            <label for="semestre1" class="col-md-3 control-label">Semestre: </label>

                            <div class="col-md-9">
                                <select class="form-control text-uppercase" data-dependent="professor" data-live-search="true" id="semestre1" name="semestre1">
                                    <option data-tokens="ketchup mustard" value="0" selected> --- SELECIONE O SEMESTRE --- </option>
                                </select>

                                @if ($errors->has('semestre1'))
                                    <span class="help-block">
                                         <strong>{{ $errors->first('semestre1') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                    </div>

                    <div id="table-grafico" class="col-md-8 col-md-offset-2" style="display: none">
                        <a href="#" id="visualizar-graficoFalta" data-url="{{route('grafico.falta')}}" style="text-decoration: none; font-weight: bold;" >
                            <div class="col-md-6">
                                <div class="panel panel-default" align="center">
                                    <div class="panel-heading">VISUALIZAR GRÁFICOS</div>
                                    <div class="panel-body" style="text-align: center;">
                                        <i class="glyphicon glyphicon-eye-open" style = "font-size: 50px"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                     
                        <a href="#" id="download-graficoFalta" data-url="{{route('grafico.falta',['download' => 'true'])}}" style="text-decoration: none; font-weight: bold;">
                            <div class="col-md-6">
                                <div class="panel panel-default" align="center">
                                    <div class="panel-heading">DOWNLOAD GRÁFICOS</div>
                                    <div class="panel-body" style="text-align: center;">
                                        <i class="glyphicon glyphicon-download" style = "font-size: 50px"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection