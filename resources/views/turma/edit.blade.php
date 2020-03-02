@extends('layout.base')

@section('titulo','Editar Turma')

@section('scripts')
    @include('scripts.turma')
    @include('scripts.validation-turma')  
    @include('scripts.outros')
@endsection

@section('conteudo')
<div class="col-md-10 col-md-offset-1">
    <div class="panel panel-default">
        <div class="panel-heading">Editar Turma</div>
        <div class="panel-body">
            <form id="CadTurma" class="form-horizontal editar" role="form" method="POST" action="{{route('turma.update',$turmaEdit->id)}}">
               
               <div class="row col-md-12">

                    <div class="form-group col-md-6 {{ $errors->has('periodo') ? ' has-error' : '' }} periodo1">
                        <label class="col-md-4 control-label" for="periodo">Periodo:</label>
                        <div class="col-md-8">
                            <select class="selectpicker form-control" name="periodo" id="periodo" data-curso="{{Auth::user()->professor->curso->id}}" data-optativa="0">
                                <option data-tokens="ketchup mustard" value="{{$turmaEdit->periodo}}" selected> {{$turmaEdit->periodo}} </option>

                                @for ($i = 1; $i <= auth()->user()->professor->curso->duracao; $i++)

                                    @if(old('periodo'))
                                        <option data-tokens="ketchup mustard" value="{{old('periodo')}}" selected> {{old('periodo')}} </option>
                                    @endif

                                    <option data-tokens="ketchup mustard" value="{{$i}}" > {{$i}} </option>
                                @endfor
                            </select>
                                
                            @if ($errors->has('periodo'))
                                <span class="help-block">
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
                                
                                <option data-tokens="ketchup mustard" value="{{$turmaEdit->turno}}" selected>
                                    @if($turmaEdit->turno == 'M')
                                        MANHÃ
                                    @elseif($turmaEdit->turno == 'T')
                                        TARDE
                                    @elseif($turmaEdit->turno == 'N')
                                        NOITE
                                    @elseif($turmaEdit->turno == 'D')
                                        DIURNO
                                    @endif
                                </option>

                                @foreach ($turnos as $turAbr => $turno)
                                    @if(old('turno') == $turAbr)
                                        <option data-tokens="ketchup mustard" value="{{$turAbr}}" selected> {{$turno}} </option>
                                    @endif

                                    <option data-tokens="ketchup mustard" value="{{$turAbr}}"> {{$turno}} </option>
                                @endforeach
                            </select>

                            @if ($errors->has('turno'))
                                <span class="help-block">
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
                                <option data-tokens="ketchup mustard" value="{{$turmaEdit->semestre->id}}" selected> {{$turmaEdit->semestre->ano}}.{{$turmaEdit->semestre->etapa}} - {{$turmaEdit->semestre->tipo}}</option>
                                    @foreach ($semestresAtivo as $semestre)
                                        @if(old('semestre') == $semestre->id)
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

                    <div id="esconder" class="form-group col-md-6 qtd" style="display: none;">
                        <label for="qtd" class="col-md-4 control-label">Optativas:</label>
                        <div class="col-md-8">
                            <input id="qtd" type="text" class="form-control" maxlength="2" name="qtd" placeholder="N° de Optativas desse periodo"                                   
                                @if(!empty(old('qtd'))) 
                                    value="{{ old('qtd') }}"
                                @else 
                                    value="{{ $turmaEdit->optativas->count() }}" 
                                @endif
                            />

                            <span class="help-block">
                                <strong id="qtd1"></strong>
                            </span>
                        </div>
                    </div> 
                </div>

                <div class="form-group col-md-12" ></div>
                <div class="form-group col-md-12" ></div>

                <div id="disciplinasOptativas" class="row col-md-12" style="display: none">
                    @if(!empty($disciplinasOptativas) )                                
                        <div class="titulo" id="titulo" data-qtdOptativas="{{$disciplinasOptativas->count()}}"> 
                            <h4 class="text-center">Selecione a(s) disciplina(s) optativa(s) ofertada(s):</h4>
                        </div>

                        <div class="form-group col-md-12"></div>

                        @foreach($turmaEdit->optativas as $discOpt)
                            <div class="form-group col-md-12 optativa{{$loop->iteration}}">
                                <label for="optativa{{$loop->iteration}}" class="col-md-2 col-md-offset-1 control-label">Optativa {{$loop->iteration}}:</label>
                                <div class="col-md-8">
                                    <select class="selectpicker form-control text-uppercase" name="optativa[]" id="optativa{{$loop->iteration}}">
                                        @foreach ($disciplinasOptativas as $disciplinaOptativa)

                                            @if($disciplinaOptativa->id == $discOpt->disciplina->id)
                                                <option data-tokens="ketchup mustard" value="{{$discOpt->disciplina->id}}" selected> {{$discOpt->disciplina->nome}} </option>
                                            @endif

                                            @if(old('optativa.$i') == $discOpt->id)
                                                <option data-tokens="ketchup mustard" value="{{$discOpt->disciplina->id}}" selected> {{$discOpt->disciplina->nome}} </option>
                                            @endif
                                            <option data-tokens="ketchup mustard" value="{{$disciplinaOptativa->id}}"> {{$disciplinaOptativa->nome}} </option>
                                        @endforeach
                                    </select>

                                    <span class="form-group col-md-12">
                                        <strong id="optativa{{$loop->iteration}}{{$loop->iteration}}"></strong>
                                    </span>
                                </div>
                            </div>
                        @endforeach

                    @endif
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
                        <a href="{{route('turma.show')}}" class="btn btn-block btn-lg btn-danger">
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