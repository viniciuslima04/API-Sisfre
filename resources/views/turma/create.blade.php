@extends('layout.base')

@section('titulo','Cadastrar Turma')

@section('scripts')
    @include('scripts.turma')
    @include('scripts.validation-turma')   
@endsection

@section('conteudo')
<div class="col-md-10 col-md-offset-1">
    <div class="panel panel-default">
        <div class="panel-heading">Cadastrar Turma</div>
        <div class="panel-body">
            @if($errorSemestre && isset($errorSemestre))
                <div class="alert alert-warning btn-lg col-md-8 col-md-offset-2 danger text-center">
                    {{$errorSemestre}}
                </div>

                <div class="row col-md-2 col-md-offset-5">
                    <div class="form-group text-center text-uppercase">
                        <a href="{{route('home')}}" class="btn btn-block btn-lg btn-primary">
                            <span class="glyphicon glyphicon-home"></span> Home
                        </a>   
                    </div>
                </div>
            @else
                <form id="CadTurma" class="form-horizontal" role="form" method="POST" action="{{route('turma.store')}}">
                   
                   <div class="row col-md-12">

                        <div class="form-group col-md-6 {{ $errors->has('periodo') ? ' has-error' : '' }} periodo1">
                            <label class="col-md-4 control-label" for="periodo">Periodo:</label>
                            <div class="col-md-8">

                                    <select class="selectpicker form-control" name="periodo" id="periodo" data-curso="{{Auth::user()->professor->curso->id}}" data-optativa="0">
                                        <option data-tokens="ketchup mustard" value="0" selected> -- SELECIONE O PERIODO --</option>
                                        @if(old('periodo'))
                                            <option data-tokens="ketchup mustard" value="{{old('periodo')}}" selected> {{old('periodo')}} </option>
                                        @endif
                                        @for ($i = 1; $i <= auth()->user()->professor->curso->duracao; $i++)
                                            <option data-tokens="ketchup mustard" value="{{$i}}" > {{$i}} </option>
                                        @endfor
                                    </select>
                                    
                                @if ($errors->has('periodo'))
                                    <span class="help-block text-center">
                                         <strong>{{ $errors->first('periodo') }}</strong>
                                    </span>
                                @endif

                                <span id="error-periodo" class="help-block text-center" style="display: none;">
                                     <strong id="periodo1"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="form-group col-md-6 {{ $errors->has('turno') ? ' has-error' : '' }} turno1">
                            <label for="turno" class="col-md-4 control-label">Turno: </label>

                            <div class="col-md-8">
                                <select class="selectpicker form-control" name="turno" id="turno">
                                    <option data-tokens="ketchup mustard" value="0" selected> -- SELECIONE O TURNO --</option>
                                        @foreach ($turnos as $turAbr => $turno)
                                            @if(old('turno')== $turAbr)
                                                <option data-tokens="ketchup mustard" value="{{old('turno')}}" selected> {{$turno}} </option>
                                            @endif

                                            <option data-tokens="ketchup mustard" value="{{$turAbr}}"> {{$turno}} </option>
                                        @endforeach
                                </select>

                                @if ($errors->has('turno'))
                                    <span class="help-block text-center">
                                         <strong>{{ $errors->first('turno') }}</strong>
                                    </span>
                                @endif

                                <span id="error-turno" class="help-block text-center" style="display: none;">
                                     <strong id="turno1"></strong>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="row col-md-12">
                        <div class="form-group col-md-6 {{ $errors->has('semestre') ? ' has-error' : '' }} semestre1">
                            <label for="semestre" class="col-md-4 control-label">Semestre: </label>
                            <div class="col-md-8">
                                <select class="selectpicker form-control" name="semestre" id="semestre">
                                    <option data-tokens="ketchup mustard" value="0" selected> -- SELECIONE O SEMESTRE --</option>
                                        @foreach ($semestresAtivo as $semestre)
                                            @if(old('semestre')== $semestre->id)
                                                <option data-tokens="ketchup mustard" value="{{old('semestre')}}" selected> {{$semestre->ano}}.{{$semestre->etapa}} - {{$semestre->tipo}} </option>
                                            @endif

                                            <option data-tokens="ketchup mustard" value="{{$semestre->id}}"> {{$semestre->ano}}.{{$semestre->etapa}} - {{$semestre->tipo}} </option>
                                        @endforeach
                                </select>

                                @if ($errors->has('semestre'))
                                    <span class="help-block text-center">
                                         <strong>{{ $errors->first('semestre') }}</strong>
                                    </span>
                                @endif

                                <span id="error-semestre" class="help-block text-center" style="display: none;">
                                     <strong id="semestre1"></strong>
                                </span>
                            </div>
                        </div>

                        <div id="esconder" class="form-group col-md-6 qtd" style="display: none">
                            <label for="qtd" class="col-md-4 control-label">Optativas:</label>
                            <div class="col-md-8">
                                <input id="qtd" type="text" class="form-control" value="{{old('qtd')}}" maxlength="2" name="qtd" placeholder="N° de Optativas desse periodo">

                                <span class="help-block">
                                    <strong id="qtd1"></strong>
                                </span>
                            </div>
                        </div>  
                    </div>

                    <div class="form-group col-md-12" ></div>
                    <div class="form-group col-md-12" ></div>

                    <div id="disciplinasOptativas" class="row col-md-12" style="display: none">
                        
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
                            <a href="{{route('turma.show')}}" class="btn btn-block btn-lg btn-danger">
                                Cancelar
                            </a>   
                        </div>
                    </div>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
                </form>
            @endif
        </div>
    </div>
</div>
@endsection