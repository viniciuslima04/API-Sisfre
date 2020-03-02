@extends('layout.base')

@section('titulo','Cadastrar Semestre')

@section('conteudo')
<div class="col-md-10 col-md-offset-1">
    <div class="panel panel-default">
        <div class="panel-heading">Cadastrar Semestre</div>
        <div class="panel-body">
            <form class="form-horizontal" role="form" method="POST" action="{{route('semestre.store')}}">
               
               <div class="row col-md-12">
                    <div class="form-group col-md-6 {{ $errors->has('ano') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label" for="ano">Ano:</label>
                        <div class="col-md-8">
                            <input id="ano" name="ano" maxlength="4" value="{{ old('ano'), '' }}" class="form-control input-md" type="text" placeholder="Ex: 2018">

                            @if ($errors->has('ano'))
                                <span class="help-block">
                                     <strong>{{ $errors->first('ano') }}</strong>
                                </span>
                            @endif
                        </div>

                    </div>

                    <div class="form-group col-md-6 {{ $errors->has('sem') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label" for="sem">Semestre:</label>
                        <div class="col-md-8">
                            <select class="selectpicker form-control" name="sem" id="sem">
                                <option data-tokens="ketchup mustard" value="" selected> -- SELECIONE A ETAPA -- </option>

                                @if(old('sem'))
                                    <option data-tokens="ketchup mustard" value="{{old('sem')}}" selected> {{old('sem')}} </option>
                                @endif
                                <option data-tokens="ketchup mustard" value="1" >1</option>
                                <option data-tokens="ketchup mustard" value="2" >2</option>
                            </select>

                            @if ($errors->has('sem'))
                                <span class="help-block">
                                     <strong>{{ $errors->first('sem') }}</strong>
                                </span>
                            @endif
                        </div>

                    </div>
                </div>

                <div class="row col-md-12">

                    <div class="form-group col-md-6 {{ $errors->has('inicio') ? ' has-error' : '' }}">
                        <label for="inicio" class="col-md-4 control-label">1ª Etapa: </label>

                        <div class="col-md-8">
                            <input id="inicio" type="date" class="form-control" name="inicio" value="{{ old('inicio') }}">

                            @if ($errors->has('inicio'))
                                <span class="help-block">
                                <strong>{{ $errors->first('inicio') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group col-md-6 {{ $errors->has('meio') ? ' has-error' : '' }}">
                        <label for="meio" class="col-md-4 control-label">2ª Etapa: </label>

                        <div class="col-md-8">
                            <input id="meio" type="date" class="form-control" name="meio" value="{{ old('meio') }}">

                            @if ($errors->has('meio'))
                                <span class="help-block">
                                <strong>{{ $errors->first('meio') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row col-md-12">

                    <div class="form-group col-md-6 {{ $errors->has('fim') ? ' has-error' : '' }}">
                        <label for="fim" class="col-md-4 control-label">Término : </label>

                        <div class="col-md-8">
                            <input id="fim" type="date" class="form-control" name="fim" value="{{ old('fim') }}">

                            @if ($errors->has('fim'))
                                <span class="help-block">
                                <strong>{{ $errors->first('fim') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group col-md-6 {{ $errors->has('tipo') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label" for="tipo">Tipo:</label>
                        <div class="col-md-8">
                            <select class="selectpicker form-control" name="tipo" id="tipo">
                                <option data-tokens="ketchup mustard" value="" selected> -- SELECIONE O TIPO -- </option>

                                @if(old('tipo'))
                                    <option data-tokens="ketchup mustard" value="{{old('tipo')}}" selected> {{old('tipo')}} </option>
                                @endif
                                <option data-tokens="ketchup mustard" value="CONVENCIONAL" >CONVENCIONAL</option>
                                <option data-tokens="ketchup mustard" value="REGULAR" >REGULAR</option>
                            </select>

                            @if ($errors->has('tipo'))
                                <span class="help-block">
                                     <strong>{{ $errors->first('tipo') }}</strong>
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
                
                @include('layout.flash')

                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="status" value="1">   
            </form>
        </div>
    </div>
</div>
@endsection
