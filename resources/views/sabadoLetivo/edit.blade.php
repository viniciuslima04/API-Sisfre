@extends('layout.base')

@section('titulo','Editar Sábado Letivo')

@section('scripts')
    @include('scripts.outros')
@endsection

@section('conteudo')
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Editar Sábado Letivo</div>
                    <div class="panel-body">

                        <form class="form-horizontal editar" role="form" method="POST" action="{{route('sabado.update',$sabado->id)}}">
                           
                           <div class="row col-md-12 col-md-offset-0">
                                <div class="form-group col-md-6 {{ $errors->has('tipo') ? ' has-error' : '' }}">
                                    <label for="tipo" class="col-md-3 control-label">Referente: </label>

                                    <div class="col-md-8">
                                        <select class="selectpicker form-control" name="tipo" id="tipo">
                                            <option data-tokens="ketchup mustard" value="{{$sabado->referente}}" selected> {{$sabado->referente}}</option>

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
                                    <label for="inicio" class="col-md-3 control-label">DATA : </label>

                                    <div class="col-md-8">
                                        <input id="inicio" type="date" class="form-control" name="inicio"           
                                        @if(!empty(old('inicio'))) 
                                            value="{{ date('Y-m-d', strtotime(old('inicio')))}}"
                                        @else 
                                            value="{{ $sabado->data }}"
                                        @endif
                                            maxlength="10">

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
                                    <button id="Editar" type="submit" class="btn btn-block btn-lg btn-success">
                                        Salvar
                                    </button>     
                                </div>

                                <div class="form-group col-md-2" ></div>

                                <div class="form-group col-md-5">
                                    <a href="{{route('sabado.show')}}" class="btn btn-block btn-lg btn-danger">
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