@extends('layout.base')

@section('titulo','Cadastrar Feriado')

@section('scripts')
    @include('scripts.feriado')
@endsection

@section('conteudo')
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Cadastrar Feriado</div>
                    <div class="panel-body">

                        <form class="form-horizontal" role="form" method="POST" action="{{route('feriado.store')}}">
                           
                           <div class="row col-md-12 col-md-offset-0">
                                <div class="form-group col-md-6 {{ $errors->has('nome') ? ' has-error' : '' }}">
                                    <label class="col-md-3 control-label" for="ano">Nome:</label>
                                    <div class="col-md-8">
                                        <input id="nome" name="nome" maxlength="160" value="{{ old('nome'), '' }}" class="form-control input-md text-uppercase" type="text">

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
                                            @if(old('tipo')=="1")
                                                <option data-tokens="ketchup mustard" value="{{old('tipo')}}" selected> FERIADO </option>
                                            @elseif(old('tipo')=="2")
                                                <option data-tokens="ketchup mustard" value="{{old('tipo')}}" selected> FÉRIAS </option>
                                            @elseif(old('tipo')=="3")
                                                <option data-tokens="ketchup mustard" value="{{old('tipo')}}" selected> RECESSO ESCOLAR </option>
                                            @else
                                                <option data-tokens="ketchup mustard" value="0" selected> SELECIONE..</option>
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
                                    <label for="inicio" class="col-md-3 control-label">Data: </label>

                                    <div class="col-md-8">
                                        <input id="inicio" type="date" class="form-control" name="inicio" value="{{ old('inicio') }}">

                                        @if ($errors->has('inicio'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('inicio') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div id="esconder" class="form-group col-md-6 {{ $errors->has('fim') ? ' has-error' : '' }} esconder" style="display: none;">
                                    <label for="fim" class="col-md-3 control-label">Data Término: </label>

                                    <div class="col-md-8">
                                        <input id="fim" type="date" class="form-control" name="fim" value="{{ old('fim') }}">

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
                                        <button type="submit" class="btn btn-block btn-lg btn-success">
                                            Cadastrar
                                        </button>     
                                </div>

                                <div class="form-group col-md-2" ></div>

                                <div class="form-group col-md-5">
                                    <a href="{{route('home')}}" class="btn btn-block btn-lg btn-danger">
                                        Cancelar
                                    </a>   
                                </div>
                            </div>

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        </form>

                    </div>
                </div>
            </div>
@endsection