@extends('layout.base')

@section('titulo','Editar Feriado')

@section('scripts')
    @include('scripts.feriado')
    @include('scripts.outros')
@endsection

@section('conteudo')
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Editar Feriado</div>
                    <div class="panel-body">
                        <form class="form-horizontal editar" role="form" method="POST" action="{{route('feriado.update',$feriado->id)}}">
                           
                           <div class="row col-md-12 col-md-offset-0">
                                <div class="form-group col-md-6 {{ $errors->has('nome') ? ' has-error' : '' }}">
                                    <label class="col-md-3 control-label" for="ano">Nome:</label>
                                    <div class="col-md-8">
                                        <input id="nome" name="nome" maxlength="160" class="form-control input-md text-uppercase" type="text"
                                        @if(!empty(old('nome'))) 
                                            value="{{ old('nome') }}"
                                        @else 
                                            value="{{ $feriado->nome }}" 
                                        @endif
                                        />

                                        @if ($errors->has('nome'))
                                            <span class="help-block">
                                                 <strong>{{ $errors->first('nome') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group col-md-6 {{ $errors->has('tipo') ? ' has-error' : '' }}">
                                    <label for="tipo" class="col-md-3 control-label">Tipo: </label>

                                    <div class="col-md-8">
                                        <select class="selectpicker form-control" name="tipo" id="tipo">
                                            <option data-tokens="ketchup mustard" value="{{$feriado->tipo}}" selected> 
                                                @if($feriado->tipo == 1)
                                                    FERIADO
                                                @elseif($feriado->tipo == 2)
                                                    FÉRIAS
                                                @elseif($feriado->tipo == 3)
                                                    RECESSO
                                                @endif
                                            </option>
                                            @if(old('tipo')=="1")
                                                <option data-tokens="ketchup mustard" value="{{old('tipo')}}" selected> FERIADO </option>
                                            @elseif(old('tipo')=="2")
                                                <option data-tokens="ketchup mustard" value="{{old('tipo')}}" selected> FÉRIAS </option>
                                            @elseif(old('tipo')=="3")
                                                <option data-tokens="ketchup mustard" value="{{old('tipo')}}" selected> RECESSO ESCOLAR </option>
                                            @endif
                                            <option data-tokens="ketchup mustard" value="1" > FERIADO </option>
                                            <option data-tokens="ketchup mustard" value="2" > FÉRIAS </option>
                                            <option data-tokens="ketchup mustard" value="3" > RECESSO </option>
                                        </select>

                                        @if ($errors->has('tipo'))
                                            <span class="help-block">
                                                 <strong>{{ $errors->first('tipo') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row col-md-12 col-md-offset-0">

                                <div class="form-group col-md-6 {{ $errors->has('inicio') ? ' has-error' : '' }}">
                                    <label for="inicio" class="col-md-3 control-label">DATA : </label>

                                    <div class="col-md-8">
                                        <input id="inicio" type="date" class="form-control" name="inicio"           
                                        @if(!empty(old('inicio'))) 
                                            value="{{ date('Y-m-d', strtotime(old('inicio')))}}"
                                        @else 
                                            value="{{ $feriado->data }}"
                                        @endif
                                            maxlength="10">

                                        @if ($errors->has('inicio'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('inicio') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div id="esconder" class="form-group col-md-6 {{ $errors->has('fim') ? ' has-error' : '' }}">
                                    <label class="col-md-3 control-label" for="fim">Data Término:</label>
                                    <div class="col-md-8">
                                        <input id="fim" type="date" class="form-control" name="fim"           
                                        @if(!empty(old('fim'))) 
                                            value="{{ date('Y-m-d', strtotime(old('fim')))}}"
                                        @else 
                                            value="{{ $feriado->final }}"
                                        @endif
                                            maxlength="10">
                                        @if ($errors->has('fim'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('fim') }}</strong>
                                        </span>
                                        @endif
                                    </div>

                                </div>
                            </div>

                            <div class="form-group col-md-12" ></div>
                            <div class="form-group col-md-12" ></div>

                            <div class="row col-md-7 col-md-offset-3">
                                <div class="form-group col-md-5">
                                    <button id="Editar" type="submit" class="btn btn-block btn-lg btn-success">
                                        Salvar
                                    </button>     
                                </div>

                                <div class="form-group col-md-2" ></div>

                                <div class="form-group col-md-5">
                                    <a href="{{route('feriado.show')}}" class="btn btn-block btn-lg btn-danger">
                                        Cancelar
                                    </a>   
                                </div>
                            </div>

                            <div class="row col-md-8 col-md-offset-2">
                                <div id="alert" class="text-center alert alert-danger alert-block" style="display: none">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong id="mensagem"></strong>
                                </div>
                            </div>

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="put"> 
                        </form>
                    </div>
                </div>
            </div>
@endsection