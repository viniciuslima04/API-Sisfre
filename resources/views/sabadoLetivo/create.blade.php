@extends('layout.base')

@section('titulo','Cadastrar Sábado Letivo')

@section('conteudo')
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Cadastrar Sábado Letivo</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{route('sabado.store')}}">
                           
                           <div class="row col-md-12 col-md-offset-0">
                                <div class="form-group col-md-6 {{ $errors->has('tipo') ? ' has-error' : '' }}">
                                    <label for="tipo" class="col-md-3 control-label">Referente: </label>

                                    <div class="col-md-8">
                                        <select class="selectpicker form-control" name="tipo" id="tipo">
                                            @if(old('tipo')=="SEGUNDA")
                                                <option data-tokens="ketchup mustard" value="{{old('tipo')}}" selected> SEGUNDA </option>
                                            @elseif(old('tipo')=="TERÇA")
                                                <option data-tokens="ketchup mustard" value="{{old('tipo')}}" selected> TERÇA </option>
                                            @elseif(old('tipo')=="QUARTA")
                                                <option data-tokens="ketchup mustard" value="{{old('tipo')}}" selected> QUARTA </option>
                                            @elseif(old('tipo')=="QUINTA")
                                                <option data-tokens="ketchup mustard" value="{{old('tipo')}}" selected> QUINTA </option>
                                            @elseif(old('tipo')=="SEXTA")
                                                <option data-tokens="ketchup mustard" value="{{old('tipo')}}" selected> SEXTA </option>
                                            @else
                                                <option data-tokens="ketchup mustard" value="" selected> SELECIONE..</option>
                                            @endif
                                            <option data-tokens="ketchup mustard" value="SEGUNDA" > SEGUNDA </option>
                                            <option data-tokens="ketchup mustard" value="TERÇA" > TERÇA </option>
                                            <option data-tokens="ketchup mustard" value="QUARTA" > QUARTA </option>
                                            <option data-tokens="ketchup mustard" value="QUINTA" > QUINTA </option>
                                            <option data-tokens="ketchup mustard" value="SEXTA" > SEXTA </option>
                                        </select>

                                        @if ($errors->has('tipo'))
                                            <span class="help-block">
                                                 <strong>{{ $errors->first('tipo') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

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