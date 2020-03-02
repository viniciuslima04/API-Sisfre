@extends('layout.base')

@section('titulo','Editar Semestres')

@section('scripts')
    @include('scripts.outros')
@endsection

@section('conteudo')
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Editar Semestre</div>
                    <div class="panel-body">
                        <form class="form-horizontal editar" role="form" method="POST" action="{{route('semestre.update',$semestreEdit->id)}}">
                           
                           <div class="row col-md-12">
                                <div class="form-group col-md-6 {{ $errors->has('ano') ? ' has-error' : '' }}">
                                    <label class="col-md-4 control-label" for="ano">Ano:</label>
                                    <div class="col-md-8">
                                        <input id="ano" name="ano" maxlength="4" 
                                            @if(!empty(old('ano'))) 
                                                value="{{ old('ano') }}"
                                            @else 
                                                value="{{ $semestreEdit->ano }}" 
                                            @endif
                                        class="form-control input-md" type="text" readonly>
                                    
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
                                        <input id="sem" name="sem" maxlength="4" 
                                            @if(!empty(old('sem'))) 
                                                value="{{ old('sem') }}"
                                            @else 
                                                value="{{ $semestreEdit->etapa }}" 
                                            @endif
                                        class="form-control input-md" type="text" readonly>

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
                                        <input id="inicio" type="date" class="form-control" name="inicio" 
                                        @if(!empty(old('inicio'))) 
                                            value="{{ date('Y-m-d', strtotime(old('inicio')))}}"
                                        @else 
                                            value="{{ $semestreEdit->inicio }}" 
                                        @endif
                                            maxlength="10">

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
                                        <input id="meio" type="date" class="form-control" name="meio" 
                                        @if(!empty(old('meio'))) 
                                            value="{{ date('Y-m-d', strtotime(old('meio')))}}"
                                        @else 
                                            value="{{ $semestreEdit->metade }}"
                                        @endif
                                            maxlength="10">

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
                                        <input id="fim" type="date" class="form-control" name="fim"           @if(!empty(old('fim'))) 
                                            value="{{ date('Y-m-d', strtotime(old('fim')))}}"
                                        @else 
                                            value="{{ $semestreEdit->fim }}"
                                        @endif
                                            maxlength="10">
                                        @if ($errors->has('fim'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('fim') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group col-md-6 {{ $errors->has('status') ? ' has-error' : '' }}">
                                    <label class="col-md-4 control-label" for="status">Status:</label>
                                    <div class="col-md-8">
                                        <select class="selectpicker form-control" name="status" id="status">
                                            <option data-tokens="ketchup mustard" value="{{$semestreEdit->status}}" selected> 
                                                @if($semestreEdit->status == 1)
                                                        ATIVADO
                                                @else
                                                        DESATIVADO
                                                @endif
                                            </option>

                                            @if( !empty( old('status') ) )
                                                <option data-tokens="ketchup mustard" value="{{old('status')}}" selected>
                                                    @if(old('status') == 1)
                                                            ATIVADO
                                                    @else
                                                            DESATIVADO
                                                    @endif
                                                </option>
                                            @endif
                                            <option data-tokens="ketchup mustard" value="1" >ATIVADO</option>
                                            <option data-tokens="ketchup mustard" value="2" >DESATIVADO</option>
                                        </select>

                                        @if ($errors->has('status'))
                                            <span class="help-block">
                                                 <strong>{{ $errors->first('status') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                </div>

                            </div>

                            <div class="row col-md-12">
                                <div class="form-group col-md-6 {{ $errors->has('tipo') ? ' has-error' : '' }}">
                                    <label class="col-md-4 control-label" for="tipo">Tipo:</label>
                                    <div class="col-md-8">
                                        <select class="selectpicker form-control" name="tipo" id="tipo">
                                            <option data-tokens="ketchup mustard" value="{{$semestreEdit->tipo}}" selected> {{$semestreEdit->tipo}} </option>

                                            @if( !empty( old('tipo') ) )
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
                                    <button id="Editar" type="submit" class="btn btn-block btn-lg btn-success">
                                        Salvar
                                    </button>     
                                </div>

                                <div class="form-group col-md-2" ></div>

                                <div class="form-group col-md-5">
                                    <a href="{{route('semestre.show')}}" class="btn btn-block btn-lg btn-danger">
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
